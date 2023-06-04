<?php

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

final class DateIntervalField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(DateIntervalType::class)
            ->setFormTypeOptions([
                'with_years'   => false,
                'with_months'  => false,
                'with_days'    => false,
                'with_hours'   => true,
                'with_minutes' => true,
                'with_seconds' => false,
                'with_weeks'   => false,
                //                'input'        => 'string',
                'widget'       => 'integer',
                'labels'       => [
                    'invert'  => null,
                    'years'   => 'Années',
                    'months'  => 'Mois',
                    'weeks'   => 'Semaines',
                    'days'    => 'Jours',
                    'hours'   => 'Heures',
                    'minutes' => 'Minutes',
                    'seconds' => 'Secondes',
                ],
            ])
        ;
    }
}
