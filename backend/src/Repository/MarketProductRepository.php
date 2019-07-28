<?php

namespace App\Repository;

use App\BusinessLogic\Scraper\Model\Record;
use App\Entity\Market;
use App\Entity\MarketProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarketProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketProduct[]    findAll()
 * @method MarketProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketProductRepository extends ServiceEntityRepository
{
    /**
     * MarketProductRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketProduct::class);
    }

    /**
     * @param string $name
     *
     * @return MarketProduct
     */
    public function findOneByName(string $name): ?MarketProduct
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param Record $record
     *
     * @return MarketProduct
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createNewMarketProduct(Record $record): MarketProduct
    {
        $market = $this->_em->getRepository(Market::class)->findOneBy(['name' => $record->getMarket()]);
        $marketProduct = new MarketProduct();

        $marketProduct->setName($record->getName());
        $marketProduct->setMarket($market);
        $marketProduct->setAmount($record->getAmount());
        $marketProduct->setQuantity($record->getQuantity());
        $marketProduct->setUnit($record->getUnit());
        $marketProduct->setPriceAvgPrevious($record->getPriceAvgPrevious());
        $marketProduct->setPriceAvg($record->getPriceAvg());
        $marketProduct->setPriceDifference($record->getPriceDifference());
        $marketProduct->setPriceMin($record->getPriceMin());
        $marketProduct->setPriceMax($record->getPriceMax());

        $this->_em->persist($marketProduct);
        $this->_em->flush();

        return $marketProduct;
    }
}
