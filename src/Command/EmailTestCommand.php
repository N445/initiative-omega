<?php

namespace App\Command;

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
    name: 'app:email:test',
    description: 'Command for test email sending',
)]
class EmailTestCommand extends Command
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io     = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $question = new Question('Sender : (contact@robin-parisot.fr)', 'contact@robin-parisot.fr');
        $sender   = $helper->ask($input, $output, $question);

//        $question  = new Question('Recipient : (test-vatmtg1o8@srv1.mail-tester.com)','test-vatmtg1o8@srv1.mail-tester.com');
        $question  = new Question('Recipient : (parisrob@hotmail.fr)','parisrob@hotmail.fr');
        $recipient = $helper->ask($input, $output, $question);

        $question = new Question('Subject : (Mon super sujet)','Mon super sujet');
        $subject  = $helper->ask($input, $output, $question);

        $question = new Question('Body : (Mon super body)','Mon super body');
        $body     = $helper->ask($input, $output, $question);

        $table = new Table($output);
        $table
            ->setHeaders(['Sender', 'Recipient', 'Subject', 'Body'])
            ->setRows([
                [$sender, $recipient, $subject, $body],
            ])
        ;
        $table->render();

        $email = (new Email())
            ->from($sender)
            ->to($recipient)
            ->subject($subject)
            ->text($body)
        ;

        try {
            $this->mailer->send($email);
            $io->success('Envoie de mail ok');
        } catch (TransportExceptionInterface $e) {
            $io->success($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
