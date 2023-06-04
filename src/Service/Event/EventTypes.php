<?php

namespace App\Service\Event;

class EventTypes
{
    public const TYPE_FREE                                       = "free";
    public const TYPE_DEATH_RACE                                 = "death_race";
    public const TYPE_COMMERCE_ESCORTE                           = "commerce_escorte";
    public const TYPE_INDUSTRIE_MINIERE                          = "industrie_miniere";
    public const TYPE_ECN_ALERTE_PRESENCE_GANG_ARLINGTON_STANTON = "ecn_alerte_presence_gang_arlington_stanton";
    public const TYPE_TRAINING                                   = "training";
    public const TYPE_JUMPTOWN                                   = "jumptown";
    public const TYPE_APPEL_FAMILLE_LING                         = "appel_famille_ling";
    public const TYPE_SOIREE_MINI_JEUX                           = "soiree_mini_jeux";
    public const TYPE_SERVICE_ASSITANCE                          = "service_assitance";
    public const TYPE_PILOTAGE_HORS_SC                           = "pilotage_hors_sc";
    public const TYPE_UNKOWN                                     = "unkown";
    public const TYPE_SOIREE_LUMINALIA                           = "soiree_luminalia";

    public static function getLabel(string $type): string
    {
        return [
                   self::TYPE_FREE                                       => 'Libre',
                   self::TYPE_DEATH_RACE                                 => 'Death Race',
                   self::TYPE_COMMERCE_ESCORTE                           => 'Commerce & Escorte de la Shadow of Caliban',
                   self::TYPE_INDUSTRIE_MINIERE                          => 'Industrie minière de la Shadow of Caliban',
                   self::TYPE_ECN_ALERTE_PRESENCE_GANG_ARLINGTON_STANTON => 'ECN Alerte présence du Gang Arlington sur Stanton',
                   self::TYPE_TRAINING                                   => 'Entrainement de la Shadow of Caliban',
                   self::TYPE_JUMPTOWN                                   => 'Jumptown 2.0',
                   self::TYPE_APPEL_FAMILLE_LING                         => 'Appel de la famille ling',
                   self::TYPE_SOIREE_MINI_JEUX                           => 'Soirée Mini Jeux en dehors de SC',
                   self::TYPE_SERVICE_ASSITANCE                          => 'Services d\'assistance de la Shadow of Caliban',
                   self::TYPE_PILOTAGE_HORS_SC                           => 'Soirée pilotage en dehors de SC',
                   self::TYPE_UNKOWN                                     => 'On fait quoi ce soir ?',
                   self::TYPE_SOIREE_LUMINALIA                           => 'La soirée Luminalia des Calibans',
               ][$type] ?? $type;
    }

    public static function getImage(?string $type)
    {
        return [
                   self::TYPE_DEATH_RACE                                 => 'death-race.webp',
                   self::TYPE_COMMERCE_ESCORTE                           => 'commerce_escorte.webp',
                   self::TYPE_INDUSTRIE_MINIERE                          => 'industrie_miniere.webp',
                   self::TYPE_ECN_ALERTE_PRESENCE_GANG_ARLINGTON_STANTON => 'ecn_alerte_presence_gang_arlington_stanton.webp',
                   self::TYPE_TRAINING                                   => 'training.webp',
                   self::TYPE_JUMPTOWN                                   => 'jumptown.webp',
                   //                   self::TYPE_SOIREE_MINI_JEUX                           => '',
                   self::TYPE_SERVICE_ASSITANCE                          => 'service_assitance.webp',
                   //                   self::TYPE_PILOTAGE_HORS_SC                           => '',
                   //                   self::TYPE_UNKOWN                                     => '',
                   //                   self::TYPE_SOIREE_LUMINALIA                           => '',
               ][$type] ?? 'default.webp';
    }
}
