<?php

namespace App\Form\User;

use App\Entity\User\Info;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rsiName', TextType::class, [
                'label'    => 'Pseudo RSI',
                'required' => false,
                'attr'     => [
                    'class' => 'form-control-sm',
                ],
            ])
            ->add('guildedName', TextType::class, [
                'label'    => 'Pseudo Guilded',
                'required' => false,
                'attr'     => [
                    'class' => 'form-control-sm',
                ],
            ])
            ->add('discordName', TextType::class, [
                'label'    => 'Pseudo Discord',
                'required' => false,
                'attr'     => [
                    'class' => 'form-control-sm',
                ],
            ])
//            ->add('ships', ChoiceType::class, [
//                'label' => 'Ta flotte',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Info::class,
        ]);
    }
}
