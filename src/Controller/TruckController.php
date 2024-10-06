<?php

namespace App\Controller;

use App\DTOs\TrucksDTO;
use App\Entity\Truck;
use App\Interface\ITruckService;
use App\Service\TruckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/trucks', name: 'truck_')]
class TruckController extends AbstractController
{
    private readonly ITruckService $truckService;

    public function __construct(TruckService $truckService)
    {
        $this->truckService = $truckService;
    }
    
    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all drivers',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: TrucksDTO::class, groups: ['full']))
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
        name: 'manufacturer',
        in: 'query',
        description: 'The keyword is used to search trucks by manufacturer',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'status',
        in: 'query',
        description: 'The keyword is used to search trucks by status',
        schema: new OA\Schema(type: 'string')
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $status = $request->query->get('status', '');

        $trucks = $this->truckService->getAllTrucks($pageNumber, $perPage, $manufacturer, $status);
        $totalRecords = $this->truckService->getTotalTrucks();

        return $this->json([
            'data' => array_map(function (Truck $truck) {
                return new TrucksDTO($truck);
            }, $trucks),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns single truck',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Truck::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'query',
        description: 'Id of the truck',
        schema: new OA\Schema(type: 'int')
    )]
    public function show(int $id) : JsonResponse
    {
        $truck = $this->truckService->getTruck($id);

        return $this->json($truck, 200);
    }
}
