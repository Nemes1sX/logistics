<?php

namespace App\Service;

use App\Entity\Driver;
use App\Interface\IDriverService;
use App\Repository\DriverRepository;
use Symfony\Component\Serializer\SerializerInterface;

class DriverService extends BaseService implements IDriverService
{
    private readonly DriverRepository $driverRepository;

    public function __construct(SerializerInterface $serializer, DriverRepository $driverRepository)
    {
        parent::__construct($serializer);
        $this->driverRepository = $driverRepository;
    }

    public function getAllDrivers(int $pageNumber = 1, int $perPage = 10, string $keyword = '') : array
    {
        $context = [
            'groups' => ['list_driver'], 
        ];

        $drivers = $this->driverRepository->findByName($pageNumber, $perPage, $keyword);

        return json_decode($this->serializer->serialize($drivers, 'json', $context), true);
    }

    public function getTotalDrivers(string $keyword = ''): int
    {
        return $this->driverRepository->totalDrivers($keyword);
    }

    public function getDriver(int $id) : array
    {
        $context = [
            'groups' => ['show_driver'],
        ];

        $driver = $this->driverRepository->find($id);

        return json_decode($this->serializer->serialize($driver, 'json', $context), true);

    }
}