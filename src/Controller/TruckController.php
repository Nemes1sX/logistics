<?php

namespace App\Controller;

use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TruckController extends AbstractController
{
    private readonly TruckRepository $truckRepository;

    public function __construct(TruckRepository $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }
    
    #[Route('/truck', name: 'app_truck')]
    public function index(Request $request): JsonResponse
    {
        $manufacturer = $request->query->get('manufacturer', '');
        $status = $request->query->get('status', '');
        $trucks = $this->truckRepository->findByManufacturerOrStatus($manufacturer, $status);

        return $this->json([
            'data' => $trucks
        ]);
    }
}
