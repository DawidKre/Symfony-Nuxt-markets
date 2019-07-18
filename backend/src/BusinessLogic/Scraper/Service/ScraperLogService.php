<?php

namespace App\BusinessLogic\Scraper\Service;

use App\Entity\Market;
use App\Entity\ScraperLog;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ScraperLogService.
 */
class ScraperLogService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ScraperLog */
    private $scraperLog;

    /**
     * ImportService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->scraperLog = new ScraperLog();
    }

    /**
     * @param Market $market
     * @param string $filename
     */
    public function saveSuccessScraperLog(Market $market, string $filename): void
    {
        $this->scraperLog->setCsvFile($filename);
        $this->scraperLog->setMarket($market);

        $this->saveLog();
    }

    /**
     * @param Market $market
     * @param string $errorMessage
     */
    public function saveFailedScraperLog(Market $market, string $errorMessage): void
    {
        $this->scraperLog->setErrorMessage($errorMessage);
        $this->scraperLog->setMarket($market);

        $this->saveLog();
    }

    private function saveLog(): void
    {
        $this->entityManager->persist($this->scraperLog);
        $this->entityManager->flush();
    }
}
