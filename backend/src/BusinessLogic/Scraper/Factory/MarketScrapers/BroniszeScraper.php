<?php

namespace App\BusinessLogic\Scraper\Factory\MarketScrapers;

use App\BusinessLogic\Scraper\Converter\ElizowkaConverter;
use App\BusinessLogic\Scraper\Factory\ScrapeMarketInterface;
use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\Scraper\Service\ScraperLogService;
use App\BusinessLogic\SharedLogic\Service\CrawlerService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BroniszeScraper.
 */
final class BroniszeScraper implements ScrapeMarketInterface
{
    /** @var CrawlerService */
    private $crawlerService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CsvWriterService */
    private $csvService;

    /** @var CheckerService */
    private $checkerService;

    /** @var SlackService */
    private $slackService;

    /** @var Market */
    private $market;

    /** @var ScraperLogService */
    private $scraperLogService;

    /** @var ElizowkaConverter */
    private $converter;

    /**
     * @param CrawlerService         $crawlerService
     * @param CsvWriterService       $csvService
     * @param CheckerService         $checkerService
     * @param SlackService           $slackService
     * @param ScraperLogService      $scraperLogService
     * @param EntityManagerInterface $entityManager
     * @param ElizowkaConverter      $converter
     */
    public function __construct(
        CrawlerService $crawlerService,
        CsvWriterService $csvService,
        CheckerService $checkerService,
        SlackService $slackService,
        ScraperLogService $scraperLogService,
        EntityManagerInterface $entityManager,
        ElizowkaConverter $converter
    ) {
        $this->crawlerService = $crawlerService;
        $this->csvService = $csvService;
        $this->checkerService = $checkerService;
        $this->slackService = $slackService;
        $this->scraperLogService = $scraperLogService;
        $this->entityManager = $entityManager;
        $this->converter = $converter;
    }

    /**
     * @throws \Http\Client\Exception
     */
    public function scrapeMarket(): void
    {
        $this->slackService->sendScraperStartScrapingMessage($this->market->getName());
    }
}
