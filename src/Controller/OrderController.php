<?php

namespace App\Controller;

use App\DTOs\OrdersDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class OrderController extends AbstractController
{
    private readonly OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    #[Route('/orders', name: 'app_order')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');

        $orders = $this->orderRepository->findByStatus($pageNumber, $perPage, $status, $name);
        $totalRecords = $entityManager->getRepository(Order::class)->count();
 
        return $this->json([
          'data' => array_map(function(Order $order) {
            return new OrdersDTO($order);
          }, $orders),
          'pageNumber' => $pageNumber,
          'totalRecords' => $totalRecords,
          'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }
}
