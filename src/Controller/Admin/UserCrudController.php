<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\User\FleetType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('email'))
            ->add(BooleanFilter::new('isVerified'))
//            ->add(ChoiceFilter::new('roles')->setChoices(['Admin' => 'ROLE_ADMIN'])->canSelectMultiple())
            ->add(DateTimeFilter::new('registered_at'))
            ->add(DateTimeFilter::new('lastlogin_at'))
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email', 'Email'),
            TextField::new('frontName', 'Pseudo pour le front'),
            TextEditorField::new('signature', 'Signature'),
            BooleanField::new('isVerified', 'Compte vérifié'),
            AssociationField::new('guildedAccount', 'Compte guilded'),
            ChoiceField::new('roles', 'Roles')->setChoices(['Admin' => 'ROLE_ADMIN'])->allowMultipleChoices(),
            DateTimeField::new('registered_at', 'Inscrit le')->hideOnForm(),
            DateTimeField::new('lastlogin_at', 'Dernière connexion')->hideOnForm(),
            AssociationField::new('referral', 'Referral'),
            CollectionField::new('fleets', 'Flotte')->onlyOnIndex()->useEntryCrudForm()->setEntryIsComplex()->setTemplatePath('admin/user/fleet-list-index.twig'),
            CollectionField::new('fleets', 'Flotte')->hideOnIndex()->useEntryCrudForm()->setEntryIsComplex()->setTemplatePath('admin/user/fleet-list.twig'),
        ];
    }
}
