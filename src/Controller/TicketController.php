<?php

namespace App\Controller;

use App\Entity\TicketPrice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    #[Route('/api/ticket/{id}', name: 'app_ticket')]
    public function index($id): Response
    {
        $t = $this->em->getRepository(TicketPrice::class)->findOneBy(['region'=>$id]);
        if($t){
            return $this->json($t,200);

        }else{
            $t = $this->em->getRepository(TicketPrice::class)->find(1);
            return $this->json($t,200);

        }

    }
}
