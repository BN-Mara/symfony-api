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
use Symfony\Component\Form\CallbackTransformer;

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
        $form->add('roles',CollectionType::class,[
            'required' => true,
            'entry_type' => ChoiceType::class,
            'entry_options'  => [
                'choices'  => [
                    'User' => 'ROLE_USER',
                    'Convoyeur' => 'ROLE_CONVEYOR',
                    'Chauffeur' => 'ROLE_DRIVER'
                ]
            ],
        
        ])
        ;
        $form->add('tagUid', TextType::class,[
            'required'=>false
        ]);
       /*$form->get('roles')->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                 // transform the array to a string
                 //die(var_dump($rolesArray));
                 return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                 // transform the string back to an array
                 return [$rolesString];
            }
    ));*/

        
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('fullname');
        $datagrid->add('phone');
        $datagrid->add('userame');
        $datagrid->add('isActive');
        $datagrid->add('roles');
        $datagrid->add('tagUid');
    
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('username');
        $list->addIdentifier('fullname');
        $list->addIdentifier('phone');
        $list->addIdentifier('roles');
        $list->addIdentifier('isActive');
        $list->addIdentifier('tagUid');

        
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
        $show->add('fullname');
        $show->add('phone');
        $show->add('address');
        $show->add('isActive');
        $show->add('roles');
        $show->add('tagUid');
        
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