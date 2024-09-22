<?php

namespace App\DTOs;

use App\Entity\Driver;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Entity\FleetSet;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection;

class FleetSetsDTO
{
    public string $id;
    public string $name;
    public Collection $drivers;
    public TrailersDTO $trailer;
    public TrucksDTO $truck;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(FleetSet $fleetSet)
    {
        $this->id = $fleetSet->getId();
        $this->name = $fleetSet->getName();
        $this->drivers = $fleetSet->getDrivers();
        $this->trailer = new TrailersDTO($fleetSet->getTrailer());
        $this->truck = new TrucksDTO($fleetSet->getTruck());
        $this->createdAt = CarbonImmutable::instance($fleetSet->getCreatedAt())->toDateString();
        $this->updatedAt = CarbonImmutable::instance($fleetSet->getUpdatedAt())->toDateString();
    }
}