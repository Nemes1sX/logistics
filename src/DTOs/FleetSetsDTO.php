<?php

namespace App\DTOs;

use App\Entity\FleetSet;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection;

class FleetSetsDTO
{
    public string $id;
    public string $name;
    public ?Collection $drivers;
    public string $trailerName;
    public string $truckManufacturer;
    public string $truckModel;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(FleetSet $fleetSet)
    {
        $this->id = $fleetSet->getId();
        $this->name = $fleetSet->getName();
        $this->drivers = $fleetSet->getDrivers();
        $this->trailerName = $fleetSet->getTrailer()->getName();
        $this->truckManufacturer = $fleetSet->getTruck()->getManufacturer();
        $this->truckModel = $fleetSet->getTruck()->getModel();
        $this->createdAt = CarbonImmutable::instance($fleetSet->getCreatedAt())->toDateString();
        $this->updatedAt = CarbonImmutable::instance($fleetSet->getUpdatedAt())->toDateString();
    }
}