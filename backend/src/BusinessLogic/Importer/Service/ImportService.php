<?php

namespace App\BusinessLogic\Importer\Service;

use App\BusinessLogic\SharedLogic\Service\CsvReaderService;
use App\Entity\MarketProduct;
use App\Entity\Prices;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;

/**
 * Class ImportService.
 */
class ImportService
{
    /** @var CsvReaderService */
    private $csvReaderService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * ImportService constructor.
     *
     * @param CsvReaderService       $csvReaderService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CsvReaderService $csvReaderService, EntityManagerInterface $entityManager)
    {
        $this->csvReaderService = $csvReaderService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $file
     *
     * @throws Exception
     */
    public function import(string $file)
    {
        $reader = $this->csvReaderService->readFile($file);
        $header = $this->csvReaderService->getHeader();
        $records = $this->csvReaderService->getRecords();

        foreach ($records as $record) {
            $marketProduct = $this->entityManager
                ->getRepository(MarketProduct::class)
                ->findOrCreateNewByName($record['name']);

            $prices = new Prices();
        }
    }
}
