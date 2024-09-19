<?php

namespace App\Controller;

use App\DTOs\DriversDTO;
use App\Entity\Driver;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api')]
class DriverController extends AbstractController
{
    private readonly DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    #[Route('/driver', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer) : JsonResponse
    {       
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $keyword = $request->query->get('keyword', '');
        $drivers = $this->driverRepository->findByName($keyword);
        $totalRecords = $entityManager->getRepository(Driver::class)->count();

        //dd($drivers);

        return $this->json([
            'data' => array_map(function (Driver $driver) {
                return new DriversDTO($driver);
            }, $drivers),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/drivers', methods: ['GET'])]
    public function test() : JsonResponse
    {
        return  $this->json('Hello world');
    }

}
