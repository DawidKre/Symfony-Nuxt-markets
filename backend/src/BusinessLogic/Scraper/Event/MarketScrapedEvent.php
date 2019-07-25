<?php

namespace App\BusinessLogic\Scraper\Event;

use App\Entity\Market;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MarketScrapedEvent.
 */
class MarketScrapedEvent extends Event
{
    /** @var Market */
    private $market;

    /** @var string */
    private $fileName;

    /**
     * MarketScrapedEvent constructor.
     * @param Market $market
     * @param string $fileName
     */
    public function __construct(Market $market, string $fileName)
    {
        $this->market = $market;
        $this->fileName = $fileName;
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
    public function getFileName(): string
    {
        return $this->fileName;
    }
}