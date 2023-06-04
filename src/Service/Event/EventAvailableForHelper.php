<?php

namespace App\Service\Event;

class EventAvailableForHelper
{
    public static function getChoices(): array
    {
        return [
            'Ouvert à tous'      => 'all',
            'Citizen'            => 'citizen',
            'Citoyen de Caliban' => 'citoyen-de-caliban',
            'Freelance'          => 'freelance',
        ];
    }

    public static function getLabels(?array $values = null): array
    {
        return array_values(array_flip(array_intersect(self::getChoices(), $values !== null ? $values : [])));
    }
}
