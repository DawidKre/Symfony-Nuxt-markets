<?php

namespace App\BusinessLogic\Importer\Event;

use App\Entity\ScraperLog;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class StartImportScrapedMarketEvent.
 */
class StartImportScrapedMarketEvent extends Event
{
    /** @var ScraperLog */
    private $scraperLog;

    /**
     * MarketScrapedEvent constructor.
     *
     * @param ScraperLog $scraperLog
     */
    public function __construct(ScraperLog $scraperLog)
    {
        $this->scraperLog = $scraperLog;
    }

    /**
     * @return ScraperLog
     */
    public function getScraperLog(): ScraperLog
    {
        return $this->scraperLog;
    }
}
