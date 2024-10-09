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

    public function getAllFleetSets(int $pageNumber = 1, int $perPage = 10, string $manufacturer = '') : array
    {
        $context = [
            'groups' => ['list_fleet-set'], 
        ];

        $fleetSets = $this->fleetSetRepository->findByManufacturer($pageNumber, $perPage, $manufacturer);

        return json_decode($this->serializer->serialize($fleetSets, 'json', $context), true);
    }

    public function getTotalFleetSets(string $manufacturer = ''): int
    {
        return $this->fleetSetRepository->totalFleetSets($manufacturer);
    }

    public function getFleetSet(int $id) : array
    {
        $context = [
            'groups' => ['show_fleet-set'], 
            'attributes' => [
                'id', 
                'createdAt', 
                'updatedAt',
                'name',
                'drivers' => ['id', 'name', 'licenseNumber'], // Include specific driver attributes
                'trailer' => ['name', 'status'],              // Include trailer attributes
                'truck' => ['manufacturer', 'model'],         // Include truck attributes
                'orders' => ['id', 'orderNumber', 'status']   // Include order attributes
            ],
            'circular_reference_handler' => function ($object) {
                return $object->getId(); // Handle circular references
            }
        ];

        $fleetSet = $this->fleetSetRepository->findOneById($id);
        //dd($fleetSet);

        return json_decode($this->serializer->serialize($fleetSet, 'json', $context), true);
    }
}