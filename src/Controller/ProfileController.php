<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditFleetsType;
use App\Form\UserEditInformationType;
use App\Form\UserEditPasswordType;
use App\Repository\User\FleetRepository;
use App\Service\User\UserFleetsSorter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    #[Route('/profile', name: 'PROFILE', methods: ['GET', 'POST'])]
    public function index(Request $request, UserFleetsSorter $userFleetsSorter): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $formEditInformation = $this->createForm(UserEditInformationType::class, $user);
        $formEditInformation->handleRequest($request);
        if ($formEditInformation->isSubmitted() && $formEditInformation->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('PROFILE');
        }

        $formEditPassword = $this->createForm(UserEditPasswordType::class, $user);
        $formEditPassword->handleRequest($request);
        if ($formEditPassword->isSubmitted() && $formEditPassword->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('PROFILE');
        }


        $originalFleets = new ArrayCollection();
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($user->getFleets() as $fleet) {
            $originalFleets->add($fleet);
        }
        $formEditFleets = $this->createForm(UserEditFleetsType::class, $user);
        $formEditFleets->handleRequest($request);
        if ($formEditFleets->isSubmitted() && $formEditFleets->isValid()) {
            /** @var User\Fleet $fleet */
            foreach ($originalFleets as $fleet) {
                if (false === $user->getFleets()->contains($fleet)) {
                    $user->removeFleet($fleet);
                    $this->em->persist($fleet);
                }
            }

            $this->em->persist($user);
            $this->em->flush();

            $userFleetsSorter->fusionFleets($user);

            return $this->redirectToRoute('PROFILE');
        }

        return $this->render('profile/index.html.twig', [
            'user'                => $user,
            'fleets'              => $user->getFleets(),
            'formEditInformation' => $formEditInformation->createView(),
            'formEditPassword'    => $formEditPassword->createView(),
            'formEditFleets'      => $formEditFleets->createView(),
        ]);
    }
}
