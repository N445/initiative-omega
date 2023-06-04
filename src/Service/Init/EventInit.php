<?php

namespace App\Service\Init;

use App\Entity\Event\Template;
use App\Entity\Event\Type;
use App\Service\Event\EventTemplateProvider;
use App\Service\Event\EventTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class EventInit
{
    private EntityManagerInterface $em;

    private KernelInterface        $kernel;

    public function __construct(
        EntityManagerInterface $em,
        KernelInterface        $kernel
    )
    {
        $this->em     = $em;
        $this->kernel = $kernel;
    }

    public function init()
    {
        foreach ($this->getTypes() as $codeType => $rawType) {
            $type            = (new Type())
                ->setCode($codeType)
                ->setName($rawType)
                ->setTitle(EventTemplateProvider::getTitle($codeType))
            ;
            $templateContent = EventTemplateProvider::getTemplate($codeType);
            if (!empty($templateContent)) {
                $type->setContent($templateContent);
            }

            $fileName = EventTypes::getImage($codeType);
            $filePath = __DIR__ . '/activites/' . $fileName;
            if (is_file($filePath)) {
                $filePathCopy =  __DIR__ . '/activites/copy-' . $fileName;
                copy($filePath, $filePathCopy);
                $type->setImageFile(new UploadedFile($filePathCopy, $fileName, null, null, true));
            }

            $this->em->persist($type);
        }
        $this->em->flush();
    }

    private function getTypes()
    {
        return [
            "free"                                       => 'Libre',
            "death_race"                                 => 'Death Race',
            "commerce_escorte"                           => 'Commerce & Escorte de la Shadow of Caliban',
            "industrie_miniere"                          => 'Industrie minière de la Shadow of Caliban',
            "ecn_alerte_presence_gang_arlington_stanton" => 'ECN Alerte présence du Gang Arlington sur Stanton',
            "training"                                   => 'Entrainement de la Shadow of Caliban',
            "jumptown"                                   => 'Jumptown 2.0',
            "appel_famille_ling"                         => 'Appel de la famille ling',
            "soiree_mini_jeux"                           => 'Soirée Mini Jeux en dehors de SC',
            "service_assitance"                          => 'Services d\'assistance de la Shadow of Caliban',
            "pilotage_hors_sc"                           => 'Soirée pilotage en dehors de SC',
            "unkown"                                     => 'On fait quoi ce soir ?',
            "soiree_luminalia"                           => 'La soirée Luminalia des Calibans',
        ];
    }
}
