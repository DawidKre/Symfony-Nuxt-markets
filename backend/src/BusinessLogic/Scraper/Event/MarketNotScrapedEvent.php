<?php

namespace App\BusinessLogic\Scraper\Event;

use App\Entity\Market;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MarketNotScrapedEvent.
 */
class MarketNotScrapedEvent extends Event
{
    /** @var Market */
    private $market;

    /**
     * MarketScrapedEvent constructor.
     * @param Market $market
     */
    public function __construct(Market $market)
    {
        $this->market = $market;
    }

    /**
     * @return Market
     */
    public function getMarket(): Market
    {
        return $this->market;
    }
}