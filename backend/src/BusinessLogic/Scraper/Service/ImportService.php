<?php

namespace App\BusinessLogic\Scraper\Service;

use App\BusinessLogic\SharedLogic\Service\CsvReaderService;
use App\Entity\Category;
use App\Entity\Market;
use App\Entity\MarketProduct;
use App\Entity\Prices;
use ArrayIterator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\MapIterator;
use League\Csv\Statement;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use League\Csv\Reader;

/**
 * Class ImportService
 */
class ImportService
{
    /** @var CsvReaderService */
    private $csvReaderService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * ImportService constructor.
     * @param CsvReaderService $csvReaderService
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
     * @throws ORMException
     * @throws OptimisticLockException
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