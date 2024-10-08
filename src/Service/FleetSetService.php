<?php

namespace App\Service;

use App\Entity\FleetSet;
use App\Interface\IFleetSetService;
use App\Repository\FleetSetRepository;
use Symfony\Component\Serializer\SerializerInterface;

class FleetSetService extends BaseService implements IFleetSetService
{
    private readonly FleetSetRepository $fleetSetRepository;

    public function __construct(SerializerInterface $serializerInterface, FleetSetRepository $fleetSetRepository)
    {
        parent::__construct($serializerInterface);
        $this->fleetSetRepository = $fleetSetRepository;
    }

    public function getAllFleetSets(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        $context = [
            'groups' => ['list_fleet-set'], 
        ];

        $fleetSets = $this->fleetSetRepository->findByManufacturer($pageNumber, $perPage, $name, $status);

        return json_decode($this->serializer->serialize($fleetSets, 'json', $context), true);
    }

    public function getTotalFleetSets(): int
    {
        return $this->fleetSetRepository->count();
    }

    public function getFleetSet(int $id) : array
    {
        $context = [
            'groups' => ['list_fleet-set'], 
        ];

        $fleetSet = $this->fleetSetRepository->find($id);

        return json_decode($this->serializer->serialize($fleetSet, 'json', $context), true);
    }
}