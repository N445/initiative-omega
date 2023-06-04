<?php

namespace App\Service\Rsi;

use App\Entity\Rsi\Ship\Manufacturer;
use App\Entity\Rsi\Ship\Ship;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RsiManufacturerProvider extends BaseProvider
{
    /**
     * @return array
     */
    public function getManufacturers()
    {
        $crawler    = new Crawler(file_get_contents(self::BASE_URL . "/pledge/ships"), self::BASE_URL);
        return $crawler->filter('form#search-filters .manufacturer label.checkbox')->each(function (Crawler $node, $i) {
            $id       = (int)$node->filter('input')->attr('value');
            $imageUrl = $node->filter('img')->image()->getUri();
            $name     = $node->filter('.text')->text();

            $manufacturer = (new Manufacturer())
                ->setRsiId($id)
                ->setName($name)
                ->setRsiImageName(basename($imageUrl))
            ;
            $tmpFile      = $this->filesystem->tempnam(sys_get_temp_dir(), 'manufacturer_');
            file_put_contents($tmpFile, file_get_contents($imageUrl));
            $manufacturer->setImageFile(new UploadedFile($tmpFile, $manufacturer->getRsiImageName(), null, null, true));

            return $manufacturer;
        });
    }
}
