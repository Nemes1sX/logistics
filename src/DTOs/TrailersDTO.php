<?php

namespace App\DTOs;

use App\Entity\Trailer;

class TrailersDTO
{
    public string $id;
    public string $name;
    public string $status;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(Trailer $trailer)
    {
        $this->id = $trailer->getId();
        $this->name = $trailer->getName();
        $this->status = $trailer->getStatus();
        $this->createdAt = $trailer->getCreatedAt();
        $this->updatedAt = $trailer->getUpdatedAt();
    }
}