<?php

namespace App\BusinessLogic\Importer\Event;

use App\Entity\ImporterLog;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MarketImportingErrorEvent.
 */
class MarketImportingErrorEvent extends Event
{
    /** @var string */
    private $errorMessage;

    /** @var ImporterLog */
    private $importerLog;

    /**
     * MarketScrapedEvent constructor.
     *
     * @param ImporterLog $importerLog
     * @param string      $errorMessage
     */
    public function __construct(ImporterLog $importerLog, string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        $this->importerLog = $importerLog;
    }

    /**
     * @return ImporterLog
     */
    public function getImporterLog(): ImporterLog
    {
        return $this->importerLog;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
