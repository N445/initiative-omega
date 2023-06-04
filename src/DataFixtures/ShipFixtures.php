<?php

namespace App\DataFixtures;

use App\Service\Rsi\RsiShipProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShipFixtures extends Fixture
{
    public const REFERENCE = 'ship_%d';

    private RsiShipProvider $rsiShipProvider;

    public function __construct(RsiShipProvider $rsiShipProvider)
    {
        $this->rsiShipProvider = $rsiShipProvider;
    }

    public function load(ObjectManager $manager): void
    {
        $ships = $this->rsiShipProvider->getShips();

        $nbimported = 0;
        foreach ($ships as $i => $ship) {
            $manager->persist($ship);
//            $this->addReference(sprintf(self::REFERENCE, $ship->getRsiId()), $ship);
            $nbimported++;
//            if ($i % 20 === 0) {
//                dump(sprintf('%d/%d', $nbimported,count($ships)));
//                $manager->flush();
//            }
            dump(sprintf('%d/%d', $nbimported,count($ships)));
            $manager->flush();
        }
        dump(sprintf('%d/%d', $nbimported,count($ships)));
        $manager->flush();
    }
}
