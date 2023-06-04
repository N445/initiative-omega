<?php

namespace App\Form;

use App\Entity\User;
use App\Form\User\FleetType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditFleetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fleets', CollectionType::class, [
                'label'         => false,
                'entry_type'    => FleetType::class,
                'by_reference'  => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'prototype_data' => (new User\Fleet()),
                'entry_options' => [
                    'attr' => ['class' => 'fleet-box'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
