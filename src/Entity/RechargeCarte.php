<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RechargeCarteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RechargeCarteRepository::class)]
#[ApiResource]
class RechargeCarte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $uidCarte = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 64)]
    private ?string $createdBy = null;

    public function __construct()
    {
       
        $this->createdAt = new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUidCarte(): ?string
    {
        return $this->uidCarte;
    }

    public function setUidCarte(string $uidCarte): self
    {
        $this->uidCarte = $uidCarte;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
