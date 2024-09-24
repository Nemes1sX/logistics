<?php

namespace App\DTOs;

use App\Entity\Driver;
use Carbon\CarbonImmutable;

class DriversDTO
{
    public string $id;
    public string $name;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(Driver $driver)
    {
        $this->id = $driver->getId();
        $this->name = $driver->getName();
        $this->createdAt = CarbonImmutable::instance($driver->getCreatedAt())->toDateString();
        $this->updatedAt = CarbonImmutable::instance($driver->getUpdatedAt())->toDateString();
    }
}