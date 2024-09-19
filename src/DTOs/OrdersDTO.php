<?php

namespace App\DTOs;

use App\Entity\Order;
use DateTimeImmutable;

class OrdersDTO
{
    public string $id;
    public string $name;
    public string $status;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(Order $order)
    {
        $this->id = $order->getId();
        $this->name = $order->getName();
        $this->status = $order->getStatus();
        $this->createdAt = $order->getCreatedAt();
        $this->updatedAt = $order->getUpdatedAt();
    }
}