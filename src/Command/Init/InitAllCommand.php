<?php

namespace App\Command\Init;

use App\Service\Init\ActivityInit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:all',
    description: 'Add a short description for your command',
)]
class InitAllCommand extends Command
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



        $input = new ArrayInput([]);

        $io->info('Init admin');
        $command = $this->getApplication()->find('app:init:admin');
        $command->run($input, $output);

        $io->info('Init activity');
        $command = $this->getApplication()->find('app:init:activity');
        $command->run($input, $output);

        $io->info('Init roles');
        $command = $this->getApplication()->find('app:init:roles');
        $command->run($input, $output);

        $io->info('Init exploits tags');
        $command = $this->getApplication()->find('app:init:exploit:tags');
        $command->run($input, $output);

        $io->info('Init manufacturer');
        $command = $this->getApplication()->find('app:init:manufacturer');
        $command->run($input, $output);

        $io->info('Init ships');
        $command = $this->getApplication()->find('app:init:ships');
        $command->run($input, $output);

        $io->info('Init member xp dump first');
        $command = $this->getApplication()->find('app:members:xp-dump');
        $command->run($input, $output);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }


}
