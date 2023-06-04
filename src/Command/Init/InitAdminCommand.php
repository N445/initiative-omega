<?php

namespace App\Command\Init;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:init:admin',
    description: 'Add a short description for your command',
)]
class InitAdminCommand extends Command
{
    private UserPasswordHasherInterface $userPasswordHasher;

    private EntityManagerInterface      $em;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em                 = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $admins = [
            'parisrob@hotmail.fr'         => 'Naas',
            'shadow-of-caliban@gmail.com' => 'Shadow of Caliban',
        ];
        foreach ($admins as $email => $frontName) {
            $user = (new User())
                ->setEmail($email)
                ->setFrontName($frontName)
                ->setRoles(['ROLE_ADMIN'])
                ->setIsVerified(true)
                ->setRegisteredAt(new \DateTimeImmutable('NOW'))
            ;

            $user->setPassword($this->userPasswordHasher->hashPassword($user, $email));

            $this->em->persist($user);
        }

        $this->em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }


}
