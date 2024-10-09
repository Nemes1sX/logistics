<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
        public function findByStatus(int $pageNumber = 1, int $perPage = 10, string $status = '', string $keyword = null): array
        {
            $qb = $this->createQueryBuilder('o');

            if ($keyword != '') { 
             $qb->where($qb->expr()->like('o.name', ':val'))
              ->setParameter('val', $keyword.'%');
            }
            if ($status != '') { 
                $qb 
                ->andWhere('o.status = :val')
                ->setParameter('val', $status);
            }
            return $qb->orderBy('o.id', 'ASC')
                ->setFirstResult(($pageNumber - 1) * $perPage)
                ->setMaxResults($perPage)
                ->getQuery()
                ->getResult()
            ;
       }

       public function totalOrders(string $status = '', string $keyword = null) : int
       {
        $qb = $this->createQueryBuilder('o');

        if ($keyword != '') { 
         $qb->where($qb->expr()->like('o.name', ':val'))
          ->setParameter('val', $keyword.'%');
        }
        if ($status != '') { 
            $qb 
            ->andWhere('o.status = :val')
            ->setParameter('val', $status);
        }
        return $qb->getQuery()
            ->getSingleScalarResult()
        ;
       }
}
