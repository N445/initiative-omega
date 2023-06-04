<?php

namespace App\DataFixtures;

use App\Service\Init\ActivityInit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Process\Process;

class ActivityFixtures extends Fixture
{
    private ActivityInit $activityInit;

    public function __construct(ActivityInit $activityInit)
    {
        $this->activityInit = $activityInit;
    }

    public function load(ObjectManager $manager): void
    {
        $this->activityInit->init();
    }
}
