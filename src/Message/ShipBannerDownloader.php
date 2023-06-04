<?php

namespace App\Message;

use App\Entity\Rsi\Ship\Ship;

final class ShipBannerDownloader
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     private Ship $ship;

     public function __construct(Ship $ship)
     {
         $this->ship = $ship;
     }

    public function getShip(): Ship
    {
        return $this->ship;
    }
}
