<?php

namespace App\Controller;

use App\DTOs\FleetSetsDTO;
use App\DTOs\SingleFleetSetDTO;
use App\Entity\FleetSet;
use App\Repository\FleetSetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/fleet-sets', name: 'fleet-set_')]
class FleetSetController extends AbstractController
{
    private readonly FleetSetRepository $fleetSetRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(FleetSetRepository $fleetSetRepository, EntityManagerInterface $entityManager)
    {
        $this->fleetSetRepository = $fleetSetRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $manufacturer = $request->query->get('manufacturer', '');
        $fleetSets =  $this->fleetSetRepository->findByManufacturer($pageNumber, $perPage, $manufacturer);
        $totalRecords = $this->entityManager->getRepository(FleetSet::class)->count();

        
        return $this->json([
            'data' => array_map(function(FleetSet $fleetSet) {
                return new FleetSetsDTO($fleetSet);
            }, $fleetSets),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        $fleetSet = $this->entityManager->getRepository(FleetSet::class)->find($id);

        return $this->json(new SingleFleetSetDTO($fleetSet), 200);
    }
}
