<?php

namespace App\Repository;

use App\Entity\ScraperCheck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScraperCheck|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScraperCheck|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScraperCheck[]    findAll()
 * @method ScraperCheck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScraperCheckRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScraperCheck::class);
    }

    // /**
    //  * @return ScraperCheck[] Returns an array of ScraperCheck objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScraperCheck
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
