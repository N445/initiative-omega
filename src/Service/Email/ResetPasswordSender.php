<?php

namespace App\Service\Email;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class ResetPasswordSender extends BaseEmailSender
{
    public function send(User $user, ResetPasswordToken $resetToken)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@shadow-of-caliban.fr', 'Shadow Bot'))
            ->to($user->getEmail())
            ->subject('Votre demande de réinitialisation du mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $this->mailer->send($email);
    }
}
