<?php

namespace App\Service;

use App\Entity\Truck;
use App\Interface\ITruckService;
use App\Repository\TruckRepository;

class TruckService implements ITruckService
{
    private readonly TruckRepository $truckRepository;

    public function __construct(TruckRepository $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }

    public function getAllTrucks(int $pageNumber = 1, int $perPage = 10, string $manufacturer = '', string $status = '') : array
    {
        return $this->truckRepository->findByManufacturerOrStatus($pageNumber, $perPage, $manufacturer, $status);
    }

    public function getTotalTrucks(): int
    {
        return $this->truckRepository->count();
    }

    public function getTruck(int $id) : Truck
    {
        return $this->truckRepository->find($id);
    }
}