<?php

namespace App\Service\Init;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ActivityInit
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        foreach ($this->getData() as $datum) {
            $this->em->persist($datum);
        }
        $this->em->flush();
    }

    /**
     * @return Activity[]
     */
    private function getData(): array
    {
        $basedir    = __DIR__ . '/activites/';
        $fileSystem = new Filesystem();
        $fileSystem->copy($basedir . 'exploration.jpg', $basedir . 'exploration-copy.jpg');
        $fileSystem->copy($basedir . 'contrebande.jpg', $basedir . 'contrebande-copy.jpg');
        $fileSystem->copy($basedir . 'protection.jpg', $basedir . 'protection-copy.jpg');
        $fileSystem->copy($basedir . 'entretien.jpeg', $basedir . 'entretien-copy.jpeg');
        $fileSystem->copy($basedir . 'event.jpg', $basedir . 'event-copy.jpg');
        return [
            (new Activity())->setTitle('Exploration')->setDisplayOrder(10)->setImageFile(new UploadedFile($basedir . 'exploration-copy.jpg', 'exploration.jpg', null, null, true)),
            (new Activity())->setTitle('Contrebande')->setDisplayOrder(20)->setImageFile(new UploadedFile($basedir . 'contrebande-copy.jpg', 'contrebande.jpg', null, null, true)),
            (new Activity())->setTitle('Protection')->setDisplayOrder(30)->setImageFile(new UploadedFile($basedir . 'protection-copy.jpg', 'protection.jpg', null, null, true)),
            (new Activity())->setTitle('Entretien')->setDisplayOrder(40)->setImageFile(new UploadedFile($basedir . 'entretien-copy.jpeg', 'entretien.jpeg', null, null, true)),
            (new Activity())->setTitle('Évenement')->setDisplayOrder(50)->setImageFile(new UploadedFile($basedir . 'event-copy.jpg', 'event.jpg', null, null, true)),
        ];
    }
}
