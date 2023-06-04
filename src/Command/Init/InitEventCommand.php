<?php

namespace App\Command\Init;

use App\Service\Init\EventInit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:event',
    description: 'Add a short description for your command',
)]
class InitEventCommand extends Command
{
    private EventInit    $eventInit;

    public function __construct(EventInit $eventInit)
    {
        parent::__construct();
        $this->eventInit = $eventInit;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->eventInit->init();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }


}
