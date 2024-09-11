<?php

namespace App\Entity;

use App\Repository\FleetSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FleetSetRepository::class)]
class FleetSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Driver>
     */
    #[ORM\OneToMany(targetEntity: Driver::class, mappedBy: 'fleetSet')]
    private Collection $drivers;

    #[ORM\OneToOne(mappedBy: 'fleet_set', cascade: ['persist', 'remove'])]
    private ?Trailer $trailer = null;

    #[ORM\OneToOne(mappedBy: 'fleet_set', cascade: ['persist', 'remove'])]
    private ?Truck $truck = null;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
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

    /**
     * @return Collection<int, Driver>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(Driver $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->setFleetSet($this);
        }

        return $this;
    }

    public function removeDriver(Driver $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getFleetSet() === $this) {
                $driver->setFleetSet(null);
            }
        }

        return $this;
    }

   public function getTrailer(): ?Trailer
   {
       return $this->trailer;
   }

   public function setTrailer(Trailer $trailer): static
   {
       // set the owning side of the relation if necessary
       if ($trailer->getFleetSet() !== $this) {
           $trailer->setFleetSet($this);
       }

       $this->trailer = $trailer;

       return $this;
   }

   public function getTruck2(): ?Truck
   {
       return $this->truck;
   }

   public function setTruck2(Truck $truck): static
   {
       // set the owning side of the relation if necessary
       if ($truck->getFleetSet() !== $this) {
           $truck->setFleetSet($this);
       }

       $this->truck = $truck;

       return $this;
   }
}
