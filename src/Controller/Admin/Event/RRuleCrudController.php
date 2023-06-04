<?php

namespace App\Controller\Admin\Event;

use App\Entity\Event\RRule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RRuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RRule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('FREQUENCY'),
            TextField::new('DTSTART'),
            TextField::new('FREQUENCY_INTERVAL'),
            TextField::new('WKST'),
            TextField::new('COUNT'),
            TextField::new('UNTIL'),
            TextField::new('BYMONTH'),
            TextField::new('BYWEEKNO'),
            TextField::new('BYYEARDAY'),
            TextField::new('BYMONTHDAY'),
            TextField::new('BYDAY'),
            TextField::new('BYHOUR'),
            TextField::new('BYMINUTE'),
            TextField::new('BYSECOND'),
            TextField::new('BYSETPOS'),
        ];
    }
}
