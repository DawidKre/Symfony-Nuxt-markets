<?php

namespace App\BusinessLogic\Scraper\Service;

use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\SharedLogic\Model\UnitType;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;
use App\Entity\ScraperLog;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DOMElement;
use Exception;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class ScraperManager.
 */
class ScraperManager
{
    /** @var GoutteClient */
    private $client;

    /** @var GuzzleClient */
    private $guzzleClient;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CsvWriterService */
    private $csvService;

    /** @var CheckerService */
    private $checkerService;

    /** @var SlackService */
    private $slackService;

    /**
     * @param GoutteClient           $client
     * @param GuzzleClient           $guzzleClient
     * @param EntityManagerInterface $entityManager
     * @param CsvWriterService       $csvService
     * @param CheckerService         $checkerService
     * @param SlackService           $slackService
     */
    public function __construct(
        GoutteClient $client,
        GuzzleClient $guzzleClient,
        EntityManagerInterface $entityManager,
        CsvWriterService $csvService,
        CheckerService $checkerService,
        SlackService $slackService
    ) {
        $this->client = $client;
        $this->guzzleClient = $guzzleClient;
        $this->entityManager = $entityManager;
        $this->csvService = $csvService;
        $this->checkerService = $checkerService;
        $this->slackService = $slackService;
    }

    /**
     * @throws ScraperException
     * @throws \Http\Client\Exception
     */
    public function scrapeMarkets(): void
    {
        $this->market = $this->entityManager->getRepository(Market::class)->findOneBy([]);
        $scraperLog = new ScraperLog();
        $scraperLog->setMarket($market);

        try {
            $this->client->setClient($this->guzzleClient);
            $crawler = $this->client->request('GET', $market->getPricesUrl());
            $mainNode = $crawler->filter('#notowania');

            $checkStatus = $this->checkerService->checkMarketPrices($market, $mainNode->text());
            $date = (new DateTime())->format('Y-m-d H:i:s');

            if ($checkStatus) {
                $this->slackService->sendMessage("Stopped Scraping. Changes not found: {$date}");

//                return;
            }

            $this->slackService->sendMessage("!!!! Start Scraping. Changes found: {$date}");
            $priceStartDate = $this->getPriceStartDateFromText($mainNode->filter('small')->text());
            $this->csvService->setHeader(new Record());
            $category = '';

            foreach ($mainNode->children() as $node) {
                if ('h2' === $node->tagName) {
                    $category = $node->textContent;
                }
                if ('div' === $node->tagName) {
                    foreach ($node->childNodes as $table) {
                        foreach ($table->childNodes as $key => $tr) {
                            if ($key > 0) {
                                $record = $this->setRecord($tr, $market, $category, $priceStartDate);
                                $this->csvService->addRecord($record);
                            }
                        }
                    }
                }
            }

            $fileName = $this->uploadFile($market->getName());
            $scraperLog->setCsvFile($fileName);
            $this->saveScraperLog($scraperLog, true);
            $this->checkerService->updateScrapeCheck($market, $mainNode->text());
        } catch (Exception $e) {
            $scraperLog->setErrorMessage($e->getMessage());
            $this->saveScraperLog($scraperLog, false);
            $this->slackService->sendMessage("!!!! Error: {$e->getMessage()}");

            throw new ScraperException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param string $priceStartDateString
     *
     * @return string
     *
     * @throws Exception
     */
    private function getPriceStartDateFromText(string  $priceStartDateString): string
    {
        $stringExploded = explode(' ', $priceStartDateString);
        $dateString = end($stringExploded);
        $now = new DateTime();
        $date = new DateTime($dateString);

        if ($now->format('Y-m-d') === $date->format('Y-m-d')) {
            return $now->format('Y-m-d H:i:s');
        }

        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param ScraperLog $scraperLog
     * @param bool       $status
     */
    private function saveScraperLog(ScraperLog $scraperLog, bool $status): void
    {
        $scraperLog->setSuccess($status);

        $this->entityManager->persist($scraperLog);
        $this->entityManager->flush();
    }

    /**
     * @param string $marketName
     *
     * @return string
     *
     * @throws Exception
     */
    private function uploadFile(string $marketName): string
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $fileName = "{$marketName}/import_{$date}.csv";

        return $this->csvService->uploadCsvFile($fileName);
    }

    /**
     * @param DOMElement $tr
     * @param Market     $market
     * @param string     $category
     * @param string     $priceStartDate
     *
     * @return Record
     *
     * @throws Exception
     */
    private function setRecord(DOMElement $tr, Market $market, string $category, string $priceStartDate): Record
    {
        $record = new Record();
        // TODO ADD Converter Service for that

        $units = $this->convertUnits($tr->childNodes[2]->textContent);
        $record->setName($tr->childNodes[1]->textContent);
        $record->setMarket($market->getName());
        $record->setCategory($category);
        $record->setUnit($units['unit']);
        $record->setQuantity($units['quantity']);
        $record->setAmount($units['amount']);
        $record->setPriceMin((float) $tr->childNodes[3]->textContent);
        $record->setPriceMax((float) $tr->childNodes[4]->textContent);
        $record->setPriceAvg((float) $tr->childNodes[5]->textContent);
        $record->setPriceDifference((float) $tr->childNodes[6]->textContent);
        $record->setPriceAvgPrevious((float) $tr->childNodes[7]->textContent);
        $record->setPriceStartDate($priceStartDate);
        $record->setScrapeDate((new DateTime())->format('Y-m-d H:i:s'));

        return $record;
    }

    /**
     * @param string $unitsString
     *cd
     *
     * @return array
     */
    private function convertUnits(string $unitsString): array
    {
        $convertedString = explode(' ', $unitsString);
        if (count($convertedString) > 1) {
            $units['amount'] = 1;
            $units['quantity'] = $convertedString[0];
            $units['unit'] = UnitType::getUnitTypeByString($convertedString[1]);
        } else {
            $units['amount'] = 1;
            $units['quantity'] = 1;
            $units['unit'] = UnitType::getUnitTypeByString($convertedString[0]);
        }

        return $units;
    }
}
