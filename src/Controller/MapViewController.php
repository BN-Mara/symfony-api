<?php

namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapViewController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    #[Route('/admin/map/view', name: 'app_map_view')]
    public function index(): Response
    {
        $vehicles = $this->em->getRepository(Vehicle::class)->findAll();
        $data = array();
        foreach($vehicles as $v){
            array_push($data,["name"=>$v->getName(), "id"=>$v->getId(), 
            "lat"=>$v->getCurrentLat(),"lng"=>$v->getCurrentLng()]);

        }
        
       // $admin_pool = $this->get('sonata.admin.pool');
        return $this->render('map_view/index.html.twig', [
           // 'admin_pool' => $admin_pool,
            'vehicles' => json_encode($vehicles),
            'data'=>$data
        ]);
    }

    #[Route('/admin/map/auto', name: 'app_map_view_auto')]
    public function autoLoad(): Response
    {
        $vehicles = $this->em->getRepository(Vehicle::class)->findAll();
       // $admin_pool = $this->get('sonata.admin.pool');
       return $this->json($vehicles,200);
        /*return $this->render('map_view/index.html.twig', [
           // 'admin_pool' => $admin_pool,
            'name' => "maps"
        ]);*/
    }
    

}
