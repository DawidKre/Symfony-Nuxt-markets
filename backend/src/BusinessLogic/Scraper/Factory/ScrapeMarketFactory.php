<?php

namespace App\BusinessLogic\Scraper\Factory;

use App\BusinessLogic\Scraper\Factory\MarketScrapers\ElizowkaScraper;
use App\BusinessLogic\Scraper\Model\MarketNameType;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\Scraper\Service\ScraperLogService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;

/**
 * Class ScrapeMarketFactory.
 */
class ScrapeMarketFactory
{
    /** @var CrawlerService */
    private $crawlerService;

    /** @var CsvWriterService */
    private $csvService;

    /** @var SlackService */
    private $slackService;

    /** @var CheckerService */
    private $checkerService;

    /** @var ScraperLogService */
    private $scraperLogService;

    /**
     * @param CrawlerService    $crawlerService
     * @param CsvWriterService  $csvService
     * @param SlackService      $slackService
     * @param CheckerService    $checkerService
     * @param ScraperLogService $scraperLogService
     */
    public function __construct(
        CrawlerService $crawlerService,
        CsvWriterService $csvService,
        SlackService $slackService,
        CheckerService $checkerService,
        ScraperLogService $scraperLogService
    ) {
        $this->crawlerService = $crawlerService;
        $this->csvService = $csvService;
        $this->slackService = $slackService;
        $this->checkerService = $checkerService;
        $this->scraperLogService = $scraperLogService;
    }

    /**
     * @param Market $market
     *
     * @return ScrapeMarketInterface
     */
    public function createScraper(Market $market): ScrapeMarketInterface
    {
        switch ($market->getName()) {
            case MarketNameType::ELIZOWKA_MARKET:
                return new ElizowkaScraper(
                    $market,
                    $this->crawlerService,
                    $this->csvService,
                    $this->checkerService,
                    $this->slackService,
                    $this->scraperLogService
                );
            case MarketNameType::BRONISZE_MARKET:
                return new ElizowkaScraper(
                    $market,
                    $this->crawlerService,
                    $this->csvService,
                    $this->checkerService,
                    $this->slackService,
                    $this->scraperLogService
                );
        }
    }
}
