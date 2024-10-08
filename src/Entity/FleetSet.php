<?php

namespace App\Entity;

use App\Repository\FleetSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: FleetSetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class FleetSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Driver>
     */
    #[MaxDepth(2)]
    #[ORM\OneToMany(targetEntity: Driver::class, mappedBy: 'fleetSet')]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private Collection $drivers;

    #[MaxDepth(1)]
    #[ORM\OneToOne(mappedBy: 'fleet_set', cascade: ['persist', 'remove'])]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?Trailer $trailer = null;

    #[MaxDepth(1)]
    #[ORM\OneToOne(mappedBy: 'fleet_set', cascade: ['persist', 'remove'])]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?Truck $truck = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    #[Groups(['show_fleet-set', 'list_fleet-set'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, fleet-set>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'fleetSet')]
    #[Groups(['show_fleet-set'])]
    private Collection $orders;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->orders = new ArrayCollection();
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

   public function getTruck(): ?Truck
   {
       return $this->truck;
   }

   public function setTruck(Truck $truck): static
   {
       // set the owning side of the relation if necessary
       if ($truck->getFleetSet() !== $this) {
           $truck->setFleetSet($this);
       }

       $this->truck = $truck;

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

   /**
    * @return Collection<int, Order>
    */
   public function getOrders(): Collection
   {
       return $this->orders;
   }

   public function addOrder(Order $order): static
   {
       if (!$this->orders->contains($order)) {
           $this->orders->add($order);
           $order->addFleetSet($this);
       }

       return $this;
   }

   public function removeOrder(Order $order): static
   {
       if ($this->orders->removeElement($order)) {
           $order->removeFleetSet($this);
       }

       return $this;
   }
}
