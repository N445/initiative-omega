<?php

namespace App\Controller\Admin\Ship;

use App\Admin\Field\DateIntervalField;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class InfoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ship\Info::class;
    }



    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
//        ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
//            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('afterburner_speed', 'afterburner_speed m/s'),
            NumberField::new('beam', 'beam'),
            IntegerField::new('cargocapacity', 'cargocapacity'),
            IntegerField::new('chassis_id', 'chassis_id'),
            NumberField::new('height', 'height'),
            NumberField::new('length', 'length'),
            IntegerField::new('mass', 'mass kg'),
            IntegerField::new('max_crew', 'max_crew'),
            IntegerField::new('min_crew', 'min_crew'),
            NumberField::new('pitch_max', 'pitch_max'),
            TextField::new('production_note', 'production_note'),
            TextField::new('production_status', 'production_status'),
            NumberField::new('roll_max', 'roll_max'),
            NumberField::new('scm_speed', 'scm_speed'),
            TextField::new('size', 'size'),
//            DateIntervalField::new('time_modified', 'time_modified'),
            TextField::new('type', 'type'),
            NumberField::new('xaxis_acceleration', 'xaxis_acceleration'),
            NumberField::new('yaw_max', 'yaw_max'),
            NumberField::new('yaxis_acceleration', 'yaxis_acceleration'),
            NumberField::new('zaxis_acceleration', 'zaxis_acceleration'),
            TextField::new('description', 'description'),
            DateTimeField::new('time_modified_date', 'time_modified_date'),
//            TextField::new('avionic', 'avionic'),
//            TextField::new('modular', 'modular'),
//            TextField::new('propulsion', 'propulsion'),
//            TextField::new('thruster', 'thruster'),
//            TextField::new('weapon', 'weapon'),
        ];
    }
}
