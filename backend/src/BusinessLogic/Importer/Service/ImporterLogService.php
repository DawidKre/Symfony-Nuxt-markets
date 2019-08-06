<?php

namespace App\BusinessLogic\Importer\Service;

use App\Entity\ImporterLog;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ImporterLogService.
 */
class ImporterLogService
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
     * @param ImporterLog $importerLog
     *
     * @return ImporterLog
     */
    public function saveSuccessImporterLog(ImporterLog $importerLog): ImporterLog
    {
        $importerLog->setSuccess();
        $this->saveLog($importerLog);

        return $importerLog;
    }

    /**
     * @param ImporterLog $importerLog
     * @param string      $errorMessage
     *
     * @return ImporterLog
     */
    public function saveFailedImporterLog(ImporterLog $importerLog, string $errorMessage): ImporterLog
    {
        $importerLog->setErrorMessage($errorMessage);
        $importerLog->setFailed();
        $this->saveLog($importerLog);

        return $importerLog;
    }

    /**
     * Save log to database.
     *
     * @param ImporterLog $importerLog
     */
    private function saveLog(ImporterLog $importerLog): void
    {
        $this->entityManager->persist($importerLog);
        $this->entityManager->flush();
    }
}
