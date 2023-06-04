<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create:admin',
    description: 'Add a short description for your command',
)]
class CreateAdminCommand extends Command
{
    private UserPasswordHasherInterface $userPasswordHasher;

    private EntityManagerInterface      $em;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface      $em
    )
    {
        parent::__construct();
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em                 = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var SymfonyQuestionHelper $helper */
        $helper = $this->getHelper('question');

        $question  = new Question('Identifiant : ', null);
        $email     = $helper->ask($input, $output, $question);
        $question  = new Question('Nom front : ', null);
        $frontName = $helper->ask($input, $output, $question);
        $question  = new Question('Mot de passe : ', null);
        $password  = $helper->ask($input, $output, $question);

        $user = (new User())
            ->setEmail($email)
            ->setFrontName($frontName)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerified(true)
            ->setRegisteredAt(new \DateTimeImmutable('NOW'))
        ;

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
