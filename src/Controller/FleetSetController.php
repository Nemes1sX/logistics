<?php

namespace App\Controller;

use App\DTOs\FleetSetsDTO;
use App\DTOs\SingleFleetSetDTO;
use App\Entity\FleetSet;
use App\Interface\IFleetSetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/fleet-sets', name: 'fleet-set_')]
class FleetSetController extends AbstractController
{
    private readonly IFleetSetService $fleetSetService;

    public function __construct(IFleetSetService $fleetSetService)
    {
        $this->fleetSetService = $fleetSetService;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all drivers',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: FleetSetsDTO::class, groups: ['full']))
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
        description: 'The keyword is used to search fleet sets by manufacturer',
        schema: new OA\Schema(type: 'string')
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $fleetSets =  $this->fleetSetService->getAllFleetSets($pageNumber, $perPage, $manufacturer);
        $totalRecords = $this->fleetSetService->getTotalFleetSets();
    
        return $this->json([
            'data' => array_map(function(FleetSet $fleetSet) {
                return new FleetSetsDTO($fleetSet);
            }, $fleetSets),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns single fleet set',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: FleetSet::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'query',
        description: 'Id of the fleet set',
        schema: new OA\Schema(type: 'int')
    )]
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        $fleetSet = $this->fleetSetService->getFleetSet($id);

        return $this->json(new SingleFleetSetDTO($fleetSet), 200);
    }
}
