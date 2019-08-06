<?php

namespace App\Repository;

use App\Entity\ImporterLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ImporterLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImporterLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImporterLog[]    findAll()
 * @method ImporterLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImporterLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ImporterLog::class);
    }

    /**
     * @return ImporterLog[]
     */
    public function getNotImported(): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->where('i.success = :success')
            ->setParameter('success', false);

        return $qb->getQuery()->getResult();
    }
}
