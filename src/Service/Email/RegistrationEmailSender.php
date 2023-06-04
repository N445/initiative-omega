<?php

namespace App\Service\Email;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationEmailSender extends BaseEmailSender
{
    public function sendEmailConfirmation(UserInterface $user): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'app_verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email =  (new TemplatedEmail())
            ->from(new Address('contact@shadow-of-caliban.fr', 'Shadow Bot'))
            ->to($user->getEmail())
            ->subject('Veuillez confirmer votre e-mail')
            ->htmlTemplate('registration/confirmation_email.html.twig')
        ;

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }
}
