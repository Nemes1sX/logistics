<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_driver', 'list_driver'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_driver', 'list_driver'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'drivers')]
    #[Groups(['show_driver'])]
    private ?FleetSet $fleetSet = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_driver', 'list_driver'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_driver', 'list_driver'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        // Set the default value for createdAt to the current time
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

   public function getFleetSet(): ?FleetSet
    {
        return $this->fleetSet;
    }

    public function setFleetSet(?FleetSet $fleetSet): static
    {
        $this->fleetSet = $fleetSet;

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
