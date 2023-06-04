<?php

namespace App\Command\Init;

use App\Service\Rsi\RsiShipImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:ships',
    description: 'Add a short description for your command',
)]
class InitShipsCommand extends Command
{
    private RsiShipImporter             $rsiShipImporter;

    public function __construct(RsiShipImporter $rsiShipImporter)
    {
        parent::__construct();
        $this->rsiShipImporter = $rsiShipImporter;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nbImported = $this->rsiShipImporter->importNewShips();

        $io->success(sprintf('%d importé', $nbImported));

        return Command::SUCCESS;
    }


}
