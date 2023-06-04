<?php

namespace App\Service\Rsi;

use App\Entity\Rsi\Ship\Ship;
use App\Message\ShipBannerDownloader;
use Symfony\Component\Messenger\MessageBus;

class RsiShipImporter extends BaseImporter
{
    public function importNewShips()
    {
        $existingShips = [];
        foreach ($this->shipRepository->findAll() as $ship) {
            $existingShips[$ship->getRsiId()] = $ship;
        }

        $ships = $this->rsiShipProvider->getShips($existingShips);

        $bus = new MessageBus();

        $addedShips = 0;
        foreach ($ships as $ship) {
//            if (!array_key_exists($ship->getRsiId(), $existingShips)) {
//                $this->em->persist($ship);
//                $addedShips++;
//                $bus->dispatch(new ShipBannerDownloader($ship));
//            }

            $this->em->persist($ship);
            $addedShips++;
        }
        $this->em->flush();
        return $addedShips;
    }
}
