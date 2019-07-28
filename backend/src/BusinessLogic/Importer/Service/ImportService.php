<?php

namespace App\BusinessLogic\Importer\Service;

use App\BusinessLogic\SharedLogic\Service\CsvReaderService;
use App\Entity\ImporterLog;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Csv\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class ImportService.
 */
class ImportService
{
    /** @var CsvReaderService */
    private $csvReaderService;

    /** @var MarketProductService */
    private $marketProductService;

    /**
     * ImportService constructor.
     *
     * @param CsvReaderService     $csvReaderService
     * @param MarketProductService $marketProductService
     */
    public function __construct(CsvReaderService $csvReaderService, MarketProductService $marketProductService)
    {
        $this->csvReaderService = $csvReaderService;
        $this->marketProductService = $marketProductService;
    }

    /**
     * @param ImporterLog $importerLog
     *
     * @throws Exception
     * @throws ExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function import(ImporterLog $importerLog)
    {
        $records = $this->csvReaderService->gerRecordsFromFile($importerLog->getScraperLog()->getCsvFile());

        foreach ($records as $record) {
            $marketProduct = $this->marketProductService->getMarketProductByName($record);
        }
    }
}
