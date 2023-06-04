<?php

namespace App\Provider;

use App\Model\Guilded\Event;
use Faker\Factory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class FakeEventProvider
{
    public static function getFakeEvents(int $limit = 10)
    {
        $cache  = new FilesystemAdapter();
        $events = $cache->get('fake-event' . $limit, function (ItemInterface $item) use ($limit) {
            $item->expiresAfter(3600);
            $factory = Factory::create('fr_FR');
            $events  = [];
            foreach (range(1, $limit) as $item) {
                $startAt  = $factory->dateTimeBetween('-10 days', '+ 10days');
                $endAt    = clone $startAt->add(new \DateInterval(sprintf('P%dD', range(1, 5))));
                $events[] = (new Event())
                    ->setId($item)
                    ->setName($factory->realText(20))
                    ->setHappensAt($startAt)
                    ->setEndAt($endAt)
                ;
            }
            return $events;
        });
        usort($events, function (Event $a, Event $b) {
            return $a->getHappensAt() > $b->getHappensAt();
        });
        return $events;
    }
}
