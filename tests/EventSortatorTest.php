<?php

namespace App\Tests;

use App\Model\Guilded\Event;
use App\Service\Event\EventSortator;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class EventSortatorTest extends TestCase
{
    public function testEventSortator(): void
    {
        $now = new DateTimeImmutable('NOW');

        $sortedEvents = EventSortator::sort($this->getEvents(), $now);

        $this->assertSame(6, count($sortedEvents[EventSortator::KEY_PAST]));
        $this->assertSame(3, count($sortedEvents[EventSortator::KEY_CURRENT]));
        $this->assertSame(2, count($sortedEvents[EventSortator::KEY_FUTUR]));
    }

    private function getEvents()
    {
        $past1 = (new DateTime('NOW'))->sub(new DateInterval('P5D'));
        $past2 = (new DateTime('NOW'))->sub(new DateInterval('P3D'));

        $now1 = (new DateTime('NOW'))->sub(new DateInterval('P5D'));
        $now2 = (new DateTime('NOW'))->add(new DateInterval('P3D'));

        $futur1 = (new DateTime('NOW'))->add(new DateInterval('P3D'));
        $futur2 = (new DateTime('NOW'))->add(new DateInterval('P5D'));

        return [
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),
            (new Event())->setHappensAt($past1)->setEndAt($past2),

            (new Event())->setHappensAt($now1)->setEndAt($now2),
            (new Event())->setHappensAt($now1)->setEndAt($now2),
            (new Event())->setHappensAt($now1)->setEndAt($now2),

            (new Event())->setHappensAt($futur1)->setEndAt($futur2),
            (new Event())->setHappensAt($futur1)->setEndAt($futur2),
        ];
    }
}
