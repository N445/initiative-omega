<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Activités');
        $crud->setPageTitle(Crud::PAGE_NEW, 'Ajouter une activité');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'Edition d\'une activité');
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image', 'Image')->setBasePath('/uploads/images/activity')->hideOnForm(),
            DateTimeField::new('created_at', 'Ajouté le')->hideOnForm(),
            DateTimeField::new('updated_at', 'Derniere modification')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('content', 'Contenu')
                           ->setFormType(CKEditorType::class)
                           ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
                           ->setFormTypeOption('config_name', 'admin_config')
                           ->addCssClass('custom-ck-editor'),

            NumberField::new('displayOrder', 'Ordre d\'affichage'),
            BooleanField::new('isActive', 'Visible'),
            Field::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyOnForms(),
        ];
    }
}
