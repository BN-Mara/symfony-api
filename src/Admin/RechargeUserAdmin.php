<?php

namespace App\Admin;

use App\Entity\Competition;
use App\Entity\Notification;
use App\Entity\User;
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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


final class TicketPriceAdmin extends AbstractAdmin{

    public function __construct(private NotificationService $notifyer)
    {
        
    }

    protected function configureFormFields(FormMapper $form): void
    {
       
        $form->add('user', EntityType::class,[
            'class' => User::class,
            'choice_label' => 'username',
            'multiple' => false,
            'expanded' => false,
        ]);
        $form->add('amount', NumberType::class);
 
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('user.username');
        $datagrid->add('amount');
        $datagrid->add('createdAt');
        $datagrid->add('updatedAt');
        
        

    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        
        $list->addIdentifier('price');
        $list->addIdentifier('description');
        $list->addIdentifier('createdAt');
        $list->addIdentifier('updatedAt');
        
    }

    protected function configureShowFields(ShowMapper $show): void
    {

        $show->add('price');
        $show->add('description');
        $show->add('createdAt');
        $show->add('updatedAt');

    }
    public function prePersist(object $ticket): void
    {
        
    }

    public function preUpdate(object $ticket): void
    {
        $ticket->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Africa/Kinshasa')));


      
    }

}