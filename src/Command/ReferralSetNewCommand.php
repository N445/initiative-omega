<?php

namespace App\Command;

use App\Service\User\ReferralProgram;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:referral:set-new',
    description: 'Set un nouveau code referral actif',
)]
class ReferralSetNewCommand extends Command
{
    private ReferralProgram $referralProgram;

    public function __construct(
        ReferralProgram $referralProgram
    )
    {
        parent::__construct();
        $this->referralProgram = $referralProgram;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->referralProgram->setNewReferral();

        $io->success('Nouveau code referral défini');

        return Command::SUCCESS;
    }
}
