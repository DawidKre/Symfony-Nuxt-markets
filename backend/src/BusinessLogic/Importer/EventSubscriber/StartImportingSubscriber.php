<?php

namespace App\BusinessLogic\Importer\EventSubscriber;

use App\BusinessLogic\Importer\Event\StartImportingScrapedMarketsEvent;
use App\BusinessLogic\Importer\Service\ImportService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class StartImportingSubscriber.
 */
class StartImportingSubscriber implements EventSubscriberInterface
{
    /**
     * @var ImportService
     */
    private $importService;

    /**
     * StartImportingSubscriber constructor.
     */
    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            StartImportingScrapedMarketsEvent::class => 'onStartImportingScrapedMarkets',
        ];
    }

    public function onStartImportingScrapedMarkets(): void
    {
        $this->importService->startImporter();
    }
}
