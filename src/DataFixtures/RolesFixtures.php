<?php

namespace App\DataFixtures;

use App\Service\Init\RoleInit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RolesFixtures extends Fixture
{
    private RoleInit $roleInit;

    public function __construct(RoleInit $roleInit)
    {
        $this->roleInit = $roleInit;
    }

    public function load(ObjectManager $manager): void
    {
        $this->roleInit->init();
    }
}
