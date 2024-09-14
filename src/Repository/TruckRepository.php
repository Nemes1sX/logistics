<?php

namespace App\Repository;

use App\Entity\Truck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Truck>
 */
class TruckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Truck::class);
    }

    //    /**
    //     * @return Truck[] Returns an array of Truck objects
    //     */
        public function findByManufacturerOrStatus($manufacturer, $status): array
        {
            $qb = $this->createQueryBuilder('d');

                if ($manufacturer != '') { 
                   $qb = $qb->where($qb->expr()->like('d.manufacturer', ':val'))
                    ->setParameter('val', $manufacturer.'%');
                  }
                  if ($status != '') { 
                    $qb = $qb->andWhere('val', $status)
                    ->setParameter('val', $status);
                  }

                return  $qb->orderBy('t.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Truck
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
