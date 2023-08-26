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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

final class UserAdmin extends AbstractAdmin{

    public function __construct(private NotificationService $notifyer, private UserPasswordHasherInterface $passwordHasher)
    {
        
    }

    protected function configureFormFields(FormMapper $form): void
    {
       
        $form->add('fullname', TextType::class);
        $form->add('phone', TextType::class);
        $form->add('address', TextType::class);
        $form->add('isActive',CheckboxType::class);
        $form->add('username', TextType::class);
        $form->add('password', PasswordType::class);
        $form->add('roles',ChoiceType::class,[
            'required' => true,
            'multiple' => false,
            'expanded' => false,
           
                'choices'  => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_CONVEYOR'     => 'ROLE_CONVEYOR',
                    'ROLE_ADMIN'    => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN'    => 'ROLE_SUPER_ADMIN',
                ],
        
        ]);
        $form->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                 // transform the array to a string
                 return count(array($rolesArray))? $rolesArray[0]: null;
            },
            function ($rolesString) {
                 // transform the string back to an array
                 return [$rolesString];
            }
    ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('fullname');
        $datagrid->add('phone');
        $datagrid->add('userame');
        $datagrid->add('isActive');
        $datagrid->add('roles');
    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('username');
        $list->addIdentifier('fullname');
        $list->addIdentifier('phone');
        $list->addIdentifier('roles');
        $list->addIdentifier('isActive');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
        $show->add('fullname');
        $show->add('phone');
        $show->add('address');
        $show->add('isActive');
        $show->add('roles');
        
        
    }
    public function prePersist(object $user): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );

        $user->setPassword($hashedPassword);


        
    }

    public function preUpdate(object $user): void
    {
       
    }

}