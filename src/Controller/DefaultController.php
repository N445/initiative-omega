<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Event\Event;
use App\Entity\Form;
use App\Form\ContactType;
use App\Provider\FakeEventProvider;
use App\Repository\ActivityRepository;
use App\Repository\Event\EventRepository;
use App\Repository\Exploit\ExploitRepository;
use App\Repository\Exploit\TagRepository;
use App\Repository\FormRepository;
use App\Repository\RoleRepository;
use App\Repository\Rsi\Ship\ManufacturerRepository;
use App\Repository\Rsi\Ship\ShipRepository;
use App\Repository\User\ReferralRepository;
use App\Security\Voter\EventVoter;
use App\Service\Email\ContactEmailSender;
use App\Service\Event\EventHelper;
use App\Service\Event\EventToFrontEvent;
use App\Service\Event\HomepageEventProvider;
use App\Service\GuildedApi\GuildedApiEventProvider;
use App\Service\Rsi\RsiShipImporter;
use App\Service\Rsi\RsiShipProvider;
use App\Service\SendContact;
use App\Service\User\ReferralProgram;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use RRule\RRule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'HOMEPAGE')]
    public function index(
        Request                 $request,
        SendContact             $sendContact,
        GuildedApiEventProvider $guildedApiEventProvider,
        ActivityRepository      $activityRepository,
        RoleRepository          $roleRepository,
        ExploitRepository       $exploitRepository,
        HomepageEventProvider   $homepageEventProvider,
        ReferralProgram         $referralProgram
    ): Response
    {
        $events = $homepageEventProvider->getEvents();

        $contact = new Contact();
        $form    = $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('AJAX_CONTACT_FORM_SUBMIT'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $sendContact->send($contact);
                $this->addFlash('success', 'Nous avons bien reçu votre message.');
                return $this->redirectToRoute('HOMEPAGE');
            } else {
                $this->addFlash('error', 'Formulaire de contact, non valide.');
            }

        }

        $referral = $referralProgram->getActualReferral();

        return $this->render('default/index.html.twig', [
            'form'               => $form->createView(),
            'exploits'           => $exploitRepository->getLastExploit(20),
            'activites'          => $activityRepository->getActivityHomepage(),
            //            'roles'              => $roleRepository->getActivityHomepage(),
            'events_alternative' => $homepageEventProvider->getEventsAlternative(),
            'events'             => $events,
            'referral'           => $referral,
        ]);
    }

    #[Route('/contact-form-submit', name: 'AJAX_CONTACT_FORM_SUBMIT', options: ['expose' => true], methods: ['GET', 'POST'], format: 'json')]
    public function contactFormSubmit(Request $request, SendContact $sendContact)
    {
        $contact = new Contact();
        $form    = $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('AJAX_CONTACT_FORM_SUBMIT'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $sendContact->send($contact);

                $contact = new Contact();
                $form    = $this->createForm(ContactType::class, $contact, [
                    'action' => $this->generateUrl('AJAX_CONTACT_FORM_SUBMIT'),
                ]);

                return $this->json([
                    'success' => true,
                    'html'    => $this->renderView('include/homepage/_contact_form-success.html.twig', [
                        'form' => $form->createView(),
                    ]),
                    //                    'noty'    => [
                    //                        'type' => 'success',
                    //                        'text' => 'Nous avons bien reçu votre message.',
                    //                    ],
                ]);
            }

            return $this->json([
                'success' => false,
                'html'    => $this->renderView('include/homepage/_contact_form.html.twig', [
                    'form' => $form->createView(),
                ]),
                //                'noty'    => [
                //                    'type' => 'error',
                //                    'text' => 'Formulaire de contact non valide.',
                //                ],
            ]);
        }

        return $this->json([
            'success' => true,
            'html'    => $this->renderView('include/homepage/_contact_form.html.twig', [
                'form' => $form->createView(),
            ]),
        ]);
    }


    #[Route('/exploits', name: 'EXPLOITS', methods: ['GET'])]
    public function exploits(
        ExploitRepository      $exploitRepository,
        ShipRepository         $shipRepository,
        ManufacturerRepository $manufacturerRepository,
        TagRepository          $tagRepository
    )
    {
        return $this->render('default/exploits.html.twig', [
            'exploits' => $exploitRepository->getLastExploit(),
            'filters'  => [
                'ships'         => $shipRepository->getShipsWithExploits(),
                'manufacturers' => $manufacturerRepository->getManufacturersWithExploits(),
                'tags'          => $tagRepository->getTagsWithExploits(),
            ],
        ]);
    }

    #[Route('/mentions-legales', name: 'MENTIONS_LEGALES', methods: ['GET'])]
    public function mentionsLegales(Request $request)
    {
        return $this->render('default/mentions-legales.html.twig', []);
    }

    #[Route('/politique-confidentialite', name: 'POLITIQUE_CONFIDENTIALITE', methods: ['GET'])]
    public function politiqueConfidentialite(Request $request)
    {
        return $this->render('default/politique-confidentialite.html.twig', []);
    }

    #[Route('/6331f1c78e4f54.47408393', name: 'DEBUG_ROUTE', methods: ['POST'])]
    public function debugRoute(Request $request)
    {
        return $this->render('default/debug-route.html.twig', []);
    }


    #[Route('/event/{id}', name: 'EVENT', methods: ['GET'])]
    public function event(int $id, Request $request, EventRepository $eventRepository, EventToFrontEvent $eventToFrontEvent)
    {
        if (!$event = $eventRepository->getById($id)) {
            return $this->redirectToRoute('HOMEPAGE');
        }

        $this->denyAccessUnlessGranted(EventVoter::VIEW, $event);

        if ($reccurenceDate = $request->get('date')) {
            $reccurenceDate = new \DateTime($reccurenceDate);
        } else {
            $reccurenceDate = $event->getStartAt();
        }

        $futurEvents = $eventRepository->getEventsAfterDate(null, 6, $this->getUser());
        $frontEvents = $eventToFrontEvent->toFrontEvents($futurEvents);

        return $this->render('default/event.html.twig', [
            'event'          => $event,
            'reccurenceDate' => $reccurenceDate,
            'futurEvents'    => $frontEvents,
        ]);
    }


    #[Route('/test2', name: 'TEST2', methods: ['GET'])]
    public function test(RsiShipImporter $rsiShipImporter)
    {
        dump($rsiShipImporter->importNewShips());
        die;
        return $this->render('default/test.html.twig', []);
    }
}
