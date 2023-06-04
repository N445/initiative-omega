<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function traiterContacts(BatchActionDto $batchActionDto)
    {
        $className = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getManagerForClass($className);
        foreach ($batchActionDto->getEntityIds() as $id) {
            /** @var Contact $contact */
            $contact = $entityManager->find($className, $id);
            $contact->setIsTraited(true);
        }

        $entityManager->flush();

        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->remove(Crud::PAGE_INDEX, Action::NEW)
                       ->remove(Crud::PAGE_INDEX, Action::EDIT)
                       ->add(Crud::PAGE_INDEX, Action::DETAIL)
                       ->addBatchAction(Action::new('approve', 'Traiter')
                                              ->linkToCrudAction('traiterContacts')
                                              ->addCssClass('btn btn-primary'))
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('email'))
            ->add(DateTimeFilter::new('send_at'))
            ->add(ChoiceFilter::new('typeContact')->setChoices(array_combine(Contact::TYPE_CONTACTS, Contact::TYPE_CONTACTS))->canSelectMultiple())
            ->add(TextFilter::new('message'))
            ->add(BooleanFilter::new('is_traited'))
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['send_at' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            DateTimeField::new('send_at', 'Envoyé le'),
            TextField::new('typeContact', 'Type de contact'),
            TextareaField::new('message'),
            BooleanField::new('is_traited', 'Traité'),
        ];
    }
}
