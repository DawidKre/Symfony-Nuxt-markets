<?php

namespace App\Repository;

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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MasterProduct::class);
    }

    // /**
    //  * @return MasterProduct[] Returns an array of MasterProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MasterProduct
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
