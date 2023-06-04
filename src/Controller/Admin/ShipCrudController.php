<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Ship\InfoCrudController;
use App\Entity\Rsi\Ship\Manufacturer;
use App\Entity\Rsi\Ship\Ship;
use App\Repository\Rsi\Ship\ManufacturerRepository;
use App\Repository\Rsi\Ship\ShipRepository;
use App\Service\Rsi\RsiShipImporter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ShipCrudController extends AbstractCrudController
{
    private ShipRepository         $shipRepository;

    private ManufacturerRepository $manufacturerRepository;

    public static function getEntityFqcn(): string
    {
        return Ship::class;
    }

    public function __construct(
        ShipRepository         $shipRepository,
        ManufacturerRepository $manufacturerRepository
    )
    {
        $this->shipRepository         = $shipRepository;
        $this->manufacturerRepository = $manufacturerRepository;
    }


    public function import(RsiShipImporter $rsiShipImporter)
    {
        ini_set('max_execution_time', '300');
        $nbAddedShips = $rsiShipImporter->importNewShips();
        $this->addFlash('info', sprintf('%d ship importé', $nbAddedShips));
        return $this->redirectToRoute('admin', [
            'crudControllerFqcn' => ShipCrudController::class,
            'crudAction'         => Crud::PAGE_INDEX,
        ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $import = Action::new('import', 'Relancer l\'import')
                        ->linkToCrudAction('import')
                        ->createAsGlobalAction()
        ;

        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
//        ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, $import)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $types                = $this->shipRepository->getAllTypes();
        $manufacturers        = $this->manufacturerRepository->findAll();
        $manufacturersNames   = array_map(fn(Manufacturer $manufacturer) => $manufacturer->getName(), $manufacturers);
        $manufacturersIds     = array_map(fn(Manufacturer $manufacturer) => $manufacturer->getId(), $manufacturers);
        return $filters
//            ->add(NumericFilter::new('rsiId'))
            ->add(TextFilter::new('name'))
            ->add(ChoiceFilter::new('manufacturer')->setChoices(array_combine($manufacturersNames, $manufacturersIds)))
            ->add(ChoiceFilter::new('type')->setChoices(array_combine($types, $types)))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Ship'),
            ImageField::new('imageName', 'Image')->setBasePath('/uploads/images/rsi-ship')->hideOnForm(),
            //            NumberField::new('rsiId', 'ID RSI'),
            AssociationField::new('manufacturer', 'Fabriquant'),
            TextField::new('name', 'Nom'),
            TextField::new('type', 'Type'),
            UrlField::new('link', 'Lien RSI'),
            NumberField::new('getNbTotalInFleets', 'NB in corpo'),
            DateTimeField::new('updatedAt', 'Derniere mise à jour'),
            FormField::addTab('Information'),
            AssociationField::new('info', 'Info')->setCrudController(InfoCrudController::class),
        ];
    }
}
