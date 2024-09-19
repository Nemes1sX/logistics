<?php

namespace App\Controller;

use App\Entity\FleetSet;
use App\Repository\FleetSetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class FleetSetController extends AbstractController
{
    private readonly FleetSetRepository $fleetSetRepository;

    #[Route('/fleet/set', name: 'app_fleet_set')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $fleetSets =  $this->fleetSetRepository->findByManufacturer($pageNumber, $perPage, $manufacturer);
        $totalRecords = $entityManager->getRepository(FleetSet::class)->count();

        
        return $this->json([
            'data' => $fleetSets,
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }
}
