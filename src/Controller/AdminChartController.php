<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\Versement;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AdminChartController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    public function configureAssets()
    {
        
    }
    #[Route('/admin/chart', name: 'app_admin_chart')]
    public function index(Request $request): Response
    {

        $vehicles = $this->em->getRepository(Vehicle::class)->findAll();
        $conn = $this->em->getConnection();
        $trans = $this->em->getRepository(Transaction::class)->findAll();
        $vs = $this->em->getRepository(Vehicle::class)->findAll();
        $arraysChart = array(['Vehicle name', 'total amount']);
        $arraysChart2 = array(['Date','Total amount']);
        $filter = 'all';
        $title = 'All';
        $filter_vehicle = 'all';
        $fromDate = null;
        $todate = null;
        if($request->query->get('vehicle') !== NULL && $request->query->get('vehicle') !== ""){
            $filter_vehicle = $request->query->get('vehicle');
        }
        if($request->query->get('filter') !== NULL && $request->query->get('filter') !== ""){

            $filter = $request->query->get('filter');
            
  
        }else if($request->query->get('fromDate') !== NULL && $request->query->get('fromDate') !== ""){
            $fromDate = $request->query->get('fromDate');
            if($request->query->get('toDate') !== NULL && $request->query->get('toDate') !== ""){
                $todate = $request->query->get('toDate');
            }else{
                 $dt= new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));
                 $todate = $dt->format('Y-m-d');
            }

        }
        if($filter_vehicle == 'all'){
        foreach($vs as $v){
            if($filter == 'today'){
                $sql = '
                SELECT SUM(e.amount) AS total FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE DATE(e.created_at) =  CURDATE() AND r.vehicle_id=:vehicleId';
                $title = 'Today';

            }else if($filter == 'thismonth'){
                $sql = '
                SELECT SUM(e.amount) AS total FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id 
                WHERE MONTH(DATE(e.created_at)) =  MONTH(CURDATE()) AND r.vehicle_id=:vehicleId';
                $title = 'This Month';
            }else if($filter == 'thisweek'){
                $sql = '
                SELECT SUM(e.amount) AS total FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE YEARWEEK(DATE(e.created_at)) =  YEARWEEK(CURDATE()) AND r.vehicle_id=:vehicleId';
                $title = 'Ths Week';
            }else{
                $sql = '
                SELECT SUM(e.amount) AS total FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE r.vehicle_id=:vehicleId';
                $title = 'All';
            }
           
        //die(var_dump($dql_sum));
        $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId()]);
        $res = $resultSet->fetchAllAssociative();
        $total = 0;
        if($res[0]["total"] != null){
            $total = $res[0]["total"];

        }
        array_push($arraysChart,[$v->getName(),$total]);
        }
        //array_push($arraysChart,["mazda11",5000]);
        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart();
        $chart->getData()->setArrayToDataTable($arraysChart);
        $chart->getOptions()->setTitle('Transactions par vehicule');
        $chart->getOptions()->getHAxis()->setTitle('Total');
        $chart->getOptions()->getHAxis()->setMinValue(0);
        $chart->getOptions()->getVAxis()->setTitle('Vehicule');
        $chart->getOptions()->setWidth(600);
        $chart->getOptions()->setHeight(600);
    }else{
        $vk = $this->em->getRepository(Vehicle::class)->findOneBy(["name"=>$filter_vehicle]);
        if($filter == 'all'){
            if($fromDate != null){
                
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE (DATE(e.created_at) between DATE(:dateFrom) AND DATE(:dateTo)) AND r.vehicle_id=:vehicleId';
                $title = 'for '. $vk->getName().' - From '.$fromDate.' to '.$todate.' -' ;
                $resultSet = $conn->executeQuery($sql, ['vehicleId' => $vk->getId(), 'dateFrom'=>$fromDate, 'dateTo'=>$todate]);
            }else{
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE r.vehicle_id=:vehicleId';
                $title = 'for '. $vk->getName().' - All -';
                $resultSet = $conn->executeQuery($sql, ['vehicleId' => $vk->getId()]);
            }

        }else{
            if($filter == 'today'){
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE DATE(e.created_at) =  CURDATE() AND r.vehicle_id=:vehicleId';
                
                $title = 'for '. $vk->getName().' - Today -';

            }else if($filter == 'thismonth'){
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE MONTH(DATE(e.created_at)) =  MONTH(CURDATE()) AND r.vehicle_id=:vehicleId';
                
                $title = 'for '. $vk->getName().' - This Month -';
            }else if($filter == 'thisweek'){
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE YEARWEEK(DATE(e.created_at)) =  YEARWEEK(CURDATE()) AND r.vehicle_id=:vehicleId';
                
                $title = 'for '. $vk->getFullname().'- This Week -';
            }else{
                $sql = '
                SELECT SUM(e.amount) AS total, DATE(e.created_at) As creationDate FROM `transaction` e INNER JOIN `route` r ON
                e.route_id = r.id
                WHERE r.vehicle_id=:vehicleId';
                $title = 'for '. $vk->getFullname().' -All-';

            }
            $resultSet = $conn->executeQuery($sql, ['vehicleId' => $vk->getId()]);
        }
        
       
    //die(var_dump($dql_sum));
    
    $res = $resultSet->fetchAllAssociative();
    /*$total = 0;
    if($res[0]["total"] != null){
        $total = $res[0]["total"];

    }*/
    if($res){
    foreach($res as $r){
        
            array_push($arraysChart2,[$r["creationDate"],$r["total"]]);
       
    }
    }
     //array_push($arraysChart,["mazda11",5000]);
     $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart();
     $chart->getData()->setArrayToDataTable($arraysChart2);
     $chart->getOptions()->setTitle('Transaction par vehicule');
     $chart->getOptions()->getHAxis()->setTitle('Total');
     $chart->getOptions()->getVAxis()->setMinValue(0);
     $chart->getOptions()->getVAxis()->setTitle('Date');
     $chart->getOptions()->setWidth(600);
     $chart->getOptions()->setHeight(600);
    
    }
        
        
              
               

    
        //return $this->render('AppBundle::index.html.twig', array('piechart' => $pieChart));
        return $this->render('admin_chart/index.html.twig', [
            'controller_name' => 'AdminChartController',
            'piechart' => $chart,
            'vehicles'=>$vehicles,
            'title'=>$title
        ]);
    }

    #[Route('/admin/chart/versement', name: 'app_admin_chart_versement')]
    public function versementChart(Request $request): Response
    {
        $drivers = $this->em->getRepository(User::class)->findByRole("ROLE_DRIVER");
        $conn = $this->em->getConnection();
        //$vers = $this->em->getRepository(Versement::class)->findAll();

        $arraysChart = array(['Driver name', 'total amount']);
        $arraysChart2 = array(['Date','Total amount']);
        $filter = 'all';
        $filter_driver = 'all';
        $fromDate = null;
        $todate = null;
        $title = 'All';
        if($request->query->get('driver') !== NULL && $request->query->get('driver') !== ""){
            $filter_driver = $request->query->get('driver');
        }
        if($request->query->get('filter') !== NULL && $request->query->get('filter') !== ""){

            $filter = $request->query->get('filter');
            
  
        }else if($request->query->get('fromDate') !== NULL && $request->query->get('fromDate') !== ""){
            $fromDate = $request->query->get('fromDate');
            if($request->query->get('toDate') !== NULL && $request->query->get('toDate') !== ""){
                $todate = $request->query->get('toDate');
            }else{
                 $dt= new \DateTime('now',new \DateTimeZone('Africa/Kinshasa'));
                 $todate = $dt->format('Y-m-d');
            }

        }

if($filter_driver == 'all'){
        foreach($drivers as $v){
            if($filter == 'all'){
                if($fromDate != null){
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE e.driver_id=:vehicleId AND (DATE(e.created_at) between DATE(:dateFrom) AND DATE(:dateTo))';
                    $title = 'From '.$fromDate.' to '.$todate ;
                    $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId(), 'dateFrom'=>$fromDate, 'dateTo'=>$todate]);
                }else{
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE e.driver_id=:vehicleId';
                    $title = 'All';
                    $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId()]);
                }

            }else{
                if($filter == 'today'){
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE DATE(e.created_at) =  CURDATE() AND e.driver_id=:vehicleId';
                    $title = 'Today';
    
                }else if($filter == 'thismonth'){
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE MONTH(DATE(e.created_at)) =  MONTH(CURDATE()) AND e.driver_id=:vehicleId';
                    $title = 'This Month';
                }else if($filter == 'thisweek'){
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE YEARWEEK(DATE(e.created_at)) =  YEARWEEK(CURDATE()) AND e.driver_id=:vehicleId';
                    $title = 'Ths Week';
                }else{
                    $sql = '
                    SELECT SUM(e.amount) AS total FROM `versement` e 
                    WHERE e.driver_id=:vehicleId';
                    $title = 'All';

                }
                $resultSet = $conn->executeQuery($sql, ['vehicleId' => $v->getId()]);
            }
            
           
        //die(var_dump($dql_sum));
        
        $res = $resultSet->fetchAllAssociative();
        $total = 0;
        if($res[0]["total"] != null){
            $total = $res[0]["total"];

        }
        array_push($arraysChart,[$v->getUsername(),$total]);
        }
         //array_push($arraysChart,["mazda11",5000]);
         $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart();
         $chart->getData()->setArrayToDataTable($arraysChart);
         $chart->getOptions()->setTitle('Versement par User');
         $chart->getOptions()->getHAxis()->setTitle('Total');
         $chart->getOptions()->getHAxis()->setMinValue(0);
         $chart->getOptions()->getVAxis()->setTitle('User');
         $chart->getOptions()->setWidth(600);
         $chart->getOptions()->setHeight(600);
    }else{
        $d = $this->em->getRepository(User::class)->findOneBy(["username"=>$filter_driver]);
        if($filter == 'all'){
            if($fromDate != null){
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate  FROM `versement` e 
                WHERE e.driver_id=:vehicleId AND (DATE(e.created_at) between DATE(:dateFrom) AND DATE(:dateTo))';
                $title = 'for '. $d->getFullname().' - From '.$fromDate.' to '.$todate.' -' ;
                $resultSet = $conn->executeQuery($sql, ['vehicleId' => $d->getId(), 'dateFrom'=>$fromDate, 'dateTo'=>$todate]);
            }else{
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate FROM `versement` e 
                WHERE e.driver_id=:vehicleId';
                $title = 'for '. $d->getFullname().' - All -';
                $resultSet = $conn->executeQuery($sql, ['vehicleId' => $d->getId()]);
            }

        }else{
            if($filter == 'today'){
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate FROM `versement` e 
                WHERE DATE(e.created_at) =  CURDATE() AND e.driver_id=:vehicleId';
                $title = 'for '. $d->getFullname().' - Today -';

            }else if($filter == 'thismonth'){
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate FROM `versement` e 
                WHERE MONTH(DATE(e.created_at)) =  MONTH(CURDATE()) AND e.driver_id=:vehicleId';
                $title = 'for '. $d->getFullname().' - This Month -';
            }else if($filter == 'thisweek'){
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate FROM `versement` e 
                WHERE YEARWEEK(DATE(e.created_at)) =  YEARWEEK(CURDATE()) AND e.driver_id=:vehicleId';
                $title = 'for '. $d->getFullname().'- This Week -';
            }else{
                $sql = '
                SELECT e.amount AS total, DATE(e.created_at) As creationDate FROM `versement` e 
                WHERE e.driver_id=:vehicleId';
                $title = 'for '. $d->getFullname().' -All-';

            }
            $resultSet = $conn->executeQuery($sql, ['vehicleId' => $d->getId()]);
        }
        
       
    //die(var_dump($dql_sum));
    
    $res = $resultSet->fetchAllAssociative();
    /*$total = 0;
    if($res[0]["total"] != null){
        $total = $res[0]["total"];

    }*/
    if($res){
    foreach($res as $r){
        
            array_push($arraysChart2,[$r["creationDate"],$r["total"]]);
       
    }
    }
     //array_push($arraysChart,["mazda11",5000]);
     $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart();
     $chart->getData()->setArrayToDataTable($arraysChart2);
     $chart->getOptions()->setTitle('Versement par User');
     $chart->getOptions()->getHAxis()->setTitle('Total');
     $chart->getOptions()->getVAxis()->setMinValue(0);
     $chart->getOptions()->getVAxis()->setTitle('Date');
     $chart->getOptions()->setWidth(600);
     $chart->getOptions()->setHeight(600);
    
    }

         


   //return $this->render('AppBundle::index.html.twig', array('piechart' => $pieChart));
   return $this->render('admin_chart/versement_chart.html.twig', [
       'controller_name' => 'AdminChartController',
       'piechart' => $chart,
       'drivers'=>$drivers,
       'title'=>$title
   ]);

    }
}
