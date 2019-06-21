<?php

namespace App\BusinessLogic\Scraper\Service;

use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\Scraper\Model\RecordInterface;
use App\BusinessLogic\SharedLogic\Model\UnitType;
use App\BusinessLogic\SharedLogic\Service\CsvService;
use App\Entity\Category;
use App\Entity\Market;
use ArrayIterator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DOMElement;
use Exception;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class ScraperManager
 */
class ScraperManager
{
    /** @var GoutteClient */
    private $client;

    /** @var GuzzleClient*/
    private $guzzleClient;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CsvService */
    private $csvService;

    /** @var string */
    private $projectDir;

    /**
     * @param GoutteClient           $client
     * @param GuzzleClient           $guzzleClient
     * @param EntityManagerInterface $entityManager
     * @param CsvService             $csvService
     * @param string                 $projectDir
     */
    public function __construct(
        GoutteClient $client,
        GuzzleClient $guzzleClient,
        EntityManagerInterface $entityManager,
        CsvService $csvService,
        $projectDir
    ) {
        $this->client = $client;
        $this->guzzleClient = $guzzleClient;
        $this->entityManager = $entityManager;
        $this->csvService = $csvService;
        $this->projectDir = $projectDir;
    }

    /**
     * @throws ScraperException
     */
    public function scrapeMarkets(): void
    {
        $market = $this->entityManager->getRepository(Market::class)->findOneBy([]);
        $scraperLog = new ScraperLog();
        $scraperLog->setMarket($market);

        try {
            $this->client->setClient($this->guzzleClient);
            $crawler = $this->client->request('GET', $market->getPricesUrl());
            $mainNode = $crawler->filter('#notowania');
            $priceStartDate = $this->getPriceStartDateFromText($mainNode->filter('small')->text());
            $this->csvService->setHeader(new Record());

            $category = '';
            foreach ($mainNode->children() as $node) {
                if ($node->tagName === 'h2') {
                    $category = $node->textContent;
                }
                if ($node->tagName === 'div') {
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
        } catch (Exception $e) {
            $scraperLog->setErrorMessage($e->getMessage());
            $this->saveScraperLog($scraperLog, false);

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
     *
     * @return array
     */
    private function convertUnits(string $unitsString): array
    {
        //TODO SET TO MODEL
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

    /**
     * @param string $category
     *
     * @return Category
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function getCategory(string $category): Category
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->findOrCreateNewByName($category);
    }
}