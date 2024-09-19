<?php

namespace App\Controller;

use App\DTOs\TrailersDTO;
use App\Entity\Trailer;
use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TrailerController extends AbstractController
{
    private readonly TruckRepository $truckRepository;

    public function __construct(TruckRepository $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }

    #[Route('/trailer', name: 'app_trailer')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');
        $trailers = $this->truckRepository->findByNameOrStatus($name, $status); 
        $totalRecords = $entityManager->getRepository(Trailer::class)->count();
   
         
        return $this->json([
            'data' => array_map(function (Trailer $trailer) {
                return new TrailersDTO($trailer);
            }, $trailers),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }
}
