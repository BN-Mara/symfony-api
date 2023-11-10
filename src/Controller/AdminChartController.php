<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\Vehicle;
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
        $filter = 'all';
        $title = 'All';
        if($request->query->get('filter') !== NULL){

            $filter = $request->query->get('filter');
            
  
          }

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
        }
        
        
               array_push($arraysChart,[$v->getName(),$total]);
               //array_push($arraysChart,["mazda11",5000]);
               $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart();
               $chart->getData()->setArrayToDataTable($arraysChart);
               $chart->getOptions()->setTitle('Transactions par vehicule');
               $chart->getOptions()->getHAxis()->setTitle('Total');
               $chart->getOptions()->getHAxis()->setMinValue(0);
               $chart->getOptions()->getVAxis()->setTitle('Vehicule');
               $chart->getOptions()->setWidth(600);
               $chart->getOptions()->setHeight(600);

    
        //return $this->render('AppBundle::index.html.twig', array('piechart' => $pieChart));
        return $this->render('admin_chart/index.html.twig', [
            'controller_name' => 'AdminChartController',
            'piechart' => $chart
        ]);
    }
}
