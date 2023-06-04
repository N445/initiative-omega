<?php

namespace App\Form\User;

use App\Entity\Rsi\Ship\Ship;
use App\Entity\User\Fleet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FleetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberShips', NumberType::class, [
                'label' => 'Nombre de vaisseau',
                'attr'  => [
                    'min' => 1,
                ],
            ])
            ->add('ship', EntityType::class, [
                'label'        => 'Vaisseau',
                'class'        => Ship::class,
                'choice_attr'  => function (Ship $choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['data-ship-banner' => $choice->getBannerImage()];
                },
            ])
            ->add('isBuyInGame', CheckboxType::class, [
                'label'      => 'Achat in game',
                'required'   => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fleet::class,
        ]);
    }
}
