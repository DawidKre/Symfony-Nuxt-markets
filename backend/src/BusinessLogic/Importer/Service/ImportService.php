<?php

namespace App\BusinessLogic\Importer\Service;

use App\BusinessLogic\Importer\Event\ImportingProcessFinishedEvent;
use App\BusinessLogic\Importer\Event\ImportingProcessStartedEvent;
use App\BusinessLogic\Importer\Event\MarketImportingErrorEvent;
use App\BusinessLogic\Importer\Event\MarketImportingFinishedEvent;
use App\BusinessLogic\Importer\Exception\ImporterException;
use App\BusinessLogic\Scraper\Model\Record;
use App\BusinessLogic\SharedLogic\Service\CsvReaderService;
use App\Entity\ImporterLog;
use App\Entity\MarketProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * ImportService constructor.
     *
     * @param CsvReaderService         $csvReaderService
     * @param MarketProductService     $marketProductService
     * @param EntityManagerInterface   $entityManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CsvReaderService $csvReaderService,
        MarketProductService $marketProductService,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->csvReaderService = $csvReaderService;
        $this->marketProductService = $marketProductService;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return void
     */
    public function startImporter(): void
    {
        $this->eventDispatcher->dispatch(new ImportingProcessStartedEvent());
        $importerLogs = $this->entityManager->getRepository(ImporterLog::class)->getNotImported();

        foreach ($importerLogs as $importerLog) {
            try {
                $this->import($importerLog);
                $this->eventDispatcher->dispatch(new MarketImportingFinishedEvent($importerLog));
            } catch (ImporterException $e) {
                $this->eventDispatcher->dispatch(new MarketImportingErrorEvent($importerLog, $e->getMessage()));
            }
        }

        $this->eventDispatcher->dispatch(new ImportingProcessFinishedEvent());
    }

    /**
     * @param ImporterLog $importerLog
     *
     * @throws ImporterException
     */
    public function import(ImporterLog $importerLog): void
    {
        try {
            $records = $this->csvReaderService->gerRecordsFromFile($importerLog->getScraperLog()->getCsvFile());
            $marketProducts = $this->marketProductService
                ->getMarketProductsCollection($importerLog->getScraperLog()->getMarket());

            foreach ($records as $record) {
                $marketProduct = $marketProducts->filter(static function (MarketProduct $marketProduct) use ($record) {
                    return
                        $marketProduct->getName() === $record->getName() &&
                        $marketProduct->getUnit() === $record->getUnit();
                })->first();

                if ($marketProduct) {
                    if ($marketProduct->getPriceAvg() !== $record->getPriceAvg()) {
                        $marketProduct = $this->marketProductService->updateMarketProduct($marketProduct, $record);
                        $this->entityManager->persist($marketProduct);
                    }
                } else {
                    $marketProduct = $this->marketProductService->getNewMarketProduct($record);
                    $this->entityManager->persist($marketProduct);
                }
                $marketPrice = $this->marketProductService->addMarketPrices($marketProduct, $record);
                $this->entityManager->persist($marketPrice);
            }
            $this->entityManager->flush();
            $this->setInactiveProducts($marketProducts, $records);
        } catch (Exception $e) {
            throw new ImporterException($e->getMessage(), $e->getCode(), $e);
        } catch (ExceptionInterface $e) {
            throw new ImporterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param ArrayCollection $marketProducts
     * @param array           $records
     */
    private function setInactiveProducts(ArrayCollection $marketProducts, array $records): void
    {
        $recordsCollection = new ArrayCollection($records);
        /** @var MarketProduct[] $inActiveProducts */
        $inActiveProducts = $marketProducts->filter(static function (MarketProduct $marketProduct) use ($recordsCollection) {
            return !$recordsCollection->exists(static function (string $key, Record $record) use ($marketProduct) {
                return $record->getName() === $marketProduct->getName();
            });
        });

        foreach ($inActiveProducts as $inActiveProduct) {
            $inActiveProduct->setInActive();
            $this->entityManager->persist($inActiveProduct);
        }

        $this->entityManager->flush();
    }
}
