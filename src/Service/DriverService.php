<?php

namespace App\Service;

use App\Entity\Driver;
use App\Interface\IDriverService;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;

class DriverService implements IDriverService
{
    private readonly DriverRepository $driverRepository;
    private readonly EntityManagerInterface $entityManager;

    public function __construct(DriverRepository $driverRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->driverRepository = $driverRepository;
        $this->entityManager = $entityManagerInterface;
    }

    public function getAllDrivers(int $pageNumber = 1, int $perPage = 10, string $keyword = '') : array
    {
        return $this->driverRepository->findByName($pageNumber, $perPage, $keyword);
    }

    public function getTotalDrivers(): int
    {
        return $this->entityManager->getRepository(Driver::class)->count();
    }

    public function getDriver(int $id) : Driver
    {
        return $this->entityManager->getRepository(Driver::class)->find($id);
    }
}