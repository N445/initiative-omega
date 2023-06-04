<?php

namespace App\Controller\Admin;

use App\Admin\Filter\LastOnlineDurationFilter;
use App\Entity\Member\Member;
use App\Entity\Member\Xp;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function showGraph(AdminContext $context, ChartBuilderInterface $chartBuilder)
    {
        /** @var Member $member */
        $member = $context->getEntity()->getInstance();
        $chart  = $chartBuilder->createChart(Chart::TYPE_LINE);

        $labels = [];
        $data   = [];
        foreach ($member->getXpData() as $xpDatum) {
            $labels[] = $xpDatum->getDate()->format('d/m/Y H:i');
            $data[]   = $xpDatum->getValue();
        }

        $chart->setData([
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor'     => 'rgb(255, 99, 132)',
                    'data'            => $data,
                ],
            ],
        ]);

        return $this->render('admin/member/graph.html.twig', [
            'member' => $member,
            'chart'  => $chart,
        ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $showGraphAction = Action::new('showGraph', 'Voir le graph')
                                 ->linkToCrudAction('showGraph')
        ;
        return $actions
            ->add(Crud::PAGE_INDEX, $showGraphAction)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name'))
            ->add(TextFilter::new('guildedId'))
            ->add(DateTimeFilter::new('joinDate'))
            ->add(DateTimeFilter::new('lastOnline'))
            ->add(BooleanFilter::new('isDisplayOnDashboard'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Pseudo'),
            TextField::new('guildedId', 'ID Guilded'),
            AssociationField::new('user', 'Compte site web'),
            DateTimeField::new('joinDate', 'Date d\'inscription'),
            DateTimeField::new('lastOnline', 'Dernière connexion'),
            BooleanField::new('isDisplayOnDashboard', 'Visible sur le dashboard'),
            NumberField::new('lastOnlineDuration', 'Dernière connexion (jours)')->hideOnForm(),
            CollectionField::new('xpData', 'XP data')->onlyOnDetail()->setEntryIsComplex(),
        ];
    }
}
