<?php

namespace App\Controller;

use App\DTOs\OrdersDTO;
use App\DTOs\SingleOrderDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/orders', name: 'orders_')]
class OrderController extends AbstractController
{
    private readonly OrderRepository $orderRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(OrderRepository $orderRepository, EntityManagerInterface $entityManager)
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');

        $orders = $this->orderRepository->findByStatus($pageNumber, $perPage, $status, $name);
        $totalRecords = $this->entityManager->getRepository(Order::class)->count();
 
        return $this->json([
          'data' => array_map(function(Order $order) {
            return new OrdersDTO($order);
          }, $orders),
          'pageNumber' => $pageNumber,
          'totalRecords' => $totalRecords,
          'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);

        return $this->json(new SingleOrderDTO($order), 200);
    }
}
