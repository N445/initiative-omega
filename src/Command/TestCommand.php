<?php

namespace App\Command;

use App\Entity\User;
use App\Service\Email\RegistrationEmailSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:test',
    description: 'Command for test email sending',
)]
class TestCommand extends Command
{
    private RegistrationEmailSender $registrationEmailSender;

    public function __construct(RegistrationEmailSender $registrationEmailSender)
    {
        parent::__construct();
        $this->registrationEmailSender = $registrationEmailSender;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = (new User())
            ->setId(5454)
            ->setEmail('fdgdfgdfgdfg@free.fr')
        ;

        $this->registrationEmailSender->sendEmailConfirmation($user);

        return Command::SUCCESS;
    }
}
