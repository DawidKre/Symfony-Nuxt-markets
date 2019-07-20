<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\Scraper\Model\RecordInterface;
use DateTime;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;

/**
 * Class CsvWriterService.
 */
class CsvWriterService
{
    /** @var Writer */
    private $writer;

    /** @var UploadService */
    private $uploadService;

    /**
     * @param UploadService $uploadService
     */
    public function __construct(UploadService $uploadService)
    {
        $this->writer = Writer::createFromFileObject(new SplTempFileObject());
        $this->uploadService = $uploadService;
    }

    /**
     * @param string $marketName
     *
     * @return string
     *
     * @throws \Exception
     */
    public function uploadMarketCsvFile(string $marketName): string
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $fileName = "{$marketName}/import_{$date}.csv";

        return $this->uploadService->uploadFile($fileName, $this->writer->getContent());
    }

    /**
     * @param RecordInterface $record
     *
     * @throws CannotInsertRecord
     */
    public function setHeader(RecordInterface $record): void
    {
        $this->writer->insertOne($record->getParametersAsArray());
    }

    /**
     * @param RecordInterface $record
     *
     * @throws CannotInsertRecord
     */
    public function addRecord(RecordInterface $record): void
    {
        $this->writer->insertOne($record->getAsArray());
    }
}
