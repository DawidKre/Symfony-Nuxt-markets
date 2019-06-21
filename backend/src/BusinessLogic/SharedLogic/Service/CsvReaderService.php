<?php

namespace App\BusinessLogic\SharedLogic\Service;

use Iterator;
use League\Csv\Exception;
use League\Csv\Reader;

/**
 * Class CsvReaderService
 */
class CsvReaderService
{
    /** @var Reader */
    private $reader;

    /** @var array */
    private $header = [];

    /** @var Iterator */
    private $records;

    /**
     * @param string $file
     *
     * @return CsvReaderService
     *
     * @throws Exception
     */
    public function readFile(string $file): self
    {
        $this->reader = Reader::createFromPath($file);
        $this->header = $this->reader->fetchOne();
        $this->records = $this->reader->setHeaderOffset(0)->getRecords();

        return $this;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return Iterator
     */
    public function getRecords(): Iterator
    {
        return $this->records;
    }
}
