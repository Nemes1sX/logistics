<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, FleetSet>
     */
    #[ORM\ManyToMany(targetEntity: FleetSet::class, inversedBy: 'orders')]
    private Collection $fleetSet;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct()
    {
        $this->fleetSet = new ArrayCollection();
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

    /**
     * @return Collection<int, FleetSet>
     */
    public function getFleetSet(): Collection
    {
        return $this->fleetSet;
    }

    public function addFleetSet(FleetSet $fleetSet): static
    {
        if (!$this->fleetSet->contains($fleetSet)) {
            $this->fleetSet->add($fleetSet);
        }

        return $this;
    }

    public function removeFleetSet(FleetSet $fleetSet): static
    {
        $this->fleetSet->removeElement($fleetSet);

        return $this;
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
