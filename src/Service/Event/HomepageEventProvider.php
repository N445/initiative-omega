<?php

namespace App\Service\Event;

use App\Repository\Event\EventRepository;
use Symfony\Component\Security\Core\Security;

class HomepageEventProvider
{
    private EventRepository   $eventRepository;

    private Security          $security;

    private EventToFrontEvent $eventToFrontEvent;

    public function __construct(
        EventRepository   $eventRepository,
        Security          $security,
        EventToFrontEvent $eventToFrontEvent
    )
    {
        $this->eventRepository   = $eventRepository;
        $this->security          = $security;
        $this->eventToFrontEvent = $eventToFrontEvent;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        $events = $this->eventRepository->getEventsBetweenDates(
            new \DateTime('-30 days'),
            new \DateTime('+30 days'),
            20,
            null,
            $this->security->getUser()
        );

        $frontEvents = $this->eventToFrontEvent->toFrontEvents($events);

        return EventSortator::sort($frontEvents);
    }

    public function getEventsAlternative(): array
    {
        $events = $this->eventRepository->getEventsBetweenDates(
            new \DateTime('now'),
            new \DateTime('+30 days'),
            30,
            null,
            $this->security->getUser()
        );

        $frontEvents = $this->eventToFrontEvent->toFrontEvents($events);

        return array_slice($frontEvents, 0, 3);
    }
}
