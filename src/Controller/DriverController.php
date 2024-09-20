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

#[Route('/api', name: 'driver_')]
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
    public function index(Request $request) : JsonResponse
    {       
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $keyword = $request->query->get('keyword', '');
        $drivers = $this->driverRepository->findByName($keyword);
        $totalRecords = $this->entityManager->getRepository(Driver::class)->count();

        //dd($drivers);

        return $this->json([
            'data' => array_map(function (Driver $driver) {
                return new DriversDTO($driver);
            }, $drivers),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/driver/{id}', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        $driver = $this->entityManager->getRepository(Driver::class)->find($id);

        return $this->json([$driver], 200);
    }

}
