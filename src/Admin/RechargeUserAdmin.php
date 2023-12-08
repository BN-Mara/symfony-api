<?php

namespace App\Admin;

use App\Entity\Competition;
use App\Entity\Notification;
use App\Entity\User;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
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
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;


final class RechargeUserAdmin extends AbstractAdmin{
    private $ts;
    public function __construct( $ts, private NotificationService $notifyer, private EntityManagerInterface $em)
    {
        $this->ts = $ts;
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
        $datagrid->add('createdBy');

        
        
    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        
        $list->addIdentifier('user.username');
        $list->addIdentifier('amount');
        $list->addIdentifier('createdAt');
        $list->add('createdBy');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {

        $show->add('user.username');
        $show->add('amount');
        $show->add('createdAt');
        $show->add('createdBy');

    }
    public function prePersist(object $recharge): void
    {
        //$user = $this->em->getRepository(User::class)->findBy(["username"])
        $user = $recharge->getUser();
        $me = $this->ts->getToken()->getUser();;
        $recharge->setCreatedBy($me->getUsername());
        if($user->getBalance() == null){
            $user->setBalance($recharge->getAmount());
        }else{
            $user->setBalance($user->getBalance() + $recharge->getAmount());
        }
            
            $user->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Africa/Kinshasa')));
            $this->em->flush();

        
        
        
    }

    public function preUpdate(object $recharge): void
    {
        //$ticket->setUpdatedAt(new \DateTime('now',new \DateTimeZone('Africa/Kinshasa')));
        return ;


      
    }

}