<?php

namespace App\Controller;

use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TrailerController extends AbstractController
{
    private readonly TruckRepository $truckRepository;

    public function __construct(TruckRepository $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }

    #[Route('/trailer', name: 'app_trailer')]
    public function index(Request $request): JsonResponse
    {
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');
        $trailers = $this->truckRepository->findByNameOrStatus($name, $status);    
         
        return $this->json([
            'data' => $trailers
        ]);
    }
}
