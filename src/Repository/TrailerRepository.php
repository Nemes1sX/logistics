<?php

namespace App\Repository;

use App\Entity\Trailer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trailer>
 */
class TrailerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trailer::class);
    }

    //    /**
    //     * @return Trailer[] Returns an array of Trailer objects
    //     */
        public function findByNameOrStatus(int $pageNumber = 1, int $perPage = 10, string $name = null, string $status = null): array
        {
            $qb = $this->createQueryBuilder('t');

            if ($name != '') { 
                $qb = $qb->where($qb->expr()->like('t.name', ':val'))
                ->setParameter('val', $name.'%');
              }
              if ($status != '') { 
                $qb =  $qb->andWhere('val', $status)
                ->setParameter('val', $status);
              }
               return $qb->orderBy('t.id', 'ASC')
               ->setFirstResult(($pageNumber - 1) * $perPage)
               ->setMaxResults($perPage)
                ->getQuery()
                ->getResult()
        ;
        }

    //    public function findOneBySomeField($value): ?Trailer
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
