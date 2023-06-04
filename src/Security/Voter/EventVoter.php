<?php

namespace App\Security\Voter;

use App\Entity\Event\Event;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW])
            && $subject instanceof \App\Entity\Event\Event;
    }

    /**
     * @param string         $attribute
     * @param Event          $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::VIEW => $this->canView($subject, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Event $subject, ?UserInterface $user)
    {
        if (!$subject->isIsPrivate()) {
            return true;
        }
        if ($user instanceof UserInterface) {
            return true;
        }
        return false;
    }
}
