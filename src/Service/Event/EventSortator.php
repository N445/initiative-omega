<?php

namespace App\Service\Event;

use App\Interface\EventInterface;
use DateTimeImmutable;

class EventSortator
{
    public const KEY_PAST    = 'past';
    public const KEY_CURRENT = 'current';
    public const KEY_FUTUR   = 'futur';

    public const MAX_PAST_EVENTS = 6;

    /**
     * @param EventInterface[]       $events
     * @param DateTimeImmutable|null $now
     * @return array
     */
    public static function sort(
        array              $events,
        ?DateTimeImmutable $now = null,
        ?int               $limitPast = 3,
        ?int               $limitNow = 6,
        ?int               $limitFutur = 6
    ): array
    {
        // sort events by past current and futur
        $pastEvents    = [];
        $currentEvents = [];
        $futurEvents   = [];

        if (!$now) {
            $now = new DateTimeImmutable('NOW');
        }

        foreach ($events as $event) {
            if (EventHelper::isNow($event, $now)) {
                $currentEvents[] = $event;
                continue;
            }
            if (EventHelper::isPast($event, $now)) {
                $pastEvents[] = $event;
                continue;
            }
            $futurEvents[] = $event;
        }

        $pastEvents    = array_slice($pastEvents, -$limitPast);
        $currentEvents = array_slice($currentEvents, -$limitNow);
        $futurEvents   = array_slice($futurEvents, -$limitFutur);

        return [
            self::KEY_PAST    => $pastEvents,
            self::KEY_CURRENT => $currentEvents,
            self::KEY_FUTUR   => $futurEvents,
        ];
    }
}
