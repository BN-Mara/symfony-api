<?php

namespace App\Admin;

use App\Entity\Competition;
use App\Entity\Notification;
use App\Service\NotificationService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


final class VehicleAdmin extends AbstractAdmin{

    public function __construct(private NotificationService $notifyer)
    {
        
    }

    protected function configureFormFields(FormMapper $form): void
    {
       
        $form->add('name', TextType::class);
        $form->add('matricule', TextType::class);
        $form->add('currentLat', NumberType::class);
        $form->add('curretLng', NumberType::class);
        $form->add('deviceID', TextType::class);
        
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name');
        $datagrid->add('matricule');
        $datagrid->add('deviceID');
    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('name');
        $list->addIdentifier('matricule');
        $list->addIdentifier('deviceID');
        $list->addIdentifier('currentLat');
        $list->addIdentifier('currentLng');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name');
        $show->add('matricule');
        $show->add('deviceID');
        $show->add('currentLat');
        $show->add('currentLng');
        
    }
    public function prePersist(object $user): void
    {
        
    }

    public function preUpdate(object $user): void
    {
      
    }

}