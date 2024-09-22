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
        public function findByManufacturerOrStatus(int $pageNumber = 1, int $perPage = 10,  string $manufacturer = null, string $status = null): array
        {
            $qb = $this->createQueryBuilder('t');

                if ($manufacturer != '') { 
                   $qb->where($qb->expr()->like('t.manufacturer', ':val'))
                    ->setParameter('val', $manufacturer.'%');
                  }
                  if ($status != '') { 
                    $qb->andWhere('val', $status)
                    ->setParameter('val', $status);
                  }

                return  $qb->orderBy('t.id', 'ASC')
                ->setFirstResult(($pageNumber - 1) * $perPage)
                ->setMaxResults($perPage)
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
