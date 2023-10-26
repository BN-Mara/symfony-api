<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Region $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $voletJaune = null;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    const SERVER_PATH_TO_IMAGE_FOLDER = 'images/vehicles';
    /**
     * Unmapped property to handle file uploads
     */
    private ?UploadedFile $file = null;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getVoletJaune(): ?string
    {
        return $this->voletJaune;
    }

    public function setVoletJaune(?string $voletJaune): self
    {
        $this->voletJaune = $voletJaune;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setVehicle($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVehicle() === $this) {
                $user->setVehicle(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function setFile(?UploadedFile $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload(): void
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

       // we use the original file name here but you should
       // sanitize it at least to avoid any security issues

       // move takes the target directory and target filename as params
       $fname = $this->name.''.$this->matricule.'.jpg';
       //die(var_dump(dirname(__DIR__).self::SERVER_PATH_TO_IMAGE_FOLDER));
       $this->getFile()->move(
        self::SERVER_PATH_TO_IMAGE_FOLDER,
           $fname
       );

       // set the path property to the filename where you've saved the file
       $this->voletJaune = $fname;

       // clean up the file property as you won't need it anymore
       $this->setFile(null);
   }

   /**
    * Lifecycle callback to upload the file to the server.
    */
   public function lifecycleFileUpload(): void
   {
       $this->upload();
   }

   /**
    * Updates the hash value to force the preUpdate and postUpdate events to fire.
    */
   public function refreshUpdated(): void
   {
      $this->setUpdatedAt(new \DateTime());
      $this->lifecycleFileUpload();
   }

}
