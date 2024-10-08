<?php

namespace App\Service;

use App\Entity\Driver;
use App\Interface\IDriverService;
use App\Repository\DriverRepository;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseService
{
    protected readonly SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}