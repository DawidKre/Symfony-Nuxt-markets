<?php

namespace App\BusinessLogic\Scraper\EventSubscriber;

use App\BusinessLogic\Importer\Event\StartImportingScrapedMarketsEvent;
use App\BusinessLogic\Scraper\Event\MarketNotScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapedEvent;
use App\BusinessLogic\Scraper\Event\MarketScrapingErrorEvent;
use App\BusinessLogic\Scraper\Event\ScrapingProcessFinishedEvent;
use App\BusinessLogic\Scraper\Event\ScrapingProcessStartedEvent;
use App\BusinessLogic\Scraper\Model\ScrapingStatus;
use App\BusinessLogic\Scraper\Service\ScraperLogService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\Market;
use Http\Client\Exception;
use League\Csv\CannotInsertRecord;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ScraperSubscriber.
 */
class ScraperSubscriber implements EventSubscriberInterface
{
    /** @var SlackService */
    private $slackService;

    /** @var ScraperLogService */
    private $scraperLogService;

    /** @var CsvWriterService */
    private $csvService;

    /** @var LoggerInterface */
    private $scraperLogger;

    /** @var string */
    private $message;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * MarketScrapedSubscriber constructor.
     *
     * @param SlackService             $slackService
     * @param ScraperLogService        $scraperLogService
     * @param CsvWriterService         $csvService
     * @param LoggerInterface          $scraperLogger
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        SlackService $slackService,
        ScraperLogService $scraperLogService,
        CsvWriterService $csvService,
        LoggerInterface $scraperLogger,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->slackService = $slackService;
        $this->scraperLogService = $scraperLogService;
        $this->csvService = $csvService;
        $this->scraperLogger = $scraperLogger;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScrapingProcessStartedEvent::class => 'onScrapingProcessStarted',
            ScrapingProcessFinishedEvent::class => 'onScrapingProcessFinished',
            MarketScrapedEvent::class => 'onMarketScraped',
            MarketNotScrapedEvent::class => 'onMarketNotScraped',
            MarketScrapingErrorEvent::class => 'onMarketScrapingError',
        ];
    }

    /**
     * @throws Exception
     */
    public function onScrapingProcessStarted(): void
    {
        $this->message = ScrapingStatus::SCRAPER_START_SCRAPING;
        $this->scrapingProcessChanged();
    }

    /**
     * @throws Exception
     */
    public function onScrapingProcessFinished(): void
    {
        $this->message = ScrapingStatus::SCRAPER_FINISHED_SCRAPING;
        $this->scrapingProcessChanged();
        $this->eventDispatcher->dispatch(new StartImportingScrapedMarketsEvent());
    }

    /**
     * @param MarketScrapedEvent $event
     *
     * @throws Exception
     * @throws CannotInsertRecord
     */
    public function onMarketScraped(MarketScrapedEvent $event): void
    {
        $this->setMessage($event->getMarket()->getName(), ScrapingStatus::SCRAPER_CHANGES_FOUND);
        $this->marketScraped($event->getMarket(), $event->getRecords());
    }

    /**
     * @param MarketNotScrapedEvent $event
     *
     * @throws Exception
     */
    public function onMarketNotScraped(MarketNotScrapedEvent $event): void
    {
        $this->setMessage($event->getMarket()->getName(), $event->getErrorMessage());
        $this->marketNotScraped();
    }

    /**
     * @param MarketScrapingErrorEvent $event
     *
     * @throws Exception
     */
    public function onMarketScrapingError(MarketScrapingErrorEvent $event): void
    {
        $this->setMessage($event->getMarket()->getName(), $event->getErrorMessage());
        $this->marketScrapingError($event->getMarket(), $event->getErrorMessage());
    }

    /**
     * @throws Exception
     */
    private function scrapingProcessChanged(): void
    {
        $this->slackService->sendMessage($this->message);
        $this->scraperLogger->info($this->message);
    }

    /**
     * @param Market $market
     * @param array  $records
     *
     * @throws Exception
     * @throws CannotInsertRecord
     */
    private function marketScraped(Market $market, array $records): void
    {
        $fileName = $this->csvService->uploadMarketCsvFile($records, $market->getName());
        $this->scraperLogService->saveSuccessScraperLog($market, $fileName);
        $this->slackService->sendMessage($this->message);
        $this->scraperLogger->info($this->message);
    }

    /**
     * @throws Exception
     */
    private function marketNotScraped(): void
    {
        $this->slackService->sendMessage($this->message);
        $this->scraperLogger->warning($this->message);
    }

    /**
     * @param Market $market
     * @param string $errorMessage
     *
     * @throws Exception
     */
    private function marketScrapingError(Market $market, string $errorMessage): void
    {
        $this->scraperLogService->saveFailedScraperLog($market, $errorMessage);
        $this->slackService->sendMessage($this->message);
        $this->scraperLogger->error($this->message);
    }

    /**
     * @param string $marketName
     * @param string $message
     */
    private function setMessage(string $marketName, string $message): void
    {
        $this->message = ' * '.$marketName.' => '.$message;
    }
}
