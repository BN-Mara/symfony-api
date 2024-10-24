<?php

namespace App\EventListener;

use App\Entity\Line;
use App\Entity\Logins;
use App\Entity\Region;
use App\Entity\UserData;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    /**
 * @param AuthenticationSuccessEvent $event
 */
public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
{
    $data = $event->getData();
    $user = $event->getUser();

    if (!$user instanceof UserInterface) {
        return;
    }
    //$userData = $this->em->getRepository(UserData::class)->findOneBy(['uid'=>"15"]);
    $login = new Logins();
    $login->setUser($user);
    $this->em->persist($login);
    $this->em->flush();
    
    $data['sub'] = $user->getId();
    $data['username'] = $user->getUsername();
    $data['fullname'] = $user->getFullname();
    $data['phone'] = $user->getPhone();
    $data['isActive'] = $user->isIsActive();
    $data['address'] = $user->getAddress();
    $data['balance']  = $user->getBalance();

    if($user->getVehicle()){
    $vh = $user->getVehicle();
    $vehicle = $this->em->getRepository(Vehicle::class)->findOneBy(["id"=>$user->getVehicle()->getId()]);
    $line = $this->em->getRepository(Line::class)->findOneBy(["id"=>$vehicle->getLine()->getId()]);
        $places = $line->getPlaces();//$this->em->getRepository(Place::class)->findAll();
        $stops = $line->getStops();
        $region =   $this->em->getRepository(Region::class)->findOneBy(["id"=>$line->getRegion()->getId()]);
        $v=[
            "id"=>$vehicle->getId(),
    "name"=>$vehicle->getName(),
    "matricule"=>$vehicle->getMatricule(),
    "currentLat"=> $vehicle->getCurrentLat(),
    "currentLng"=> $vehicle->getCurrentLng(),
    "deviceID"=> $vehicle->getDeviceID(),
    "voletJaune"=>$vehicle->getVoletJaune(),
    "updatedAt"=>$vehicle->getUpdatedAt(),
    //"t"=>$vehicle->getLine(),
    "line"=>$line->getId(),
    "line1"=> [
        "id"=>$line->getId(),
        "region"=>$region->getId(),
        "enterprise"=>$line->getEnterprise()->getId(),
        "name"=>$line->getName(),
        "paymentType"=>$line->getPaymentType(),
        "ticketPrice"=>$line->getTicketPrice(),
        //"region"=>"/api/regions/".$line->getRegion()->getId(),
        "description"=>$line->getDescription(),
        "places"=>$places,
        "stops"=>$stops
        ]
    ];
    $data['vehicle'] = $v;
    }

    $event->setData($data);
}
}