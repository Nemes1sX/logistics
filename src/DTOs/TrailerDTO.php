<?php

namespace App\DTO;

use App\Entity\Trailer;

class TrailerDTO
{
    public string $id;
    public string $name;
    public string $status;

    public function __construct(Trailer $trailer)
    {
        $this->id = $trailer->getId();
        $this->name = $trailer->getName();
        $this->status = $trailer->getStatus();
    }
}