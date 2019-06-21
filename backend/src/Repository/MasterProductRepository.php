<?php

namespace App\Repository;

use App\Entity\MarketProduct;
use App\Entity\MasterProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MasterProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method MasterProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method MasterProduct[]    findAll()
 * @method MasterProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterProductRepository extends ServiceEntityRepository
{
    /**
     * MasterProductRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MasterProduct::class);
    }
}
