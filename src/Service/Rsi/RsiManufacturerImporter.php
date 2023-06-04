<?php

namespace App\Service\Rsi;

use App\Entity\Rsi\Ship\Manufacturer;

class RsiManufacturerImporter extends BaseImporter
{
    public function importNewManufacturers()
    {
        $existingIds = array_map(fn(Manufacturer $manufacturer) => $manufacturer->getRsiId(), $this->manufacturerRepository->findAll());

        /** @var Manufacturer[] $manufacturers */
        $manufacturers =  $this->rsiManufacturerProvider->getManufacturers();

        $addedManufacturer = 0;
        foreach ($manufacturers as $manufacturer) {
            if (!in_array($manufacturer->getRsiId(), $existingIds)) {
                $this->em->persist($manufacturer);
                $addedManufacturer++;
            }
        }
        $this->em->flush();
        return $addedManufacturer;
    }
}
