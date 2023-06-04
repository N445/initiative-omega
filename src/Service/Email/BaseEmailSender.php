<?php

namespace App\Service\Email;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

abstract class BaseEmailSender
{
    public function __construct(
        protected VerifyEmailHelperInterface $verifyEmailHelper,
        protected MailerInterface $mailer,
        protected EntityManagerInterface $entityManager
    ) {
    }
}
