<?php

namespace App\Service\Event;

use App\Interface\EventInterface;

class EventHelper
{
    /**
     * @param EventInterface          $event
     * @param \DateTimeImmutable|null $now
     * @return bool
     */
    public static function isNow(EventInterface $event, ?\DateTimeImmutable $now = null): bool
    {
        if (!$now) {
            $now = new \DateTimeImmutable('NOW');
        }
        return ($event->getStartedAt() < $now) && ($event->getEndAt() > $now);
    }

    /**
     * @param EventInterface          $event
     * @param \DateTimeImmutable|null $now
     * @return bool
     */
    public static function isPast(EventInterface $event, ?\DateTimeImmutable $now = null): bool
    {
        if (!$now) {
            $now = new \DateTimeImmutable('NOW');
        }
        return $event->getEndAt() < $now;
    }

    /**
     * @param EventInterface          $event
     * @param \DateTimeImmutable|null $now
     * @return bool
     */
    public static function isFutur(EventInterface $event, ?\DateTimeImmutable $now = null): bool
    {
        if (!$now) {
            $now = new \DateTimeImmutable('NOW');
        }
        return $event->getStartedAt() > $now;
    }
}
