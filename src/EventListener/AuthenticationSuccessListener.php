<?php

namespace App\EventListener;

use App\Entity\Logins;
use App\Entity\UserData;
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
    $data['balance']  = $user->geBalance();
    if($user->getVehicle()){
    $vh = $user->getVehicle();
    $data['vehicle'] = ["id"=>$vh->getId(),"name"=>$vh->getName(),
    "matricule"=>$vh->getMatricule(),"currentLng"=>$vh->getCurrentLng(),
    "currentLat"=>$vh->getCurrentLat() ];
    }

    $event->setData($data);
}
}