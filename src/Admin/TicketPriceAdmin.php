<?php

namespace App\Admin;

use App\Entity\Competition;
use App\Entity\Notification;
use App\Entity\Region;
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
    private $ts;

    public function __construct($ts,private NotificationService $notifyer)
    {
        $this->ts = $ts;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('region', EntityType::class,[
            'class' => Region::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
        ]);
       
        $form->add('price', TextType::class);
        $form->add('description', TextareaType::class);
 
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('region.name');
        $datagrid->add('price');
        $datagrid->add('description');
        $datagrid->add('createdAt');
        $datagrid->add('updatedAt');
        
        

    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('region.name');
        $list->addIdentifier('price');
        $list->addIdentifier('description');
        $list->addIdentifier('createdAt');
        $list->addIdentifier('updatedAt');
        
    }

    protected function configureShowFields(ShowMapper $show): void
    {

        $show->add('region.name');
        $show->add('price');
        $show->add('description');
        $show->add('createdAt');
        $show->add('updatedAt');

    }
    public function prePersist(object $ticket): void
    {
        $me = $this->ts->getToken()->getUser();;
        $ticket->setCreatedBy($me->getUsername());
    }

    public function preUpdate(object $ticket): void
    {
        $me = $this->ts->getToken()->getUser();;
        $ticket->setCreatedBy($me->getUsername());
        $ticket->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Africa/Kinshasa')));
      
    }

}