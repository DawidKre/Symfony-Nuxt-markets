<?php

namespace App\BusinessLogic\Importer\Service;

use App\BusinessLogic\Scraper\Model\Record;
use App\Entity\MarketProduct;
use App\Repository\MarketProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

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
     * @param Record $record
     * @return MarketProduct
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getMarketProductByName(Record $record): MarketProduct
    {
        $marketProduct = $this->marketProductRepository->findOneBy(['name' => $record->getName()]);

        if ($marketProduct) {
            return $marketProduct;
        }

        return $this->marketProductRepository->createNewMarketProduct($record);
    }
}
