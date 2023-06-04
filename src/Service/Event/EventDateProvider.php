<?php

namespace App\Service\Event;

use App\Entity\Event\Event;
use DateInterval;
use DateTime;
use DateTimeInterface;

class EventDateProvider
{
    public static function isFinished(Event $event, ?DateTime $date = null): bool
    {
        if (!self::getNextDateEnd($event, $date)) {
            return true;
        }
        return self::getNextDateEnd($event, $date) < new DateTime('NOW');
    }

    public static function getNextDateRendezVous(Event $event, ?DateTime $date = null): DateTimeInterface
    {
        return (clone self::getNextDateStart($event, $date))->sub(new DateInterval('PT15M'));
    }

    public static function getNextDateStart(Event $event, ?DateTime $date = null): DateTimeInterface
    {
        if (!$event->isHasRrule()) {
            return $event->getStartAt();
        }
        if (null === $date) {
            $date = new DateTime('NOW');
        }
        return $event->getRrule()->getRRuleObject()->getOccurrencesAfter($date, true, 1)[0];
//        return $event->getRrule()->getRRuleObject()->getNthOccurrenceAfter($date, 1);
    }

    public static function getNextDateEnd(Event $event, ?DateTime $date = null): DateTimeInterface
    {
        return (clone self::getNextDateStart($event, $date))?->add($event->getDuration());
    }


}
