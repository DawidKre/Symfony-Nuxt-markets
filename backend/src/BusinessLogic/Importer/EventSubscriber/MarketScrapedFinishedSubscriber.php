<?php

namespace App\BusinessLogic\Importer\EventSubscriber;

use App\BusinessLogic\Importer\Event\StartImportScrapedMarketEvent;
use App\BusinessLogic\Importer\Service\ImportService;
use App\BusinessLogic\SharedLogic\Service\CsvWriterService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\ScraperLog;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MarketScrapedFinishedSubscriber.
 */
class MarketScrapedFinishedSubscriber implements EventSubscriberInterface
{
    /** @var SlackService */
    private $slackService;

    /** @var CsvWriterService */
    private $csvService;

    /** @var LoggerInterface */
    private $importerLogger;

    /** @var string */
    private $message;

    /** @var ImportService */
    private $importService;

    /**
     * MarketScrapedSubscriber constructor.
     *
     * @param SlackService     $slackService
     * @param CsvWriterService $csvService
     * @param LoggerInterface  $importerLogger
     */
    public function __construct(
        SlackService $slackService,
        CsvWriterService $csvService,
        LoggerInterface $importerLogger,
        ImportService $importService
    ) {
        $this->slackService = $slackService;
        $this->csvService = $csvService;
        $this->importerLogger = $importerLogger;
        $this->importService = $importService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            StartImportScrapedMarketEvent::class => 'onStartImportScrapedMarket',
        ];
    }

    /**
     * @param StartImportScrapedMarketEvent $event
     */
    public function onStartImportScrapedMarket(StartImportScrapedMarketEvent $event): void
    {
        $this->startImportScrapedMarket($event->getScraperLog());
    }

    /**
     * @param ScraperLog $scraperLog
     */
    private function startImportScrapedMarket(ScraperLog $scraperLog): void
    {
        $this->importService->import($scraperLog);
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
