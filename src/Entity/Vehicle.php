<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource(operations:[new Get(), new Post(), new Put(),new GetCollection()])]
#[ApiFilter(SearchFilter::class,properties:['deviceID'=>'exact'])]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column(length: 24)]
    private ?string $matricule = null;

    #[ORM\Column(nullable: true)]
    private ?float $currentLat = null;

    #[ORM\Column(nullable: true)]
    private ?float $currentLng = null;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Route::class)]
    private Collection $routes;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $deviceID = null;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getCurrentLat(): ?float
    {
        return $this->currentLat;
    }

    public function setCurrentLat(?float $currentLat): self
    {
        $this->currentLat = $currentLat;

        return $this;
    }

    public function getCurrentLng(): ?float
    {
        return $this->currentLng;
    }

    public function setCurrentLng(?float $currentLng): self
    {
        $this->currentLng = $currentLng;

        return $this;
    }

    /**
     * @return Collection<int, Route>
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(Route $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes->add($route);
            $route->setVehicle($this);
        }

        return $this;
    }

    public function removeRoute(Route $route): self
    {
        if ($this->routes->removeElement($route)) {
            // set the owning side to null (unless already changed)
            if ($route->getVehicle() === $this) {
                $route->setVehicle(null);
            }
        }

        return $this;
    }

    public function getDeviceID(): ?string
    {
        return $this->deviceID;
    }

    public function setDeviceID(?string $deviceID): self
    {
        $this->deviceID = $deviceID;

        return $this;
    }
}
