<?php

namespace App\BusinessLogic\Scraper\Service;

use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\SharedLogic\Model\UnitType;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;
use App\Entity\ScraperLog;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DOMElement;
use Exception;

/**
 * Class ScraperManager.
 */
class ScraperManager
{
    /** @var string */
    private const CATEGORY_TAG = 'h2';

    /** @var string */
    private const ROWS_TAG = 'div';

    /** @var CrawlerService */
    private $crawlerService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CsvWriterService */
    private $csvService;

    /** @var string */
    private $projectDir;

    /** @var CheckerService */
    private $checkerService;

    /** @var SlackService */
    private $slackService;

    /**
     * @param CrawlerService         $crawlerService
     * @param EntityManagerInterface $entityManager
     * @param CsvWriterService       $csvService
     * @param CheckerService         $checkerService
     * @param SlackService           $slackService
     * @param string                 $projectDir
     */
    public function __construct(
        CrawlerService $crawlerService,
        EntityManagerInterface $entityManager,
        CsvWriterService $csvService,
        CheckerService $checkerService,
        SlackService $slackService,
        string $projectDir
    ) {
        $this->crawlerService = $crawlerService;
        $this->entityManager = $entityManager;
        $this->csvService = $csvService;
        $this->projectDir = $projectDir;
        $this->checkerService = $checkerService;
        $this->slackService = $slackService;
    }

    /**
     * @throws ScraperException
     * @throws \Http\Client\Exception
     */
    public function scrapeMarkets(): void
    {
        $market = $this->entityManager->getRepository(Market::class)->findOneBy([]);
        // TODO DBlog service
        $scraperLog = new ScraperLog();
        $scraperLog->setMarket($market);

        try {
            $crawler = $this->crawlerService->crawlPage($market->getPricesUrl());
            $mainNode = $crawler->filter('#notowania');
            $checkStatus = $this->checkerService->checkMarketPrices($market, $mainNode->text());
            $date = (new DateTime())->format('Y-m-d H:i:s');

            if ($checkStatus) {
                $this->slackService->sendMessage("Stopped Scraping. Changes not found: {$date}");

                return;
            }

            $this->slackService->sendMessage("!!!! Start Scraping. Changes found: {$date}");
            $priceStartDate = $this->getPriceStartDateFromText($mainNode->filter('small')->text());
            $this->csvService->setHeader(new Record());
            $category = '';

            // TODO Refactor foreach add new functions for h2 and div ex: h2Nodes(), divNodes()
            foreach ($mainNode->children() as $node) {
                if (self::CATEGORY_TAG === $node->tagName) {
                    $category = $node->textContent;
                }
                if (self::ROWS_TAG === $node->tagName) {
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

            $file = $this->uploadFile($market->getName());
            $scraperLog->setCsvFile($file);
            $this->saveScraperLog($scraperLog, true);
            $this->checkerService->updateScrapeCheck($market, $mainNode->text());
        } catch (Exception $e) {
            $scraperLog->setErrorMessage($e->getMessage());
            $this->saveScraperLog($scraperLog, false);
            $this->slackService->sendErrorMessage($e->getMessage());

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

    // TODO osobny factory serwis dla logów

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
        $fileName = $marketName.'/import_'.$date.'.csv';
        $path = $this->projectDir.'/var/storage/csv/'.$fileName;

        return $this->csvService->uploadCsvFile($path);
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
