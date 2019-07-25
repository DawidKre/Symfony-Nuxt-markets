<?php

namespace App\BusinessLogic\Scraper\Factory\MarketScrapers;

use App\BusinessLogic\Scraper\Converter\ElizowkaConverter;
use App\BusinessLogic\Scraper\Event\MarketNotScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapingErrorEvent;
use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Factory\ScrapeMarketInterface;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\Scraper\Model\Unit;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\Entity\Market;
use DateTime;
use DOMElement;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ElizowkaScraper.
 */
class ElizowkaScraper implements ScrapeMarketInterface
{
    /** @var string */
    private const CATEGORY_TAG = 'h2';

    /** @var string */
    private const ROWS_TAG = 'div';

    /** @var CrawlerService */
    private $crawlerService;

    /** @var CsvWriterService */
    private $csvService;

    /** @var CheckerService */
    private $checkerService;

    /** @var Market */
    private $market;

    /** @var ElizowkaConverter */
    private $converter;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param Market                   $market
     * @param CrawlerService           $crawlerService
     * @param CsvWriterService         $csvService
     * @param CheckerService           $checkerService
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        Market $market,
        CrawlerService $crawlerService,
        CsvWriterService $csvService,
        CheckerService $checkerService,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->market = $market;
        $this->crawlerService = $crawlerService;
        $this->csvService = $csvService;
        $this->checkerService = $checkerService;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @required
     *
     * @param ElizowkaConverter $converter
     */
    public function setConverter(ElizowkaConverter $converter): void
    {
        $this->converter = $converter;
    }

    /**
     * @throws ScraperException
     * @throws \Http\Client\Exception
     */
    public function scrapeMarket(): void
    {
        try {
            $crawler = $this->crawlerService->crawlPage($this->market->getPricesUrl());
            $mainNode = $crawler->filter('#notowania');
            $checkStatus = $this->checkerService->checkMarketPrices($this->market, $mainNode->text());
            if ($checkStatus) {
                $this->eventDispatcher->dispatch(new MarketNotScrapedEvent($this->market));

                return;
            }

            $priceStartDate = $this->getPriceStartDateFromText($mainNode->filter('small')->text());
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
                                $this->csvService->addRecord($this->setRecord($tr, $category, $priceStartDate));
                            }
                        }
                    }
                }
            }

            $fileName = $this->csvService->uploadMarketCsvFile($this->market->getName());
            $this->eventDispatcher->dispatch(new MarketScrapedEvent($this->market, $fileName));
            $this->checkerService->updateScrapeCheck($this->market->getScraperCheck(), $mainNode->text());
        } catch (Exception $e) {
            $this->eventDispatcher->dispatch(new MarketScrapingErrorEvent($this->market, $e->getMessage()));
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
     * @param DOMElement $tr
     * @param string     $category
     * @param string     $priceStartDate
     *
     * @return Record
     *
     * @throws Exception
     */
    private function setRecord(DOMElement $tr, string $category, string $priceStartDate): Record
    {
        $record = new Record();
        $this->converter = new ElizowkaConverter(new Unit());
        // TODO ADD Converter Service for that
        $units = $this->converter->convertUnits($tr->childNodes[2]->textContent);
        $record->setName($tr->childNodes[1]->textContent);
        $record->setMarket($this->market->getName());
        $record->setCategory($category);
        $record->setUnit($units->getUnit());
        $record->setQuantity($units->getQuantity());
        $record->setAmount($units->getAmount());
        $record->setPriceMin((float) $tr->childNodes[3]->textContent);
        $record->setPriceMax((float) $tr->childNodes[4]->textContent);
        $record->setPriceAvg((float) $tr->childNodes[5]->textContent);
        $record->setPriceDifference((float) $tr->childNodes[6]->textContent);
        $record->setPriceAvgPrevious((float) $tr->childNodes[7]->textContent);
        $record->setPriceStartDate($priceStartDate);
        $record->setScrapeDate((new DateTime())->format('Y-m-d H:i:s'));

        return $record;
    }
}
