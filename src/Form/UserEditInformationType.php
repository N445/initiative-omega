<?php

namespace App\Form;

use App\Entity\User;
use App\Form\User\InfoType;
use App\Form\User\ReferralType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Ton email',
                'attr'  => [
                    'class' => 'form-control-sm',
                ],
            ])
            ->add('info', InfoType::class)
            ->add('referral', ReferralType::class, [
                'label' => 'Referral Code',
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
