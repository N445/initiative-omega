<?php

namespace App\Command\Init;

use App\Service\Init\RoleInit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:roles',
    description: 'Add a short description for your command',
)]
class InitRolesCommand extends Command
{
    private RoleInit               $roleInit;

    public function __construct(RoleInit $roleInit)
    {
        parent::__construct();
        $this->roleInit = $roleInit;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->roleInit->init();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}








