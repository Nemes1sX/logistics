<?php

namespace App\DTOs;

use App\Entity\Driver;
use DateTimeImmutable;

class DriversDTO
{
    public string $id;
    public string $name;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(Driver $driver)
    {
        $this->id = $driver->getId();
        $this->name = $driver->getName();
        $this->createdAt = $driver->getCreatedAt();
        $this->updatedAt = $driver->getUpdatedAt();
    }
}