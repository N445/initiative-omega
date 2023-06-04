<?php

namespace App\Command;

use App\Repository\Event\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:check:event:finished',
    description: 'Add a short description for your command',
)]
class CheckEventFinishedCommand extends Command
{
    private EventRepository        $eventRepository;

    private EntityManagerInterface $em;

    public function __construct(
        EventRepository        $eventRepository,
        EntityManagerInterface $em
    )
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
        $this->em              = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $events     = $this->eventRepository->getFinishedEvents();
        $nbFinished = 0;
        foreach ($events as $event) {
            $event->setIsFinished(true);
            $nbFinished++;
        }
        $this->em->flush();
        $io->success(sprintf('%d events modifié', $nbFinished));

        return Command::SUCCESS;
    }
}
