<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\PaymentRepository;
use App\State\PaymentProcessor;
use App\State\PaymentProvider;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ApiResource]
#[Post(processor: PaymentProcessor::class)]
#[Get(provider: PaymentProvider::class)]

class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 65)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 5)]
    private ?string $currency = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $paymentMode = null;

    private $paymentUrl;

    public function __construct(){
        $postData = ["PayType"=>"MaxiCash","Amount"=>$this->getAmount(),"Currency"=>$this->getCurrency(),
        "Telephone"=>$this->getPhone(),"Email"=>$this->getEmail(),"MerchantID"=>"2bd7fd5caedc48dd8c5bcabee629812b","MerchantPassword"=>"55a6046137584680abddafe262985ff2",
        "Language"=>"fr","Reference"=>$this->getReference(),"Accepturl"=>"https://maajaburafiki.com/web/success",
        "Cancelurl"=>"https://maajaburafiki.com/web/failed","Declineurl"=>"https://maajaburafiki.com/web/failed",
        "NotifyURL"=>"https://maajaburafiki.com/web/failed"];
            $this->setPaymentUrl("maxicash.com?data=3");
        $jsonData = json_encode($postData);
        $maxiUrl = 'https://api.maxicashapp.com/payentry?data='.$jsonData;
        $this->paymentUrl = $maxiUrl;
        $this->createdAt = new \DateTime();
        $this->status = 0;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getPaymentMode(): ?string
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?string $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }
    

    /**
     * Get the value of paymentUrl
     */ 
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * Set the value of paymentUrl
     *
     * @return  self
     */ 
    public function setPaymentUrl($paymentUrl)
    {
        $this->paymentUrl = $paymentUrl;

        return $this;
    }
}
