<?php

namespace App\Service;

use App\Entity\Driver;
use App\Interface\IDriverService;
use App\Repository\DriverRepository;
use Symfony\Component\Serializer\SerializerInterface;

class DriverService implements IDriverService
{
    private readonly DriverRepository $driverRepository;
    private readonly SerializerInterface $serializerInterface;

    public function __construct(DriverRepository $driverRepository, SerializerInterface $serializerInterface)
    {
        $this->driverRepository = $driverRepository;
        $this->serializerInterface = $serializerInterface;
    }

    public function getAllDrivers(int $pageNumber = 1, int $perPage = 10, string $keyword = '') : array
    {
        $context = [
            'groups' => ['list_driver'], // Specify groups if needed
        ];

        $drivers = $this->driverRepository->findByName($pageNumber, $perPage, $keyword);

        return json_decode($this->serializerInterface->serialize($drivers, 'json', $context), true);
    }

    public function getTotalDrivers(string $keyword = ''): int
    {
        return $this->driverRepository->totalDrivers($keyword);
    }

    public function getDriver(int $id) : Driver
    {
        $context = [
            'groups' => ['show_driver'], // Specify groups if needed
        ];

        $driver = $this->driverRepository->find($id);

        return json_decode($this->serializerInterface->serialize($driver, 'json', $context), true);

    }
}