<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\Scraper\Model\RecordInterface;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CsvService
 */
class CsvService
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Writer
     */
    private $writer;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->writer = Writer::createFromFileObject(new SplTempFileObject());
    }

    /**
     * @param string $uploadPath
     */
    public function uploadCsvFile(string $uploadPath): void
    {
        $this->filesystem->appendToFile($uploadPath, $this->writer->getContent());
    }

    /**
     * @param RecordInterface $record
     *
     * @return CsvService
     *
     * @throws CannotInsertRecord
     */
    public function setHeader(RecordInterface $record): self
    {
        $this->writer->insertOne($record->getParametersAsArray());

        return $this;
    }

    /**
     * @param RecordInterface $record
     *
     * @return CsvService
     *
     * @throws CannotInsertRecord
     */
    public function addRecord(RecordInterface $record): self
    {
        $this->writer->insertOne($record->getAsArray());

        return $this;
    }
}
