<?php

namespace App\BusinessLogic\Scraper\Factory\MarketScrapers;

use App\BusinessLogic\Scraper\Factory\ScrapeMarketInterface;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;

/**
 * Class BroniszeScraper.
 */
final class BroniszeScraper implements ScrapeMarketInterface
{
    /** @var CrawlerService */
    private $crawlerService;

    /** @var CheckerService */
    private $checkerService;

    /**
     * @param CrawlerService $crawlerService
     * @param CheckerService $checkerService
     */
    public function __construct(CrawlerService $crawlerService, CheckerService $checkerService)
    {
        $this->crawlerService = $crawlerService;
        $this->checkerService = $checkerService;
    }

    /**
     * @return Record[]
     */
    public function scrapeMarket(): array
    {
        return [];
    }
}
