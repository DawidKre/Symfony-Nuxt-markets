<?php

namespace App\BusinessLogic\Scraper\Event;

use App\BusinessLogic\Scraper\Model\Record;
use App\Entity\Market;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MarketScrapedEvent.
 */
class MarketScrapedEvent extends Event
{
    /** @var Market */
    private $market;

    /** @var Record[] */
    private $records;

    /**
     * MarketScrapedEvent constructor.
     *
     * @param Market   $market
     * @param Record[] $records
     */
    public function __construct(Market $market, array $records)
    {
        $this->market = $market;
        $this->records = $records;
    }

    /**
     * @return Market
     */
    public function getMarket(): Market
    {
        return $this->market;
    }

    /**
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }
}
