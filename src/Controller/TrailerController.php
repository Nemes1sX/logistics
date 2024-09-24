<?php

namespace App\Controller;

use App\DTOs\TrailersDTO;
use App\Entity\Trailer;
use App\Repository\TrailerRepository;
use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/trailers', name: 'trailer_')]
class TrailerController extends AbstractController
{
    private readonly TrailerRepository $trailerRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(TrailerRepository $trailerRepository, EntityManagerInterface $entityManager)
    {
        $this->trailerRepository = $trailerRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');
        
        $trailers = $this->trailerRepository->findByNameOrStatus($pageNumber, $perPage, $name, $status); 
        $totalRecords = $this->entityManager->getRepository(Trailer::class)->count();
   
         
        return $this->json([
            'data' => array_map(function (Trailer $trailer) {
                return new TrailersDTO($trailer);
            }, $trailers),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])] 
    public function show(int $id) : JsonResponse
    {
        $trailer = $this->entityManager->getRepository(Trailer::class)->find($id);

        return $this->json($trailer, 200);
    }

}
