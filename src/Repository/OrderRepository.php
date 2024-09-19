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
            $qb = $this->createQueryBuilder('d');

            if ($keyword != '') { 
             $qb = $qb->where($qb->expr()->like('d.name', ':val'))
              ->setParameter('val', $keyword.'%');
            }
               return $qb 
                ->andWhere('o.status = :val')
                ->setParameter('val', $status)
                ->orderBy('o.id', 'ASC')
                ->setFirstResult(($pageNumber - 1) * $perPage)
                ->setMaxResults($perPage)
                ->getQuery()
                ->getResult()
            ;
       }

    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
