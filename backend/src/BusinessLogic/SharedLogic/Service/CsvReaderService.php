<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\Scraper\Model\Record;
use Iterator;
use League\Csv\Exception;
use League\Csv\Reader;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class CsvReaderService.
 */
class CsvReaderService
{
    /** @var Reader */
    private $reader;

    /** @var array */
    private $header = [];

    /** @var Iterator */
    private $records;

    /** @var DenormalizerInterface */
    private $denormalizer;

    /**
     * CsvReaderService constructor.
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param string $file
     *
     * @return Record[]
     *
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function gerRecordsFromFile(string $file): array
    {
        $this->readFile($file);

        return $this->getRecords();
    }

    /**
     * @param string $file
     *
     * @throws Exception
     */
    public function readFile(string $file): void
    {
        $this->reader = Reader::createFromPath($file);
        $this->header = $this->reader->fetchOne();
        $this->records = $this->reader->setHeaderOffset(0)->getRecords();
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return Record[]
     *
     * @throws ExceptionInterface
     */
    public function getRecords(): array
    {
        /** @var Record[] $records */
        $records = $this->denormalizer->denormalize(
            iterator_to_array($this->records),
            'App\BusinessLogic\Scraper\Model\Record[]'
        );

        return $records;
    }
}
