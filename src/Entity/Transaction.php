<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?NfcCard $card = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(nullable: true)]
    private ?int $routeId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;
    public function __construct()
    {
       
        $this->createdAt = new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCard(): ?NfcCard
    {
        return $this->card;
    }

    public function setCard(?NfcCard $card): self
    {
        $this->card = $card;

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

    public function getRouteId(): ?int
    {
        return $this->routeId;
    }

    public function setRouteId(?int $routeId): self
    {
        $this->routeId = $routeId;

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
}
