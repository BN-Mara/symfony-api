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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


final class TransactionAdmin extends AbstractAdmin{

    public function __construct(private NotificationService $notifyer)
    {
        
    }

    protected function configureFormFields(FormMapper $form): void
    {
       
       
        
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('amount');
        $datagrid->add('card.uid');
        $datagrid->add('createdAt');
        

    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        
        $list->addIdentifier('card.uid');
        $list->addIdentifier('amount');
        $list->addIdentifier('createdAt');
        $list->addIdentifier('routeId');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('card.uid');
        $show->add('card.cardHolder');
        $show->add('amount');
        $show->add('routeId');
        $show->add('createdAt');

    }
    public function prePersist(object $user): void
    {
        
    }

    public function preUpdate(object $user): void
    {
      
    }

}