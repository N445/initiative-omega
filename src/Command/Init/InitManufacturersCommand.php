<?php

namespace App\Command\Init;

use App\Service\Rsi\RsiManufacturerImporter;
use App\Service\Rsi\RsiShipImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init:manufacturer',
    description: 'Add a short description for your command',
)]
class InitManufacturersCommand extends Command
{
    private RsiShipImporter         $rsiShipImporter;

    private RsiManufacturerImporter $rsiManufacturerImporter;

    public function __construct(RsiManufacturerImporter $rsiManufacturerImporter)
    {
        parent::__construct();
        $this->rsiManufacturerImporter = $rsiManufacturerImporter;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nbImported = $this->rsiManufacturerImporter->importNewManufacturers();

        $io->success(sprintf('%d importé', $nbImported));

        return Command::SUCCESS;
    }


}
