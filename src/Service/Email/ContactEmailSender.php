<?php

namespace App\Service\Email;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

class ContactEmailSender extends BaseEmailSender
{
    public function send(Contact $contact)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@shadow-of-caliban.fr', 'Shadow Bot'))
            ->to(new Address('shadow.of.caliban.sc@gmail.com'), new Address('parisrob@hotmail.fr'))
            ->subject('Nouveau messsage de contact')
            ->htmlTemplate('mail/new-contact.html.twig')
            ->textTemplate('mail/new-contact.txt.twig')
            ->context([
                'contact' => $contact,
            ])
        ;

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
    }
}
