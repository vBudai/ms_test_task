<?php

namespace App\Repository;

use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderItem>
 */
class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function getOrderItemsWithUserInfo(): array
    {
        return $this->createQueryBuilder('oi')
            ->select('p.name AS product_name', 'oi.cost AS price', 'oi.amount', 'u.id AS user_id')
            ->join('oi.product', 'p')
            ->join('oi.relatedOrder', 'o')
            ->join('o.relatedUser', 'u')
            ->getQuery()
            ->getArrayResult();
    }
}
