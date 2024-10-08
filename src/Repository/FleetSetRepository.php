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
        public function findByManufacturer(int $pageNumber = 1, int $perPage = 10, string $manufacturer = null): array
        {
            $qb = $this->createQueryBuilder('f')
                ->leftJoin('f.drivers', 'd')
                ->leftJoin('f.trailer', 't')
                ->leftJoin('f.truck', 'u');
                if ($manufacturer != '') { 
                   $qb->where($qb->expr()->like('u.manfacturer', ':val'))
                    ->setParameter('val', $manufacturer.'%');
                  }
               return $qb->addSelect('d', 't', 'u')
                ->orderBy('f.id', 'ASC')
                ->setFirstResult(($pageNumber - 1) * $perPage)
                ->setMaxResults($perPage)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findOneById(int $id): ?FleetSet
        {
            return $this->createQueryBuilder('f')
            ->leftJoin('f.drivers', 'drivers')->addSelect('drivers') // Eager load drivers
            ->leftJoin('f.trailer', 'trailer')->addSelect('trailer') // Eager load trailer
            ->leftJoin('f.truck', 'truck')->addSelect('truck')       // Eager load truck
            ->leftJoin('f.orders', 'orders')->addSelect('orders') 
                ->andWhere('f.id = :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

        public function totalFleetSets(string $manufacturer = null) : int
        {
            $qb = $this->createQueryBuilder('f')->select('count(f.id)');

            if ($manufacturer != '') { 
               $qb->where($qb->expr()->like('u.manfacturer', ':val'))
                ->setParameter('val', $manufacturer.'%');
              }

           return $qb->getQuery()
            ->getSingleScalarResult()
        ;
        }
}
