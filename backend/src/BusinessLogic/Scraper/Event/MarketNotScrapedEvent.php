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

    /** @var string */
    private $errorMessage;

    /**
     * MarketScrapedEvent constructor.
     * @param Market $market
     * @param string $errorMessage
     */
    public function __construct(Market $market, string $errorMessage)
    {
        $this->market = $market;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return Market
     */
    public function getMarket(): Market
    {
        return $this->market;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}