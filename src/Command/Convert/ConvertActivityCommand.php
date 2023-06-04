<?php

namespace App\Command\Convert;

use App\Repository\ActivityRepository;
use App\Service\ImageConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[AsCommand(
    name: 'app:convert:activity',
    description: 'Convertis les images des activités en webp',
)]
class ConvertActivityCommand extends Command
{
    private ActivityRepository     $activityRepository;

    private UploaderHelper $uploaderHelper;

    private KernelInterface        $kernel;

    private EntityManagerInterface $em;

    private ImageConverter         $imageConverter;

    public function __construct(
        ActivityRepository     $activityRepository,
        UploaderHelper         $uploaderHelper,
        KernelInterface        $kernel,
        EntityManagerInterface $em,
        ImageConverter         $imageConverter
    )
    {
        parent::__construct();
        $this->activityRepository = $activityRepository;
        $this->uploaderHelper     = $uploaderHelper;
        $this->kernel             = $kernel;
        $this->em                 = $em;
        $this->imageConverter     = $imageConverter;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $convertedImages = 0;
        foreach ($this->activityRepository->findAll() as $item) {
            $imagePath = $this->kernel->getProjectDir() . '/public' . $this->uploaderHelper->asset($item);

            if (!$newUploadedFile = $this->imageConverter->getWebpUploadedFile($imagePath, $imagePath)) {
                continue;
            }

            $item->setImageFile($newUploadedFile);
            $convertedImages++;
        }
        $this->em->flush();

        $io->success(sprintf('%d image convertis en webp', $convertedImages));

        return Command::SUCCESS;
    }
}
