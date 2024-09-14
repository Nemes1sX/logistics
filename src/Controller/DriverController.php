<?php

namespace App\Controller;

use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api')]
class DriverController extends AbstractController
{
    private readonly DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    #[Route('/driver', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {   
        $keyword = $request->query->get('keyword', '');
        $drivers = $this->driverRepository->findByName($keyword);

        return $this->json([
            'data' => $drivers
        ]);
    }

    #[Route('/drivers', methods: ['GET'])]
    public function test() : JsonResponse
    {
        return  $this->json('Hello world');
    }

}
