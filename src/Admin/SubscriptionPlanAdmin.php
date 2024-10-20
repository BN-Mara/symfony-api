<?php
// src/Admin/SubscriptionPlanAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SubscriptionPlanAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('title')
            ->add('description', null, [
                'required' => false
            ])
            ->add('amount')
            ->add('duration',IntegerType::class,[
                'required'=> true,
                'label'=>"Number of days"
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add('amount')
            ->add('duration')
            ->add('createdBy')
            ->add('createdAt');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('amount')
            ->add('duration')
            ->add('createdBy')
            ->add('createdAt');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('amount')
            ->add('duration')
            ->add('createdBy')
            ->add('createdAt');
    }
    public function prePersist(object $user): void
    {
        
    }

    public function preUpdate(object $user): void
    {
      
    }

}