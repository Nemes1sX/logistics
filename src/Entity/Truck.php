<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TruckRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Truck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_truck', 'list_truck'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_truck', 'list_truck'])]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_truck', 'list_truck'])]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_truck', 'list_truck'])]
    private ?string $license_plate = null;

    #[ORM\Column(length: 8)]
    #[Groups(['show_truck', 'list_truck'])]
    private ?string $status = null;

    #[ORM\OneToOne(inversedBy: 'truck', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['show_truck'])]
    private ?FleetSet $fleet_set = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_truck', 'list_truck'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_truck', 'list_truck'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->license_plate;
    }

    public function setLicensePlate(string $license_plate): static
    {
        $this->license_plate = $license_plate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getFleetSet(): ?FleetSet
    {
        return $this->fleet_set;
    }

    public function setFleetSet(FleetSet $fleet_set): static
    {
        $this->fleet_set = $fleet_set;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist] 
    public function onPrePersist()
    {
        $this->createdAt = new DateTimeImmutable();  // Set createdAt on insert
        $this->updatedAt = new DateTimeImmutable();  // Set updatedAt on insert
    }

    #[ORM\PreUpdate] 
    public function onPreUpdate()
    {
        $this->updatedAt = new DateTimeImmutable();  // Update updatedAt on every update
    }

}
