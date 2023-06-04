<?php

namespace App\Service;

use App\Entity\Contact;
use App\Service\Email\ContactEmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendContact
{
    public function __construct(
        private EntityManagerInterface $em,
        private ContactEmailSender $contactEmailSender
    )
    {
    }

    public function send(Contact $contact)
    {
        $this->em->persist($contact);
        $this->em->flush();
        $this->contactEmailSender->send($contact);
    }
}
