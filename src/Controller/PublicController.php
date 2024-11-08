<?php

namespace App\Controller;

use App\Entity\NfcCard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em){}
    #[Route('/', name: 'app_public')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }

    #[Route('/bus/mapview', name:'buses_map')]
    public function mapView(Request $request): Response{
        $code = $request->request->get('code');
        $type = $request->request->get('customer-type');
        
        $card = $this->em->getRepository(NfcCard::class)->findOneBy(['code'=> $code]);
        
        if(!$card){
            $this->addFlash('error',"Code fourni ($code)  ne correspond em aucune carte.");
            return $this->redirectToRoute('app_public');
        }
        $vehicles = $card->getLiness()[0]->getVehicles();
        
        return $this->render('public/mapview.html.twig', ['vehicles'=>$vehicles,"card"=>$card, "type"=>$type,"code"=>$code]);


    }
    #[Route('/bus/mapview/api', name:'buses_map-api')]
    public function mapViewJson(Request $request): Response{
        $code = $request->request->get('code');
        $type = $request->request->get('type');
        $card = $this->em->getRepository(NfcCard::class)->findOneBy(['code'=> $code]);
        if(!$card){
            $this->addFlash('error',"Code fourni ($code)  ne correspond em aucune carte.");
            return $this->json(["message"=>"Code fourni ($code)  ne correspond em aucune carte."],404);
        }
        $vehicles = $card->getLiness()[0]->getVehicles();
        return $this->json($vehicles, 200);


    }
}
