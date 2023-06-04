<?php

namespace App\EventSubscriber;

use App\Entity\Activity;
use App\Entity\Exploit\Exploit;
use App\Service\ImageConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

class VichSubscriber implements EventSubscriberInterface
{
    private ImageConverter $imageConverter;

    public function __construct(ImageConverter $imageConverter)
    {
        $this->imageConverter = $imageConverter;
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        $object  = $event->getObject();
        $mapping = $event->getMapping();

        if ($object instanceof Exploit) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $object->getImageFile();
            if ($newUploadedFile = $this->imageConverter->getWebpUploadedFile($uploadedFile->getPathname(), $uploadedFile->getClientOriginalName())) {
                $object->setImageFile($newUploadedFile);
            }
        }
        if ($object instanceof Activity) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $object->getImageFile();
            if ($newUploadedFile = $this->imageConverter->getWebpUploadedFile($uploadedFile->getPathname(), $uploadedFile->getClientOriginalName())) {
                $object->setImageFile($newUploadedFile);
            }
        }
        if ($object instanceof \App\Entity\Event\Event) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $object->getImageFile();
            if ($newUploadedFile = $this->imageConverter->getWebpUploadedFile($uploadedFile->getPathname(), $uploadedFile->getClientOriginalName())) {
                $object->setImageFile($newUploadedFile);
            }
        }


        // do your stuff with $object and/or $mapping...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::PRE_UPLOAD => 'onVichUploaderPreUpload',
        ];
    }
}
