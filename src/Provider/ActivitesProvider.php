<?php

namespace App\Provider;

use App\Model\Activite;

class ActivitesProvider
{
    public static function getActivites()
    {
        return [
            new Activite('Exploration', 'exploration.jpg', 'lorem'),
            new Activite('Contrebande', 'contrebande.jpg', 'lorem'),
            new Activite('Protection', 'protection.jpg', 'lorem'),
            new Activite('Entretien', 'entretien.jpeg', 'lorem'),
            new Activite('Évenement', 'event.jpg', 'lorem'),
        ];
    }
}
