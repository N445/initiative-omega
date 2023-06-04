<?php

namespace App\Entity\User;

use App\Entity\User;
use App\Repository\User\ReferralRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferralRepository::class)]
class Referral
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id                   = null;

    #[ORM\Column(length: 255)]
    private ?string             $code                 = null;

    #[ORM\Column]
    private ?bool               $is_enabled           = null;

    #[ORM\Column]
    private ?bool               $is_actual_to_display = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $displayed_at         = null;

    #[ORM\OneToOne(mappedBy: 'referral')]
    private ?User               $user                 = null;

    public function __construct()
    {
        $this->is_enabled           = false;
        $this->is_actual_to_display = false;
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function isIsEnabled(): ?bool
    {
        return $this->is_enabled;
    }

    public function setIsEnabled(bool $is_enabled): self
    {
        $this->is_enabled = $is_enabled;

        return $this;
    }

    public function getIsActualToDisplay(): ?bool
    {
        return $this->is_actual_to_display;
    }

    public function setIsActualToDisplay(?bool $is_actual_to_display): Referral
    {
        $this->is_actual_to_display = $is_actual_to_display;
        return $this;
    }

    public function getDisplayedAt(): ?\DateTimeImmutable
    {
        return $this->displayed_at;
    }

    public function setDisplayedAt(\DateTimeImmutable $displayed_at): self
    {
        $this->displayed_at = $displayed_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setReferral(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getReferral() !== $this) {
            $user->setReferral($this);
        }

        $this->user = $user;

        return $this;
    }
}
