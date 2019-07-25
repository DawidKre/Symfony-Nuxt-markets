<?php

namespace App\BusinessLogic\Scraper\Service;

use App\Entity\Market;
use App\Entity\ScraperCheck;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CheckerService.
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
     * @param ScraperCheck $scraperCheck
     * @param string       $pricesText
     */
    public function updateScrapeCheck(ScraperCheck $scraperCheck, string $pricesText): void
    {
        $scraperCheck->setPricesHash($this->hashText($pricesText));
        $this->entityManager->persist($scraperCheck);
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
