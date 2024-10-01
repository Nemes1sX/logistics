<?php

namespace App\Controller;

use App\DTOs\DriversDTO;
use App\Entity\Driver;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/drivers', name: 'driver_')]
class DriverController extends AbstractController
{
    private readonly DriverRepository $driverRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(DriverRepository $driverRepository, EntityManagerInterface $entityManager)
    {
        $this->driverRepository = $driverRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all drivers',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: DriversDTO::class, groups: ['full']))
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
        $drivers = $this->driverRepository->findByName($pageNumber, $perPage, $keyword);
        $totalRecords = $this->entityManager->getRepository(Driver::class)->count();

        return $this->json([
            'data' => array_map(function (Driver $driver) {
                return new DriversDTO($driver);
            }, $drivers),
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
            items: new OA\Items(ref: new Model(type: Driver::class, groups: ['full']))
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
        $driver = $this->entityManager->getRepository(Driver::class)->find($id);

        return $this->json([$driver], 200);
    }

}
