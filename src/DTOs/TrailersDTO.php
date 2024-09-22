<?php

namespace App\DTOs;

use App\Entity\Trailer;
use Carbon\CarbonImmutable;

class TrailersDTO
{
    public string $id;
    public string $name;
    public string $status;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(Trailer $trailer)
    {
        $this->id = $trailer->getId();
        $this->name = $trailer->getName();
        $this->status = $trailer->getStatus();
        $this->createdAt = CarbonImmutable::instance($trailer->getCreatedAt())->toDateTimeString();
        $this->updatedAt = CarbonImmutable::instance($trailer->getUpdatedAt())->toDateTimeString();
    }
}