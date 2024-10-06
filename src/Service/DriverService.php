<?php

namespace App\Service;

use App\Entity\Driver;
use App\Interface\IDriverService;
use App\Repository\DriverRepository;

class DriverService implements IDriverService
{
    private readonly DriverRepository $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function getAllDrivers(int $pageNumber = 1, int $perPage = 10, string $keyword = '') : array
    {
        return $this->driverRepository->findByName($pageNumber, $perPage, $keyword);
    }

    public function getTotalDrivers(): int
    {
        return $this->driverRepository->count();
    }

    public function getDriver(int $id) : Driver
    {
        return $this->driverRepository->find($id);
    }
}