<?php

namespace App\BusinessLogic\Scraper\Factory;

use App\BusinessLogic\Scraper\Exception\MarketNotScrapedException;
use App\BusinessLogic\Scraper\Exception\ScraperException;
use App\BusinessLogic\Scraper\Model\Record;
use League\Csv\CannotInsertRecord;

/**
 * Interface ScrapeMarketInterface.
 */
interface ScrapeMarketInterface
{
    /**
     * @return Record[]
     *
     * @throws ScraperException
     * @throws MarketNotScrapedException
     * @throws CannotInsertRecord
     */
    public function scrapeMarket(): array;
}
