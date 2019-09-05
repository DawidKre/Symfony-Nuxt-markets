<?php

namespace App\BusinessLogic\Scraper\Factory;

use App\BusinessLogic\Scraper\Exception\MarketNotFoundException;
use App\BusinessLogic\Scraper\Factory\MarketScrapers\ElizowkaScraper;
use App\BusinessLogic\Scraper\Model\MarketNameType;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\Entity\Market;

/**
 * Class ScrapeMarketFactory.
 */
class ScrapeMarketFactory
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
     * @param Market $market
     *
     * @return ScrapeMarketInterface
     *
     * @throws MarketNotFoundException
     */
    public function createScraper(Market $market): ScrapeMarketInterface
    {
        // TODO change setters injection
        switch ($market->getName()) {
            case MarketNameType::ELIZOWKA_MARKET:
                return new ElizowkaScraper($market, $this->crawlerService, $this->checkerService);
            case MarketNameType::BRONISZE_MARKET:
                return new ElizowkaScraper($market, $this->crawlerService, $this->checkerService);
        }

        throw new MarketNotFoundException();
    }
}
