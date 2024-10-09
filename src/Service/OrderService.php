<?php

namespace App\Service;

use App\Entity\Order;
use App\Interface\IOrderService;
use App\Repository\OrderRepository;
use Symfony\Component\Serializer\SerializerInterface;

class OrderService extends BaseService implements IOrderService
{
    private readonly OrderRepository $orderRepository;

    public function __construct(SerializerInterface $serializer, OrderRepository $orderRepository)
    {
        parent::__construct($serializer);
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        $context = [
            'groups' => ['list_order'], 
        ];

        $orders =  $this->orderRepository->findByStatus($pageNumber, $perPage, $name, $status);

        return json_decode($this->serializer->serialize($orders, 'json', $context), true);

    }

    public function getTotalOrders(string $name = '', string $status = ''): int
    {
        return $this->orderRepository->totalOrders($name, $status);
    }

    public function getOrder(int $id) : array
    {      
        $context = [
            'groups' => ['show_order'], 
        ];

        $order = $this->orderRepository->find($id);

        return json_decode($this->serializer->serialize($order, 'json', $context), true);
    }
}