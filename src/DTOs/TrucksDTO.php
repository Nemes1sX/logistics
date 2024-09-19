<?php

namespace App\DTOs;

use App\Entity\Truck;
use DateTimeImmutable;

class TrucksDTO
{
    public string $id;
    public string $manufacturer;
    public string $model;
    public string $status;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;
    
    public function __construct(Truck $truck)
    {
        $this->id = $truck->getId();
        $this->manufacturer = $truck->getManufacturer();
        $this->model = $truck->getModel();
        $this->status = $truck->getStatus();
        $this->createdAt = $truck->getCreatedAt();
        $this->updatedAt = $truck->getUpdatedAt();
    }
}