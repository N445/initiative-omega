<?php

namespace App\Command;

use App\Service\Rsi\RsiShipImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:ship',
    description: 'Add a short description for your command',
)]
class ImportShipCommand extends Command
{
    private RsiShipImporter $rsiShipImporter;

    public function __construct(RsiShipImporter $rsiShipImporter)
    {
        parent::__construct();
        $this->rsiShipImporter = $rsiShipImporter;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $addedShips = $this->rsiShipImporter->importNewShips();

        $io->success(sprintf('%d ship importé',$addedShips));

        return Command::SUCCESS;
    }
}
