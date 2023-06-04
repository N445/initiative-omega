<?php

namespace App\Tests;

use App\Model\Guilded\Event;
use App\Service\Event\EventHelper;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class EventHelperTest extends TestCase
{
    public function testIsPast(): void
    {
        $isPast = EventHelper::isPast($this->getPastEvent());
        $this->assertEquals(true, $isPast);

        $isPast = EventHelper::isPast($this->getNowEvent());
        $this->assertEquals(false, $isPast);

        $isPast = EventHelper::isPast($this->getFuturEvent());
        $this->assertEquals(false, $isPast);
    }

    public function testIsNow(): void
    {
        $isNow = EventHelper::isNow($this->getPastEvent());
        $this->assertEquals(false, $isNow);

        $isNow = EventHelper::isNow($this->getNowEvent());
        $this->assertEquals(true, $isNow);

        $isNow = EventHelper::isNow($this->getFuturEvent());
        $this->assertEquals(false, $isNow);
    }

    public function testIsFutur(): void
    {
        $isFutur = EventHelper::isFutur($this->getPastEvent());
        $this->assertEquals(false, $isFutur);

        $isFutur = EventHelper::isFutur($this->getNowEvent());
        $this->assertEquals(false, $isFutur);

        $isFutur = EventHelper::isFutur($this->getFuturEvent());
        $this->assertEquals(true, $isFutur);
    }

    private function getPastEvent(): Event
    {
        return (new Event())
            ->setHappensAt((new DateTime('NOW'))->sub(new DateInterval('P2D')))
            ->setEndAt((new DateTime('NOW'))->sub(new DateInterval('P1D')))
        ;
    }
    private function getNowEvent(): Event
    {
        return (new Event())
            ->setHappensAt((new DateTime('NOW'))->sub(new DateInterval('P1D')))
            ->setEndAt((new DateTime('NOW'))->add(new DateInterval('P1D')))
        ;
    }
    private function getFuturEvent(): Event
    {
        return (new Event())
            ->setHappensAt((new DateTime('NOW'))->add(new DateInterval('P1D')))
            ->setEndAt((new DateTime('NOW'))->add(new DateInterval('P2D')))
        ;
    }
}
