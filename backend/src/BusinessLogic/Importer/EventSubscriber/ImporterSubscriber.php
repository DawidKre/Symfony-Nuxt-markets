<?php

namespace App\BusinessLogic\Importer\EventSubscriber;

use App\BusinessLogic\Importer\Event\ImportingProcessFinishedEvent;
use App\BusinessLogic\Importer\Event\ImportingProcessStartedEvent;
use App\BusinessLogic\Importer\Event\MarketImportingErrorEvent;
use App\BusinessLogic\Importer\Event\MarketImportingFinishedEvent;
use App\BusinessLogic\Importer\Model\ImporterStatus;
use App\BusinessLogic\Importer\Service\ImporterLogService;
use App\BusinessLogic\SharedLogic\Service\SlackService;
use App\Entity\ImporterLog;
use Http\Client\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ImporterSubscriber.
 */
class ImporterSubscriber implements EventSubscriberInterface
{
    /** @var SlackService */
    private $slackService;

    /** @var LoggerInterface */
    private $importerLogger;

    /** @var string */
    private $message;

    /** @var ImporterLogService */
    private $importerLogService;

    /**
     * ImporterSubscriber constructor.
     *
     * @param SlackService       $slackService
     * @param ImporterLogService $importerLogService
     * @param LoggerInterface    $importerLogger
     */
    public function __construct(
        SlackService $slackService,
        ImporterLogService $importerLogService,
        LoggerInterface $importerLogger
    ) {
        $this->slackService = $slackService;
        $this->importerLogService = $importerLogService;
        $this->importerLogger = $importerLogger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ImportingProcessStartedEvent::class => 'onImportingProcessStarted',
            MarketImportingFinishedEvent::class => 'onMarketImportingFinished',
            MarketImportingErrorEvent::class => 'onMarketImportingError',
            ImportingProcessFinishedEvent::class => 'onImportingProcessFinished',
        ];
    }

    /**
     * @throws Exception
     */
    public function onImportingProcessStarted(): void
    {
        $this->message = ImporterStatus::IMPORTER_START_IMPORTING;
        $this->importingProcessChanged();
    }

    /**
     * @throws Exception
     */
    public function onImportingProcessFinished(): void
    {
        $this->message = ImporterStatus::IMPORTER_FINISHED_IMPORTING;
        $this->importingProcessChanged();
    }

    /**
     * @param MarketImportingErrorEvent $event
     *
     * @throws Exception
     */
    public function onMarketImportingError(MarketImportingErrorEvent $event): void
    {
        $market = $event->getImporterLog()->getScraperLog()->getMarket();
        $this->setMessage($market->getName(), $event->getErrorMessage());
        $this->marketImportingError($event->getImporterLog(), $event->getErrorMessage());
    }

    /**
     * @param MarketImportingFinishedEvent $event
     *
     * @throws Exception
     */
    public function onMarketImportingFinished(MarketImportingFinishedEvent $event): void
    {
        $market = $event->getImporterLog()->getScraperLog()->getMarket();
        $this->setMessage($market->getName(), ImporterStatus::IMPORTER_MARKET_FINISHED_IMPORTING);
        $this->marketImportingFinished($event->getImporterLog());
    }

    /**
     * @throws Exception
     */
    private function importingProcessChanged(): void
    {
        $this->slackService->sendMessage($this->message);
        $this->importerLogger->info($this->message);
    }

    /**
     * @param ImporterLog $importerLog
     * @param string      $errorMessage
     *
     * @throws Exception
     */
    private function marketImportingError(ImporterLog $importerLog, string $errorMessage): void
    {
        $this->importerLogService->saveFailedImporterLog($importerLog, $errorMessage);
        $this->slackService->sendMessage($this->message);
        $this->importerLogger->error($this->message);
    }

    /**
     * @param ImporterLog $importerLog
     *
     * @throws Exception
     */
    private function marketImportingFinished(ImporterLog $importerLog): void
    {
        $this->importerLogService->saveSuccessImporterLog($importerLog);
        $this->slackService->sendMessage($this->message);
        $this->importerLogger->info($this->message);
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
