<?php

namespace App\Service\Rsi;

use App\Entity\Rsi\Ship\Ship;
use Carbon\CarbonInterval;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Cache\ItemInterface;

class RsiShipProvider extends BaseProvider
{
    private array $manufacturers = [];

    /**
     * @return Ship[]
     * @throws InvalidArgumentException
     */
    public function getShips(array $existingShips): array
    {
        $this->initManufacturers();
        $url = self::BASE_URL . "/ship-matrix/index";

        $response = $this->cache->get(self::PREFIX_CACHE . 'get-ships-v2', function (ItemInterface $item) use ($url) {
            $item->expiresAfter(3600);
            return $this->client->request('GET', $url);
        });

        $data = $response->toArray();

        if (!$data['success']) {
            return [];
        }
        $rawShips = $data['data'];

        $ships = [];
        foreach ($rawShips as $rawShip) {
            if (!$ship = $existingShips[$rawShip['id']] ?? null) {
                $ship = (new Ship())->setRsiId($rawShip['id']);
            }

            $ship->setName($rawShip['name'])
                 ->setType($rawShip['focus'])
                 ->setLink($rawShip['url'])
//                 ->setManufacturer($this->manufacturers[basename($rawShip['manufacturer']['media'][0]['source_url'])] ?? null)
            ;

            if (!$info = $ship->getInfo()) {
                $info = new Ship\Info();
                $ship->setInfo(new Ship\Info());
            }

            $info->setAfterburnerSpeed($rawShip['afterburner_speed'])
                 ->setBeam($rawShip['beam'])
                 ->setCargocapacity($rawShip['cargocapacity'])
                 ->setChassisId($rawShip['chassis_id'])
                 ->setHeight($rawShip['height'])
                 ->setLength($rawShip['length'])
                 ->setMass($rawShip['mass'])
                 ->setMaxCrew($rawShip['max_crew'])
                 ->setMinCrew($rawShip['min_crew'])
                 ->setPitchMax($rawShip['pitch_max'])
                 ->setProductionNote($rawShip['production_note'])
                 ->setProductionStatus($rawShip['production_status'])
                 ->setRollMax($rawShip['roll_max'])
                 ->setScmSpeed($rawShip['scm_speed'])
                 ->setSize($rawShip['size'])
                 ->setTimeModified(CarbonInterval::fromString($rawShip['time_modified']))
                 ->setType($rawShip['type'])
                 ->setXaxisAcceleration($rawShip['xaxis_acceleration'])
                 ->setYawMax($rawShip['yaw_max'])
                 ->setYaxisAcceleration($rawShip['yaxis_acceleration'])
                 ->setZaxisAcceleration($rawShip['zaxis_acceleration'])
                 ->setDescription($rawShip['description'])
                 ->setTimeModifiedDate(new \DateTime($rawShip['time_modified.unfiltered']))
            ;

            foreach ($info->getAvionic()->getComponents() as $component){
                $info->getAvionic()->removeComponent($component);
            }

            foreach ($info->getAvionic()->getComponents() as $component){
                $info->getPropulsion()->removeComponent($component);
            }

            foreach ($info->getAvionic()->getComponents() as $component){
                $info->getThruster()->removeComponent($component);
            }

            foreach ($info->getAvionic()->getComponents() as $component){
                $info->getModular()->removeComponent($component);
            }
            foreach ($info->getAvionic()->getComponents() as $component){
                $info->getWeapon()->removeComponent($component);
            }

            foreach ($rawShip['compiled']['RSIAvionic'] as $item) {
                foreach ($item as $componentRaw) {
                    $info->getAvionic()->addComponent($this->getComponent($componentRaw));
                }
            }

            foreach ($rawShip['compiled']['RSIPropulsion'] as $item) {
                foreach ($item as $componentRaw) {
                    $info->getPropulsion()->addComponent($this->getComponent($componentRaw));
                }
            }

            foreach ($rawShip['compiled']['RSIThruster'] as $item) {
                foreach ($item as $componentRaw) {
                    $info->getThruster()->addComponent($this->getComponent($componentRaw));
                }
            }

            foreach ($rawShip['compiled']['RSIModular'] as $item) {
                foreach ($item as $componentRaw) {
                    $info->getModular()->addComponent($this->getComponent($componentRaw));
                }
            }

            foreach ($rawShip['compiled']['RSIWeapon'] as $item) {
                foreach ($item as $componentRaw) {
                    $info->getWeapon()->addComponent($this->getComponent($componentRaw));
                }
            }

            $ship->setInfo($info);
            $sourceUrl = $rawShip['media'][0]['source_url'];

            if (false === strpos($sourceUrl, 'http')) {
                $sourceUrl = self::BASE_URL . $sourceUrl;
            }
            $ship->setBannerImage($sourceUrl);

            $ships[] = $ship;
        }

        return $ships;
    }

    private function getComponent(array $componentRaw): Ship\Component
    {
        return (new Ship\Component())
            ->setType($componentRaw['type'])
            ->setName($componentRaw['name'])
            ->setMounts($componentRaw['mounts'])
            ->setComponentSize($componentRaw['component_size'])
            ->setSize($componentRaw['size'])
            ->setDetails($componentRaw['details'])
            ->setQuantity($componentRaw['quantity'])
            ->setManufacturer($componentRaw['manufacturer'])
            ->setComponentClass($componentRaw['component_class'])
        ;
    }

    private function initManufacturers()
    {
        foreach ($this->manufacturerRepository->findAll() as $item) {
            $this->manufacturers[$item->getRsiImageName()] = $item;
        }
    }
}
