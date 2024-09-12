<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DriverController extends AbstractController
{
    private readonly DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    #[Route('/driver', name: 'app_driver')]
    public function index(Request $request): JsonResponse
    {   
        $keyword = $request->query->get('keyword', '');
        $drivers = $this->driverRepository->findByName($keyword);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DriverController.php',
        ]);
    }
}
