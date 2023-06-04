<?php

namespace App\Controller\Admin\User;

use App\Entity\User\Referral;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReferralCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Referral::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user', 'Membre'),
            TextField::new('code', 'Code'),
            BooleanField::new('is_enabled', 'Actif'),
            BooleanField::new('is_actual_to_display', 'Actuellement affiché'),
            DateTimeField::new('displayed_at', 'Date de dernier affichage')->hideOnForm(),
        ];
    }
}
