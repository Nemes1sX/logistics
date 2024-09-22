<?php

namespace App\DTOs;

use App\Entity\Order;
use Carbon\CarbonImmutable;

class OrdersDTO
{
    public string $id;
    public string $name;
    public string $status;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(Order $order)
    {
        $this->id = $order->getId();
        $this->name = $order->getName();
        $this->status = $order->getStatus();
        $this->createdAt = CarbonImmutable::instance($order->getCreatedAt())->toDateString();
        $this->updatedAt = CarbonImmutable::instance($order->getUpdatedAt())->toDateString();
    }
}