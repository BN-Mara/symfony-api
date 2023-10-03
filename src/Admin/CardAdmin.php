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


final class CardAdmin extends AbstractAdmin{

    public function __construct(private NotificationService $notifyer)
    {
        
    }

    protected function configureFormFields(FormMapper $form): void
    {
       
        $form->add('uid', TextType::class);
        $form->add('cardHolder', TextType::class);
        $form->add('phoneNumber', NumberType::class);
        $form->add('balance', NumberType::class);
        $form->add('isActive', CheckboxType::class);
        
        
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('uid');
        $datagrid->add('cardHolder');
        $datagrid->add('phoneNumber');
        $datagrid->add('balance');
        

    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        
        $list->addIdentifier('uid');
        $list->addIdentifier('cardHolder');
        $list->addIdentifier('phoneNumber');
        $list->addIdentifier('balance');
        $list->addIdentifier('createdAt');
        $list->addIdentifier('updatedAt');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('uid');
        $show->add('cardHolder');
        $show->add('phoneNumber');
        $show->add('createdAt');
        $show->add('updatedAt');

    }
    public function prePersist(object $user): void
    {
        
    }

    public function preUpdate(object $user): void
    {
      
    }

}