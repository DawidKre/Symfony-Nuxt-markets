<?php

namespace App\BusinessLogic\Importer\Event;

use App\Entity\ImporterLog;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MarketImportingFinishedEvent.
 */
class MarketImportingFinishedEvent extends Event
{
    /** @var ImporterLog */
    private $importerLog;

    /**
     * MarketScrapedEvent constructor.
     *
     * @param ImporterLog $importerLog
     */
    public function __construct(ImporterLog $importerLog)
    {
        $this->importerLog = $importerLog;
    }

    /**
     * @return ImporterLog
     */
    public function getImporterLog(): ImporterLog
    {
        return $this->importerLog;
    }

}
