<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Interface\IDriverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/drivers', name: 'driver_')]
class DriverController extends AbstractController
{
    private readonly IDriverService $driverSerivce;

    public function __construct(IDriverService $driverSerivce)
    {
        $this->driverSerivce = $driverSerivce;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all drivers',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Driver::class, groups: ['list_driver']))
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
        name: 'keyword',
        in: 'query',
        description: 'The keyword is used to search drivers by name',
        schema: new OA\Schema(type: 'string')
    )]
    public function index(Request $request) : JsonResponse
    {       
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $keyword = $request->query->get('keyword', '');

        $totalRecords = $this->driverSerivce->getTotalDrivers($keyword);

        return $this->json([
            'data' => $this->driverSerivce->getAllDrivers($pageNumber, $perPage, $keyword),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns single driver',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Driver::class, groups: ['show_driver']))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'query',
        description: 'Id of the driver',
        schema: new OA\Schema(type: 'int')
    )]
    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        $driver = $this->driverSerivce->getDriver($id);

        return $this->json([$driver], 200);
    }

}
