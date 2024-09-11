<?php

namespace App\Entity;

use App\Repository\TrailerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrailerRepository::class)]
class Trailer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'trailer', cascade: ['persist', 'remove'])]
    private ?FleetSet $fleetSet = null;

    #[ORM\Column(length: 8)]
    private ?string $status = null;

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

    public function setFleetSet(FleetSet $fleetSet): static
    {
        // set the owning side of the relation if necessary
        if ($fleetSet->getTrailer() !== $this) {
            $fleetSet->setTrailer($this);
        }

        $this->fleetSet = $fleetSet;

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
}
