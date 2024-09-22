<?php

namespace App\DTOs;

use App\Entity\Truck;
use Carbon\CarbonImmutable;

class TrucksDTO
{
    public string $id;
    public string $manufacturer;
    public string $model;
    public string $status;
    public string $createdAt;
    public string $updatedAt;
    
    public function __construct(Truck $truck)
    {
        $this->id = $truck->getId();
        $this->manufacturer = $truck->getManufacturer();
        $this->model = $truck->getModel();
        $this->status = $truck->getStatus();
        $this->createdAt = CarbonImmutable::instance($truck->getCreatedAt())->toDateString();
        $this->updatedAt = CarbonImmutable::instance($truck->getUpdatedAt())->toDateString();
    }
}