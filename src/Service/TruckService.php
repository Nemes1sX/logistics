<?php

namespace App\Service;

use App\Entity\Truck;
use App\Interface\ITruckService;
use App\Repository\TruckRepository;
use Symfony\Component\Serializer\SerializerInterface;

class TruckService extends BaseService implements ITruckService
{
    private readonly TruckRepository $truckRepository;

    public function __construct(SerializerInterface $serializerInterface, TruckRepository $truckRepository)
    {
        parent::__construct($serializerInterface);
        $this->truckRepository = $truckRepository;
    }

    public function getAllTrucks(int $pageNumber = 1, int $perPage = 10, string $manufacturer = '', string $status = '') : array
    {
        $context = [
            'groups' => ['list_truck'], 
        ];

        $trucks = $this->truckRepository->findByManufacturerOrStatus($pageNumber, $perPage, $manufacturer, $status);

        return json_decode($this->serializer->serialize($trucks, 'json', $context), true);
    }

    public function getTotalTrucks(string $manufacturer = '', string $status = ''): int
    {
        return $this->truckRepository->totalTrucks($manufacturer, $status);
    }

    public function getTruck(int $id) : array
    {
        $context = [
            'groups' => ['show_truck'], 
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ];

        $truck = $this->truckRepository->find($id);

        return json_decode($this->serializer->serialize($truck, 'json', $context), true);
    }
}