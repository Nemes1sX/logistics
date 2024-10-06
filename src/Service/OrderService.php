<?php

namespace App\Service;

use App\Entity\Order;
use App\Interface\IOrderService;
use App\Repository\OrderRepository;

class OrderService implements IOrderService
{
    private readonly OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        return $this->orderRepository->findByStatus($pageNumber, $perPage, $name, $status);
    }

    public function getTotalOrders(): int
    {
        return $this->orderRepository->count();
    }

    public function getOrder(int $id) : Order
    {
        return $this->orderRepository->find($id);
    }
}