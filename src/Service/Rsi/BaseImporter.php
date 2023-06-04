<?php

namespace App\Service\Rsi;

use App\Repository\Rsi\Ship\ManufacturerRepository;
use App\Repository\Rsi\Ship\ShipRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseImporter
{
    const PREFIX_CACHE = 4;

    protected ShipRepository          $shipRepository;

    protected ManufacturerRepository  $manufacturerRepository;

    protected EntityManagerInterface  $em;

    protected RsiShipProvider         $rsiShipProvider;

    protected RsiManufacturerProvider $rsiManufacturerProvider;


    public function __construct(
        ShipRepository          $shipRepository,
        ManufacturerRepository  $manufacturerRepository,
        EntityManagerInterface  $em,
        RsiShipProvider         $rsiShipProvider,
        RsiManufacturerProvider $rsiManufacturerProvider
    )
    {
        $this->shipRepository          = $shipRepository;
        $this->manufacturerRepository  = $manufacturerRepository;
        $this->em                      = $em;
        $this->rsiShipProvider         = $rsiShipProvider;
        $this->rsiManufacturerProvider = $rsiManufacturerProvider;
    }
}
