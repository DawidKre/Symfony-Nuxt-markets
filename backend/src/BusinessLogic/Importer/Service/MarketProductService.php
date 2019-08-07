<?php

namespace App\BusinessLogic\Importer\Service;

use App\BusinessLogic\Scraper\Model\Record;
use App\Entity\Market;
use App\Entity\MarketProduct;
use App\Entity\Price;
use App\Repository\MarketProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;

/**
 * Class MarketProductService.
 */
class MarketProductService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var MarketProductRepository */
    private $marketProductRepository;

    /**
     * ImportService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->marketProductRepository = $this->entityManager->getRepository(MarketProduct::class);
    }

    /**
     * @param Market $market
     *
     * @return ArrayCollection
     */
    public function getMarketProductsCollection(Market $market): ArrayCollection
    {
        $marketProducts = $this->marketProductRepository->findBy(['market' => $market]);

        return new ArrayCollection($marketProducts);
    }

    /**
     * @param Record $record
     *
     * @return MarketProduct
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getNewMarketProduct(Record $record): MarketProduct
    {
        return $this->marketProductRepository->createNewMarketProduct($record);
    }

    /**
     * @param MarketProduct $marketProduct
     * @param Record        $record
     *
     * @return MarketProduct
     */
    public function updateMarketProduct(MarketProduct $marketProduct, Record $record): MarketProduct
    {
        // TODO Think about scenario when amount, quantity or unit will change
        $marketProduct->setAmount($record->getAmount());
        $marketProduct->setQuantity($record->getQuantity());
        $marketProduct->setUnit($record->getUnit());

        $marketProduct->setPriceMinPrevious($marketProduct->getPriceMin());
        $marketProduct->setPriceMaxPrevious($marketProduct->getPriceMax());
        $marketProduct->setPriceAvgPrevious($marketProduct->getPriceAvgP());

        $marketProduct->setPriceAvg($record->getPriceAvg());
        $marketProduct->setPriceDifference($record->getPriceDifference());
        $marketProduct->setPriceMin($record->getPriceMin());
        $marketProduct->setPriceMax($record->getPriceMax());
        $marketProduct->setActive();

        return $marketProduct;
    }

    /**
     * @param MarketProduct $marketProduct
     * @param Record        $record
     *
     * @return Price
     *
     * @throws Exception
     */
    public function addMarketPrices(MarketProduct $marketProduct, Record $record): Price
    {
        $price = new Price();
        $price->setMarketProduct($marketProduct);
        $price->setPriceMin($record->getPriceMin());
        $price->setPriceMax($record->getPriceMax());
        $price->setPriceAvg($record->getPriceAvg());
        $price->setPriceDifference($record->getPriceDifference());
        $price->setStartDate(new DateTime($record->getPriceStartDate()));

        return $price;
    }
}
