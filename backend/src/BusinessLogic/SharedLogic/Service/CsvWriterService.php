<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\Scraper\Model\RecordInterface;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CsvWriterService
 */
class CsvWriterService
{
    /** @var Filesystem */
    private $filesystem;

    /** @var Writer */
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
     *
     * @return string
     */
    public function uploadCsvFile(string $uploadPath): string
    {
        $this->filesystem->appendToFile($uploadPath, $this->writer->getContent());

        return $uploadPath;
    }

    /**
     * @param RecordInterface $record
     *
     * @return CsvWriterService
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
     * @return CsvWriterService
     *
     * @throws CannotInsertRecord
     */
    public function addRecord(RecordInterface $record): self
    {
        $this->writer->insertOne($record->getAsArray());
        // TODO CHECK it return needed
        return $this;
    }
}
