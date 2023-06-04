<?php

namespace App\Controller\Admin;

use App\Entity\Member\Xp;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class XpCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Xp::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('value', 'XP'),
            DateTimeField::new('date', 'Date'),
        ];
    }
}
