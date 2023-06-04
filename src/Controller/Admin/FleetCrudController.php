<?php

namespace App\Controller\Admin;

use App\Entity\User\Fleet;
use App\Repository\Rsi\Ship\ShipRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class FleetCrudController extends AbstractCrudController
{
    private ShipRepository $shipRepository;

    private UserRepository $userRepository;

    public function __construct(
        ShipRepository $shipRepository,
        UserRepository $userRepository
    )
    {
        $this->shipRepository = $shipRepository;
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Fleet::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('ship')->setChoices($this->getShipChoices())->canSelectMultiple())
            ->add(NumericFilter::new('numberShips'))
            ->add(BooleanFilter::new('isBuyInGame'))
            ->add(ChoiceFilter::new('user')->setChoices($this->getUserChoices())->canSelectMultiple())
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('ship', 'Vaisseau'),
            NumberField::new('numberShips', 'Nombre de vaisseau'),
            BooleanField::new('isBuyInGame', 'Achat in game'),
            AssociationField::new('user', 'Utilisateur'),
        ];
    }

    private function getShipChoices()
    {
        $choices = [];
        foreach ($this->shipRepository->findAll() as $item) {
            $choices[$item->getName()] = $item->getId();
        }
        return $choices;
    }

    private function getUserChoices()
    {
        $choices = [];
        foreach ($this->userRepository->findAll() as $item) {
            $choices[$item->getUserIdentifier()] = $item->getId();
        }
        return $choices;
    }
}
