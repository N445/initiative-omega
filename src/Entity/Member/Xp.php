<?php

namespace App\Entity\Member;

use App\Repository\Member\XpRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XpRepository::class)]
#[ORM\Table('guilded_member_xp')]
class Xp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id     = null;

    #[ORM\Column]
    private ?int                $value  = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date   = null;

    #[ORM\ManyToOne(inversedBy: 'xpData')]
    private ?Member             $member = null;

    public function __construct(?int $xp = null)
    {
        $this->value = $xp;
        $this->date  = new \DateTimeImmutable('NOW');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
