<?php

namespace App\Controller;

use App\DTOs\OrdersDTO;
use App\DTOs\SingleOrderDTO;
use App\Entity\Order;
use App\Interface\IOrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/orders', name: 'orders_')]
class OrderController extends AbstractController
{
    private readonly IOrderService $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
      response: 200,
      description: 'Returns all drivers',
      content: new OA\JsonContent(
          type: 'array',
          items: new OA\Items(ref: new Model(type: OrdersDTO::class, groups: ['full']))
      )
  )]
    #[OA\Parameter(
      name: 'per_page',
      in: 'query',
      description: 'The field used to show records per page',
      schema: new OA\Schema(type: 'int')
  )]
  #[OA\Parameter(
      name: 'page_number',
      in: 'query',
      description: 'The field used to show page of records',
      schema: new OA\Schema(type: 'int')
  )]
  #[OA\Parameter(
      name: 'name',
      in: 'query',
      description: 'The keyword is used to search orders by name',
      schema: new OA\Schema(type: 'string')
  )]
  #[OA\Parameter(
    name: 'status',
    in: 'query',
    description: 'The keyword is used to search orders by status',
    schema: new OA\Schema(type: 'string')
)]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');

        $orders = $this->orderService->getAllOrders($pageNumber, $perPage, $status, $name);
        $totalRecords = $this->orderService->getTotalOrders();
 
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
    #[OA\Response(
      response: 200,
      description: 'Returns single order',
      content: new OA\JsonContent(
          type: 'array',
          items: new OA\Items(ref: new Model(type: Order::class, groups: ['full']))
      )
  )]
  #[OA\Parameter(
      name: 'id',
      in: 'query',
      description: 'Id of the order',
      schema: new OA\Schema(type: 'int')
  )]
    public function show(int $id) : JsonResponse
    {
        $order = $this->orderService->getOrder($id);

        return $this->json(new SingleOrderDTO($order), 200);
    }
}
