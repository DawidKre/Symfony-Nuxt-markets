<?php

namespace App\BusinessLogic\Scraper\Factory;

use App\BusinessLogic\Scraper\Factory\MarketScrapers\ElizowkaScraper;
use App\BusinessLogic\Scraper\Model\MarketNameType;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\Entity\Market;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ScrapeMarketFactory.
 */
class ScrapeMarketFactory
{
    /** @var CrawlerService */
    private $crawlerService;

    /** @var CsvWriterService */
    private $csvService;

    /** @var CheckerService */
    private $checkerService;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param CrawlerService           $crawlerService
     * @param CsvWriterService         $csvService
     * @param CheckerService           $checkerService
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CrawlerService $crawlerService,
        CsvWriterService $csvService,
        CheckerService $checkerService,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->crawlerService = $crawlerService;
        $this->csvService = $csvService;
        $this->checkerService = $checkerService;
        $this->eventDispatcher = $eventDispatcher;
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
                    $this->eventDispatcher
                );
            case MarketNameType::BRONISZE_MARKET:
                return new ElizowkaScraper(
                    $market,
                    $this->crawlerService,
                    $this->csvService,
                    $this->checkerService,
                    $this->eventDispatcher
                );
        }
    }
}
