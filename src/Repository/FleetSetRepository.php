<?php

namespace App\Repository;

use App\Entity\FleetSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FleetSet>
 */
class FleetSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FleetSet::class);
    }

        /**
         * @return FleetSet[] Returns an array of FleetSet objects
         */
        public function findByExampleField($manufacturer): array
        {
            $qb = $this->createQueryBuilder('f')
                ->leftJoin('f.drivers', 'd')
                ->leftJoin('f.trailers', 't')
                ->leftJoin('f.truck', 'u');
                if ($manufacturer != '') { 
                   $qb =  $qb->where($qb->expr()->like('u.manfacturer', ':val'))
                    ->setParameter('val', $manufacturer.'%');
                  }
               return $qb->orderBy('f.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?FleetSet
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
