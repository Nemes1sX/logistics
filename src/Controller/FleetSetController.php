<?php

namespace App\Controller;

use App\Repository\FleetSetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class FleetSetController extends AbstractController
{
    private readonly FleetSetRepository $fleetSetRepository;

    #[Route('/fleet/set', name: 'app_fleet_set')]
    public function index(Request $request): JsonResponse
    {
        $manufacturer = $request->query->get('manufacturer', '');
        $fleetSets =  $this->fleetSetRepository->findByManufacturer($manufacturer);

        return $this->json([
            'data' => $fleetSets
        ]);
    }
}
