<?php

namespace App\Controller\Admin\Event;

use App\Admin\Field\DateIntervalField;
use App\Admin\Field\RRuleField;
use App\Entity\Event\Date;
use App\Entity\Event\Event;
use App\Entity\Event\RRule;
use App\Entity\Event\Type;
use App\Form\Event\RRuleType;
use App\Repository\Event\TypeRepository;
use App\Service\Event\EventAvailableForHelper;
use App\Service\Event\EventTemplateProvider;
use App\Service\Event\EventTypes;
use DeepCopy\TypeFilter\Date\DateIntervalFilter;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventCrudController extends AbstractCrudController
{
    private EntityManagerInterface                                $em;

    private AdminUrlGenerator                                     $adminUrlGenerator;

    private RouterInterface                                       $router;

    private TypeRepository                                        $typeRepository;

    private \Vich\UploaderBundle\Templating\Helper\UploaderHelper $uploaderHelper;

    private ValidatorInterface                                    $validator;

    public function __construct(
        EntityManagerInterface                                $em,
        AdminUrlGenerator                                     $adminUrlGenerator,
        RouterInterface                                       $router,
        TypeRepository                                        $typeRepository,
        \Vich\UploaderBundle\Templating\Helper\UploaderHelper $uploaderHelper,
        ValidatorInterface                                    $validator
    )
    {
        $this->em                = $em;
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->router            = $router;
        $this->typeRepository    = $typeRepository;
        $this->uploaderHelper    = $uploaderHelper;
        $this->validator         = $validator;
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Event                  $entityInstance
     * @return void
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->clearData($entityInstance);
        $this->setEventDates($entityInstance);
        $entityInstance->setCreatedBy($this->getUser());
        $this->em->persist($entityInstance);
        $this->em->flush();
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Event                  $entityInstance
     * @return void
     * @throws \Exception
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->clearData($entityInstance);
        $this->setEventDates($entityInstance);
        $this->em->persist($entityInstance);
        $this->em->flush();
    }

    private function setEventDates(Event $event)
    {
        if ($this->validator->validate($event->getRrule())->count()) {
            return;
        }

        $event->setEndAt((clone $event->getStartAt())->add($event->getDuration()));

        $event->clearDates();
        if ($event->isHasRrule()) {
            $rruleObject = $event->getRrule()->getRRuleObject();
            $event->getRrule()->setIsInfinite($rruleObject->isInfinite());
            /** @var \DateTime $occurence */
            foreach ($rruleObject->getOccurrences() as $occurence) {
                $event->addDate((new Date($occurence, (clone $occurence)->add($event->getDuration()))));
            }
        }
    }

    private function clearData(Event $event)
    {
        $now   = new \DateTime('NOW');
        $futur = clone $now;
        $futur->add($event->getDuration());
        $interval = $now->diff($futur);
        $event->setDuration($interval);
    }

    public function configureActions(Actions $actions): Actions
    {
        $showFront = Action::new('showFront', 'Voir côté front')
                           ->linkToUrl(function (Event $event): string {
                               return $this->router->generate('EVENT', [
                                   'id' => $event->getId(),
                               ]);
                           })
        ;

        return $actions
//            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $showFront)
        ;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('admin-event')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('is_finished'))
            ->add(DateTimeFilter::new('created_at'))
            ->add(EntityFilter::new('created_by')->canSelectMultiple())
            ->add(EntityFilter::new('type')->canSelectMultiple())
            ->add(TextFilter::new('title'))
            ->add(TextFilter::new('content'))
            ->add(ChoiceFilter::new('availableFor')->setChoices(EventAvailableForHelper::getChoices()))
            ->add(TextFilter::new('location'))
            ->add(TextFilter::new('theme'))
            ->add(BooleanFilter::new('is_private'))
//            ->add(DateTimeFilter::new('duration'))
            ->add(BooleanFilter::new('has_rrule'))
            ->add(DateTimeFilter::new('start_at'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Contenu')->onlyOnForms(),
            BooleanField::new('is_finished', 'Terminé')->hideOnForm()->renderAsSwitch(false),
            DateTimeField::new('created_at', 'Ajouté le')->hideOnForm(),
            AssociationField::new('created_by', 'Ajouté par')->hideOnForm(),
            FormField::addPanel('Info sur l\'évenement'),
            FormField::addRow(),
            AssociationField::new('type')->setRequired(true)->setColumns(6)->setFormTypeOptions([
                'attr' => [
                    'data-get-template-url' => $this->adminUrlGenerator
                        ->setController(EventCrudController::class)
                        ->setAction('getEventTemplate')
                        ->generateUrl(),
                ],
            ]),
            TextField::new('title', 'Titre')->setColumns(6),
            FormField::addRow(),
            TextEditorField::new('content', 'Contenu')
                           ->setFormType(CKEditorType::class)
                           ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
                           ->setFormTypeOption('config_name', 'admin_config')
                           ->addCssClass('custom-ck-editor')
                           ->setColumns(6),
            Field::new('imageFile', 'Image')->setColumns(6)->setFormType(VichImageType::class)->onlyOnForms(),
            FormField::addTab('Organisation')->onlyOnForms(),
            ChoiceField::new('availableFor', 'L\'évent ouvert est ouvert à')->setColumns(3)->setChoices(EventAvailableForHelper::getChoices())->allowMultipleChoices(true)->onlyOnForms(),
            TextField::new('location', 'Lieu de respawn et de départ')->setColumns(3)->onlyOnForms(),
            TextField::new('theme', 'Thème de la soirée')->setColumns(3)->onlyOnForms(),
            CollectionField::new('extraInfoOrganisation', 'Infos supplémentaires')->setColumns(3)->onlyOnForms(),

            FormField::addTab('Options')->onlyOnForms(),
            BooleanField::new('is_private', 'Évenement privé')->renderAsSwitch(true),
            DateIntervalField::new('duration', 'Durée de l\'event')
                             ->setFormTypeOptions([
                                 'with_days' => true,
                             ])
                             ->setTemplatePath('admin/field/date_interval.html.twig')
            ,
            BooleanField::new('has_rrule', 'Évenement avec récurence')->renderAsSwitch(false)->hideOnForm(),
            BooleanField::new('has_rrule', 'Évenement avec récurence')->renderAsSwitch(true)->onlyOnForms(),
            FormField::addPanel('Date')->addCssClass('no-rrule-date'),
            DateTimeField::new('start_at', 'Début de l\'event'),
            FormField::addPanel('Réccurences')->addCssClass('rrule-date'),
            RRuleField::new('rrule', false)->onlyOnForms(),
            RRuleField::new('rrule', 'RRule')->setTemplatePath('admin/field/rrule.html.twig')->hideOnForm(),
        ];
    }

    public function getEventTemplate(Request $request)
    {
        if (!$id = $request->get('id')) {
            return $this->json([
                'title'    => null,
                'image'    => null,
                'template' => null,
            ]);
        }
        if (!$type = $this->typeRepository->find($id)) {
            return $this->json([
                'title'    => null,
                'image'    => null,
                'template' => null,
            ]);
        }
        return $this->json([
            'title'    => $type->getTitle(),
            'image'    => $type->getImage(),
            'template' => $type->getContent() ?: '',
        ]);
    }
}
