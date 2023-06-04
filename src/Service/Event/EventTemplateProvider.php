<?php

namespace App\Service\Event;

class EventTemplateProvider
{
    public static function getTitle(string $type): string
    {
        return [
                   EventTypes::TYPE_FREE                                       => 'Libre',
                   EventTypes::TYPE_DEATH_RACE                                 => 'La Shadow of Caliban vous invite à une course sur Orison.',
                   EventTypes::TYPE_COMMERCE_ESCORTE                           => 'Commerce & Escorte de la Shadow of Caliban',
                   EventTypes::TYPE_INDUSTRIE_MINIERE                          => 'Industrie minière de la Shadow of Caliban',
                   EventTypes::TYPE_ECN_ALERTE_PRESENCE_GANG_ARLINGTON_STANTON => 'ECN Alerte présence du Gang Arlington sur Stanton',
                   EventTypes::TYPE_TRAINING                                   => 'Entrainement de la Shadow of Caliban',
                   EventTypes::TYPE_JUMPTOWN                                   => 'Jumptown 2.0',
                   EventTypes::TYPE_APPEL_FAMILLE_LING                         => 'Appel de la famille ling',
                   EventTypes::TYPE_SOIREE_MINI_JEUX                           => 'Soirée Mini Jeux en dehors de SC',
                   EventTypes::TYPE_SERVICE_ASSITANCE                          => 'Services d\'assistance de la Shadow of Caliban',
                   EventTypes::TYPE_PILOTAGE_HORS_SC                           => 'La Shadow of Caliban vous invitent à une soirée sous le signe du pilotage.',
                   EventTypes::TYPE_UNKOWN                                     => 'Soirée détente on s\'occupe comme on peut sur le verse. ',
                   EventTypes::TYPE_SOIREE_LUMINALIA                           => 'La soirée Luminalia des Calibans',
               ][$type] ?? $type;
    }

    public static function getTemplate(string $type): string
    {
        $filePath = __DIR__ . '/templates/' . $type . '.html';
        if (!file_exists($filePath)) {
            return '';
        }
        return file_get_contents($filePath);
    }
}
