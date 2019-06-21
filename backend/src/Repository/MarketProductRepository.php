<?php

namespace App\Repository;

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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketProduct::class);
    }

    /**
     * @param string $name
     *
     * @return MarketProduct
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findOrCreateNewByName(string $name): MarketProduct
    {
        $marketProduct = $this->findOneBy(['name' => $name]);

        if (!$marketProduct) {
            $marketProduct = new MarketProduct();
            $marketProduct->setName($name);

            $this->_em->persist($marketProduct);
            $this->_em->flush();
        }

        return $marketProduct;
    }
}
