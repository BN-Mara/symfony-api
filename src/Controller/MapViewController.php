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
        $conn = $this->em->getConnection();
        $data = array();
        foreach($vehicles as $v){
            $sql = '
            SELECT SUM(e.ticket_price) AS total FROM `route` e 
            WHERE DATE(e.starting_time) =  CURDATE() AND e.vehicle_id=:vehicleId';
        //die(var_dump($dql_sum));
        $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId()]);
        $res = $resultSet->fetchAllAssociative();
        $total = 0;
        if($res[0]["total"] != null){
            $total = $res[0]["total"];

        }
        
        //die(var_dump($res[0]["total"]));
        
            
           /* $all_routes = $v->getRoutes();
            $total = 0;
            $routes = array_filter($all_routes, function ($element) {
                $today = new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));

                if (null !== $element->getStartingTime() && $today->diff($element->getStartingTime())->days == 0) {
                    
                    return TRUE;
                }
                return FALSE;
              });

              foreach($routes as $r){
                if($r->getTicketPrice() !== null){
                $total = $total + $r->getTicketPrice();
                }
              }*/
              $sql = '
              SELECT u.username, u.id, u.roles, l.created_at FROM user u 
              INNER JOIN logins l ON u.id = l.user_id WHERE u.vehicle_id = :vehicleId
              AND u.roles LIKE "%ROLE_DRIVER%" ORDER BY l.created_At DESC LIMIT 1;
            ';
            $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId()]);
            $res = $resultSet->fetchAllAssociative();
            
             
            $driver = "";
            $startingAt = "";
            if(isset($res[0]["username"])){
                $driver = $res[0]["username"];
            }
            if(isset($res[0]["created_at"])){
                $startingAt = $res[0]["created_at"];
            }
            $color = "blue";
            if($v->getRegion()->getId() == 1){
                $color = "red";
            }else if($v->getRegion()->getId() == 2){
                $color = "green";
            }else{
                $color = "blue";
            }

            array_push($data,["name"=>$v->getName(), "id"=>$v->getId(), 
            "lat"=>$v->getCurrentLat(),"lng"=>$v->getCurrentLng(), "total"=>$total,
              "driver"=>$driver,
              "startingAt"=>$startingAt,
              "color"=>$color
        ]);
            

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
