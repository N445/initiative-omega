<?php

namespace App\Command\Init;

use App\Service\Init\ActivityInit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:activity',
    description: 'Add a short description for your command',
)]
class InitActivityCommand extends Command
{
    private ActivityInit $activityInit;

    public function __construct(ActivityInit $activityInit)
    {
        parent::__construct();
        $this->activityInit = $activityInit;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->activityInit->init();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }


}
