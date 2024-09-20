<?php

namespace App\Controller;

use App\DTOs\TrucksDTO;
use App\Entity\Truck;
use App\Repository\TruckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/trucks', name: 'truck_')]
class TruckController extends AbstractController
{
    private readonly TruckRepository $truckRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(TruckRepository $truckRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->truckRepository = $truckRepository;
        $this->entityManager = $entityManagerInterface;
    }
    
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $status = $request->query->get('status', '');

        $trucks = $this->truckRepository->findByManufacturerOrStatus($pageNumber, $perPage, $manufacturer, $status);
        $totalRecords = $this->entityManager->getRepository(Truck::class)->count();

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
    public function show(int $id) : JsonResponse
    {
        $truck = $this->entityManager->getRepository(Truck::class)->find($id);

        return $this->json($truck, 200);
    }
}
