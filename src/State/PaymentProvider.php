<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;

class PaymentProvider implements ProviderInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $payment = $this->entityManager->getRepository(Payment::class)->find($uriVariables['id']);
        $postData = ["PayType"=>"MaxiCash","Amount"=>$payment->getAmount(),"Currency"=>$payment->getCurrency(),
        "Telephone"=>$payment->getPhone(),"Email"=>$payment->getEmail(),"MerchantID"=>"2bd7fd5caedc48dd8c5bcabee629812b","MerchantPassword"=>"55a6046137584680abddafe262985ff2",
        "Language"=>"fr","Reference"=>$payment->getReference(),"Accepturl"=>"https://maajaburafiki.com/web/success",
        "Cancelurl"=>"https://maajaburafiki.com/web/failed","Declineurl"=>"https://maajaburafiki.com/web/failed",
        "NotifyURL"=>"https://maajaburafiki.com/web/failed"];
        $payment->setPaymentUrl("maxicash.com?data=3");
        $jsonData = json_encode($postData);
        $maxiUrl = 'https://api.maxicashapp.com/payentry?data='.$jsonData;
        $payment->setPaymentUrl($maxiUrl);
        return $payment;

    }
}
