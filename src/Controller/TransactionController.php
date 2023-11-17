<?php

namespace App\Controller;

use App\Entity\NfcCard;
use App\Entity\RechargeCarte;
use App\Entity\Route as EntityRoute;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em){

    }
    #[Route('/transaction', name: 'app_transaction')]
    public function index(): Response
    {
        return $this->render('transaction/index.html.twig', [
            'controller_name' => 'TransactionController',
        ]);
    }
    #[Route('/transaction/process', name: 'app_transaction_process')]
    public function process(Request $request): Response
    {
        $decoded = json_decode($request->getContent());
        $cardUid = $decoded->uid;
        $routeId = $decoded->routeId;
        $amount = $decoded->amount;
        $card = $this->em->getRepository(NfcCard::class)->findOneBy(["uid"=>$cardUid]);
        $route = $this->em->getRepository(EntityRoute::class)->find($routeId);
        //$card = new NfcCard();
        if($card){
            if(!$card->isIsActive()){
                return $this->json(["status"=>false,"message"=>"Votre carte est invalide."],400);

            }
            $rest = $card->getBalance() - $amount;
            if($rest < 0){
                return $this->json(["status"=>false,"message"=>"Votre balance est insufisante."],400);
            }
            $card->setBalance($rest);
            $card->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Africa/Kinshasa')));
            $this->em->persist($card);
            $trans = new Transaction();
            $trans->setAmount($amount);
            $trans->setCard($card);
            $trans->setRoute($route);
            $this->em->persist($trans);
            $this->em->flush();
            return $this->json(["status"=>true,"message"=>"Paiement effectue avec succes"]);


        }else{
            return $this->json(["status"=>false,"message"=>"Votre carte est invalide."],400);
        }
        

    }
    #[Route('/api/transaction/recharge', name: 'app_transaction_recharge')]
    public function recharge(Request $request): Response
    {
        $decoded = json_decode($request->getContent());
        $cardUid = $decoded->uid;
        //$routeId = $decoded->routeId;
        $amount = $decoded->amount;
        $userId = $this->getUser()->getUserIdentifier();
        $user = $this->em->getRepository(User::class)->findOneBy(["username"=>$userId]);
        $card = $this->em->getRepository(NfcCard::class)->findOneBy(["uid"=>$cardUid]);
        
        //$card = new NfcCard();
        if($card){
            if(!$card->isIsActive()){
                return $this->json(["status"=>false,"message"=>"Votre carte est invalide."],400);

            }
            $rest = $user->getBalance() - $amount;
            if($rest < 0){
                return $this->json(["status"=>false,"message"=>"Votre balance est insufisante."],400);
            }
            $date = new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));
            $card->setBalance($card->getBalance() + $amount);
            $card->setUpdatedAt($date);
            $user->setBalance($rest);
            $user->setUpdatedAt($date);
            $this->em->persist($card);
            $trans = new RechargeCarte();
            $trans->setAmount($amount);
            $trans->setCard($card);
            $trans->setCreatedBy($user->getUsername());
            $trans->setCreatedAt($date);
            //$trans->setRouteId($routeId);
            $this->em->persist($trans);
            $this->em->flush();
            return $this->json(["status"=>true,"message"=>"Recharge effectuee avec succes","balance"=>$rest]);


        }else{
            return $this->json(["status"=>false,"message"=>"Votre carte est invalide."],400);
        }
        

    }

    #[Route('/api/card/create', name: 'app_card_create')]
    public function createCard(Request $request): Response
    {
        $by = $this->getUser()->getUserIdentifier();
        $decoded = json_decode($request->getContent());
        $cardUid = $decoded->uid;
        $holder = $decoded->cardHolder;
        $phoneNumber = $decoded->phoneNumber;
        if(property_exists($decoded, "balance"))
            $balance = $decoded->balance;
        else
            $balance = 0;
        $c = $this->em->getRepository(NfcCard::class)->findOneBy(["uid"=>$cardUid]);
        if($c){
            return $this->json(["success"=>false,"message"=>"Carte deja enregistree"],400);
        }
        $card = new NfcCard();
        $card->setUid($cardUid);
        $card->setCardHolder($holder);
        $card->setPhoneNumber($phoneNumber);
        if($balance >= 0)
            $card->setBalance($balance);
        else
            $card->setBalance(0);
        $card->setIsActive(true);
        $card->setCreatedBy($by);
        $this->em->persist($card);
        $this->em->flush();
        return $this->json(["success"=>true,"message"=>"Carte enregistree avec success"]);

    }
}
