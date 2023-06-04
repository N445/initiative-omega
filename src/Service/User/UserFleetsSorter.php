<?php

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserFleetsSorter
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function fusionFleets(User $user)
    {
        $principalsFleets = [];
        foreach ($user->getFleets() as $fleeta) {
            foreach ($user->getFleets() as $fleetb) {
                if (in_array($fleetb->getId(), $principalsFleets)) {
                    continue;
                }
                if ($fleeta->getId() === $fleetb->getId()) {
                    continue;
                }
                if ($fleeta->getShip()->getId() !== $fleetb->getShip()->getId()) {
                    continue;
                }
                if ($fleeta->isIsBuyInGame() !== $fleetb->isIsBuyInGame()) {
                    continue;
                }
                $principalsFleets[] = $fleeta->getId();

                $fleeta->setNumberShips($fleeta->getNumberShips() + $fleetb->getNumberShips());
                $user->removeFleet($fleetb);
                $this->em->remove($fleetb);
            }
        }
        $this->em->flush();
    }
}
