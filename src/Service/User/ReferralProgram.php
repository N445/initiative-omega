<?php

namespace App\Service\User;

use App\Entity\User\Referral;
use App\Repository\User\ReferralRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ReferralProgram
{
    public function __construct(
        private ReferralRepository     $referralRepository,
        private EntityManagerInterface $em
    )
    {
    }

    public function setNewReferral(): void
    {
        $referals = $this->referralRepository->getActiveReferrals();
        $first    = array_shift($referals);
        $first
            ->setIsActualToDisplay(true)
            ->setDisplayedAt(new \DateTimeImmutable('NOW'))
        ;
        foreach ($referals as $referal) {
            $referal->setIsActualToDisplay(false);
        }
        $this->em->flush();
    }

    public function getActualReferral(): ?Referral
    {
        return $this->referralRepository->getReferralToDisplay();
    }
}
