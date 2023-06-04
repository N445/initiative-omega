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
use App\Service\GuildedApi\GuildedApiEventProvider;
use App\Service\SendContact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use RRule\RRule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', format: 'json')]
class ApiController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/events', name: 'API_EVENTS', methods: ['POST'])]
    public function apiEvents(Request $request, EventRepository $eventRepository)
    {
        $start = new DateTime($request->get('start'));
        $end   = new DateTime($request->get('end'));
        $qb    = $eventRepository->createQueryBuilder('e')
                                 ->addSelect('e')
                                 ->addSelect('d')
                                 ->leftJoin('e.dates', 'd')
        ;

        $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->between('d.start_at', ':start', ':end'),
                    $qb->expr()->between('e.start_at', ':start', ':end'),
                )
            )
            ->setParameter('start', $start)
            ->setParameter('end', $end)
        ;

        /** @var Event[] $data */
        $data = $qb->getQuery()->getResult();

        $events = [];
        foreach ($data as $datum) {
            $event = [
                'title'    => $datum->getTitle(),
                'url'      => $this->generateUrl('EVENT', ['id' => $datum->getId()]),
                'duration' => [
                    'hour'   => $datum->getDuration()->format('%h'),
                    'minute' => $datum->getDuration()->format('%i'),
                ],
            ];

            if ($datum->isHasRrule()) {
                $event['rrule'] = $datum->getRrule()->getRRuleObject()->rfcString();
            } else {
                $event['start'] = $datum->getStartAt()->format(DATE_ATOM);
            }

            $events[] = $event;
        }

        return $this->json($events);
    }


}
