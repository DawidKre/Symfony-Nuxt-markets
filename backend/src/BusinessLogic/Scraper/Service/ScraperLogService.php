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

    /**
     * ImportService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Market $market
     * @param string $filename
     *
     * @return ScraperLog
     */
    public function saveSuccessScraperLog(Market $market, string $filename): ScraperLog
    {
        $scraperLog = new ScraperLog();
        $scraperLog->setCsvFile($filename);
        $scraperLog->setMarket($market);
        $scraperLog->setSuccess(true);
        $this->saveLog($scraperLog);

        return $scraperLog;
    }

    /**
     * @param Market $market
     * @param string $errorMessage
     *
     * @return ScraperLog
     */
    public function saveFailedScraperLog(Market $market, string $errorMessage): ScraperLog
    {
        $scraperLog = new ScraperLog();
        $scraperLog->setErrorMessage($errorMessage);
        $scraperLog->setMarket($market);
        $scraperLog->setSuccess(false);

        $this->saveLog($scraperLog);

        return $scraperLog;
    }

    /**
     * Save log to database.
     * @param ScraperLog $scraperLog
     */
    private function saveLog(ScraperLog $scraperLog): void
    {
        $this->entityManager->persist($scraperLog);
        $this->entityManager->flush();
    }
}
