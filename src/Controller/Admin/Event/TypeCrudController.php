<?php

namespace App\Controller\Admin\Event;

use App\Entity\Event\Type;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Type                   $entityInstance
     * @return void
     */
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        foreach ($entityInstance->getEvents() as $event) {
            $event->setType(null);
            $entityManager->persist($event);
        }
        $entityManager->remove($entityInstance);
        $entityManager->flush();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom')->setColumns(6),
            TextField::new('title', 'Titre')->setColumns(6)->setHelp('Affiché sur le front'),
            ColorField::new('color', 'Couleur')->setRequired(false)->setColumns(6),
            FormField::addRow(),
            TextEditorField::new('content', 'Template')->setColumns(6)
                           ->setFormType(CKEditorType::class)
                           ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
                           ->setFormTypeOption('config_name', 'admin_config')
                           ->addCssClass('custom-ck-editor'),
            Field::new('imageFile', 'Image')->setFormType(VichImageType::class)->onlyOnForms()->setColumns(6),
            ImageField::new('image', 'Image')->setBasePath('/uploads/images/event-type')->hideOnForm(),
        ];
    }
}
