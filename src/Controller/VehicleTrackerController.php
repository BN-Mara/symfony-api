<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleTracker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleTrackerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
        
    }
    #[Route('/vehicle/tracker', name: 'app_vehicle_tracker')]
    public function index(): Response
    {
        return $this->render('vehicle_tracker/index.html.twig', [
            'controller_name' => 'VehicleTrackerController',
        ]);
    }
    #[Route('/api/vehicle/tracker/{id}', name: 'app_vehicle_tracker_update', methods: 'POST')]
    public function update(Request $request, $id): Response
    {
        $decoded = json_decode($request->getContent());
        $currentLat = $decoded->currentLat;
        $currentLng = $decoded->currentLng;
        
        $car = $this->em->getRepository(Vehicle::class)->find($id);
        if($car){
            $car->setCurrentLat($currentLat);
            $car->setCurrentLng($currentLng);
            $this->em->persist($car);
            $vt = new VehicleTracker();
            $vt->setLat($currentLat);
            $vt->setLng($currentLng);
            $this->em->persist($vt);
            $this->em->flush();
            return $this->json([$vt]);
        }
        return $this->json(["success"=>false, "message"=>"Some fields are missing."],400);
        
    }
}