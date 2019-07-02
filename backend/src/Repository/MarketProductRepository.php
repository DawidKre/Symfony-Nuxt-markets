<?php

namespace App\Repository;

use App\Entity\MarketProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     *
     */
    public function findOneByName(string $name): ?MarketProduct
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param string $name
     *
     * @return MarketProduct|null
     */
    public function createByName(string $name): ?MarketProduct
    {
        $marketProduct = new MarketProduct();
        $marketProduct->setName($name);

        return $marketProduct;
    }
}
