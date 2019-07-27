<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\Scraper\Model\Record;
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
     * @param Record $record
     *
     * @required
     *
     * @throws CannotInsertRecord
     */
    public function setRecord(Record $record): void
    {
        $this->setHeader($record);
    }

    /**
     * @param Record[] $records
     *
     * @throws CannotInsertRecord
     */
    public function addRecords(array $records): void
    {
        foreach ($records as $record) {
            $this->addRecord($record);
        }
    }

    /**
     * @param Record[] $records
     * @param string   $marketName
     *
     * @return string
     *
     * @throws CannotInsertRecord
     */
    public function uploadMarketCsvFile(array $records, string $marketName): string
    {
        $this->addRecords($records);
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
