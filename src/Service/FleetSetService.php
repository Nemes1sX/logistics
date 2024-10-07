<?php

namespace App\Service;

use App\Entity\FleetSet;
use App\Interface\IFleetSetService;
use App\Repository\FleetSetRepository;

class FleetSetService implements IFleetSetService
{
    private readonly FleetSetRepository $fleetSetRepository;

    public function __construct(FleetSetRepository $fleetSetRepository)
    {
        $this->fleetSetRepository = $fleetSetRepository;
    }

    public function getAllFleetSets(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        return $this->fleetSetRepository->findByManufacturer($pageNumber, $perPage, $name, $status);
    }

    public function getTotalFleetSets(): int
    {
        return $this->fleetSetRepository->count();
    }

    public function getFleetSet(int $id) : FleetSet
    {
        return $this->fleetSetRepository->find($id);
    }
}