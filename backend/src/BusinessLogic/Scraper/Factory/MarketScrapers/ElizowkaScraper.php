<?php

namespace App\BusinessLogic\Scraper\Factory\MarketScrapers;

use App\BusinessLogic\Scraper\Converter\ElizowkaConverter;
use App\BusinessLogic\Scraper\Exception\MarketNotScrapedException;
use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Factory\ScrapeMarketInterface;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\Scraper\Model\Unit;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\Entity\Market;
use DateTime;
use DOMElement;
use Exception;

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

    /** @var CheckerService */
    private $checkerService;

    /** @var Market */
    private $market;

    /** @var ElizowkaConverter */
    private $converter;

    /** @var Record[] */
    private $records = [];

    /** @var string */
    private $category = '';

    /**
     * @param Market         $market
     * @param CrawlerService $crawlerService
     * @param CheckerService $checkerService
     */
    public function __construct(Market $market, CrawlerService $crawlerService, CheckerService $checkerService)
    {
        $this->market = $market;
        $this->crawlerService = $crawlerService;
        $this->checkerService = $checkerService;
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
     * @return Record[]
     *
     * @throws MarketNotScrapedException
     * @throws ScraperException
     */
    public function scrapeMarket(): array
    {
        try {
            $crawler = $this->crawlerService->crawlPage($this->market->getPricesUrl());
            $mainNode = $crawler->filter('#notowania');
            $this->checkStatus($mainNode->text());
            $priceStartDate = $this->getPriceStartDateFromText($mainNode->filter('small')->text());
            foreach ($mainNode->children() as $node) {
                if (self::CATEGORY_TAG === $node->tagName) {
                    $this->category = $node->textContent;
                }
                if (self::ROWS_TAG === $node->tagName) {
                    foreach ($node->childNodes as $table) {
                        foreach ($table->childNodes as $key => $tr) {
                            if ($key > 0) {
                                $this->records[] = $this->setRecord($tr, $this->category, $priceStartDate);
                            }
                        }
                    }
                }
            }

            return $this->records;
        } catch (MarketNotScrapedException $e) {
            throw new MarketNotScrapedException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new ScraperException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $mainNodeText
     *
     * @throws MarketNotScrapedException
     */
    private function checkStatus(string $mainNodeText): void
    {
        $checkStatus = $this->checkerService->checkMarketPrices($this->market, $mainNodeText);
        if ($checkStatus) {
            throw new MarketNotScrapedException('Changes not found');
        }

        $this->checkerService->updateScrapeCheck($this->market->getScraperCheck(), $mainNodeText);
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
        $record->setPriceDifferencePrevious((float) $tr->childNodes[7]->textContent);
        $record->setPriceStartDate($priceStartDate);
        $record->setScrapeDate((new DateTime())->format('Y-m-d H:i:s'));

        return $record;
    }
}
