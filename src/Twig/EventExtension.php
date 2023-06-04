<?php

namespace App\Twig;


use App\Service\Event\EventDateProvider;
use App\Service\Event\EventHelper;
use Carbon\CarbonInterval;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EventExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('isNow', [EventHelper::class, 'isNow']),
            new TwigFilter('isPast', [EventHelper::class, 'isPast']),
            new TwigFilter('isFutur', [EventHelper::class, 'isFutur']),
            new TwigFilter('isFinished', [EventDateProvider::class, 'isFinished']),
            new TwigFilter('nextDateRendezVous', [EventDateProvider::class, 'getNextDateRendezVous']),
            new TwigFilter('nextDateStart', [EventDateProvider::class, 'getNextDateStart']),
            new TwigFilter('nextDateEnd', [EventDateProvider::class, 'getNextDateEnd']),
            new TwigFilter('getDurationFormat', [$this, 'getDurationFormat']),
        ];
    }

    public function getDurationFormat(\DateInterval $interval)
    {
        return (new CarbonInterval($interval))->locale('fr_FR')->forHumans();
    }
}
