<?php

namespace App\MessageHandler;

use App\Message\ShipBannerDownloader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ShipBannerDownloaderHandler implements MessageHandlerInterface
{
    public function __invoke(ShipBannerDownloader $message)
    {
        $ship = $message->getShip();
        $tmpFile = $this->filesystem->tempnam(sys_get_temp_dir(), 'ship_');
        file_put_contents($tmpFile, file_get_contents($ship->getBannerImage()));
        $ship->setImageFile(new UploadedFile($tmpFile, basename($ship->getBannerImage()), null, null, true));
    }
}
