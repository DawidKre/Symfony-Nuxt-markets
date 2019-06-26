<?php

namespace App\BusinessLogic\Scraper\Service;

use App\Entity\Market;
use App\Entity\ScraperCheck;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CheckerService
 */
class CheckerService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * ImportService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Market $market
     * @param string $pricesText
     *
     * @return bool
     */
    public function checkMarketPrices(Market $market, string $pricesText): bool
    {
        $marketLastScrapeCheck = $market->getScraperCheck();
        $pricesHashText = $this->hashText($pricesText);

        return $marketLastScrapeCheck && ($marketLastScrapeCheck->getPricesHash() === $pricesHashText);
    }

    /**
     * @param Market $market
     * @param string $pricesText
     */
    public function updateScrapeCheck(Market $market, string $pricesText): void
    {
        $scrapeCheck = $market->getScraperCheck();
        if (!$scrapeCheck) {
            $scrapeCheck = new ScraperCheck();
            $scrapeCheck->setMarket($market);
        }

        $scrapeCheck->setPricesHash($this->hashText($pricesText));

        $this->entityManager->persist($scrapeCheck);
        $this->entityManager->flush();
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function hashText(string $text): string
    {
        return hash('sha256', $text);
    }
}
