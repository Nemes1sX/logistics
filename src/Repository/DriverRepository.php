<?php

namespace App\Repository;

use App\Entity\Driver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Driver>
 */
class DriverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Driver::class);
    }

    /**
     * @return Driver[] Returns an array of Driver objects
    */
    public function findByName(int $pageNumber = 1, int $perPage = 10, string $keyword = null): array
    {
        $qb = $this->createQueryBuilder('d');

          if ($keyword != '') { 
            $qb->where($qb->expr()->like('d.name', ':val'))
            ->setParameter('val', $keyword.'%');
          }
            return $qb->orderBy('d.id', 'ASC')
            ->setFirstResult(($pageNumber - 1) * $perPage)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getScalarResult()
            ->getResult()
           ;
       }

    public function findOneBySomeField($value): ?Driver
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
