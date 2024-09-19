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

#[Route('/api')]
class TruckController extends AbstractController
{
    private readonly TruckRepository $truckRepository;

    public function __construct(TruckRepository $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }
    
    #[Route('/trucks', name: 'app_truck')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $status = $request->query->get('status', '');

        $trucks = $this->truckRepository->findByManufacturerOrStatus($pageNumber, $perPage, $manufacturer, $status);
        $totalRecords = $entityManager->getRepository(Truck::class)->count();

        return $this->json([
            'data' => array_map(function (Truck $truck) {
                return new TrucksDTO($truck);
            }, $trucks),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }
}
