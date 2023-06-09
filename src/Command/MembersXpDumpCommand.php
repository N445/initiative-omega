<?php

namespace App\Command;

use App\Service\GuildedApi\GuildedApiMemberProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:members:xp-dump',
    description: 'Add a short description for your command',
)]
class MembersXpDumpCommand extends Command
{
    private GuildedApiMemberProvider $guildedApiProfileProvider;

    public function __construct(
        GuildedApiMemberProvider $guildedApiProfileProvider
    )
    {
        parent::__construct();
        $this->guildedApiProfileProvider = $guildedApiProfileProvider;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->guildedApiProfileProvider->importMembersxp();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
