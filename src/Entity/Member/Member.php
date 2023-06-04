<?php

namespace App\Entity\Member;

use App\Entity\User;
use App\Repository\Member\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table('guilded_member')]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id         = null;

    #[ORM\Column(length: 10)]
    private ?string             $guildedId  = null;

    #[ORM\Column(length: 255)]
    private ?string             $name       = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $joinDate   = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastOnline = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Xp::class, cascade: ['persist', 'remove'])]
    private Collection          $xpData;

    #[ORM\OneToOne(mappedBy: 'guildedAccount', cascade: ['persist', 'remove'])]
    private ?User               $user       = null;

    #[ORM\Column]
    private ?bool $isDisplayOnDashboard = false;

    public function __construct()
    {
        $this->xpData = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuildedId(): ?string
    {
        return $this->guildedId;
    }

    public function setGuildedId(string $guildedId): self
    {
        $this->guildedId = $guildedId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getJoinDate(): ?\DateTimeImmutable
    {
        return $this->joinDate;
    }

    public function setJoinDate(\DateTimeImmutable $joinDate): self
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getLastOnline(): ?\DateTimeImmutable
    {
        return $this->lastOnline;
    }

    public function setLastOnline(\DateTimeImmutable $lastOnline): self
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    public function getLastOnlineDuration(): int
    {
        return (new \DateTime('NOW'))->diff($this->lastOnline)->format('%d');
    }

    /**
     * @return Collection<int, Xp>
     */
    public function getXpData(): Collection
    {
        return $this->xpData;
    }

    public function addXpData(Xp $xpData): self
    {
        if (!$this->xpData->contains($xpData)) {
            $this->xpData->add($xpData);
            $xpData->setMember($this);
        }

        return $this;
    }

    public function removeXpData(Xp $xpData): self
    {
        if ($this->xpData->removeElement($xpData)) {
            // set the owning side to null (unless already changed)
            if ($xpData->getMember() === $this) {
                $xpData->setMember(null);
            }
        }

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
            $this->user->setGuildedAccount(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getGuildedAccount() !== $this) {
            $user->setGuildedAccount($this);
        }

        $this->user = $user;

        return $this;
    }

    public function isIsDisplayOnDashboard(): ?bool
    {
        return $this->isDisplayOnDashboard;
    }

    public function setIsDisplayOnDashboard(bool $isDisplayOnDashboard): self
    {
        $this->isDisplayOnDashboard = $isDisplayOnDashboard;

        return $this;
    }
}
