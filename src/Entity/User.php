<?php

namespace App\Entity;

use App\Entity\Event\Event;
use App\Entity\Member\Member;
use App\Entity\User\Fleet;
use App\Entity\User\Info;
use App\Entity\User\Referral;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette adresse e-mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int    $id    = null;

    #[ORM\Column(length: 80, unique: true)]
    #[Assert\Email(
        message: 'L\'email {{ valeur }}} n\'est pas un email valide.',
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array   $roles = [];

    /**
     * @var string|null
     */
    #[ORM\Column]
    #[AppAssert\Password]
    private ?string             $password       = null;

    #[ORM\Column(type: 'boolean')]
    private                     $isVerified     = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $registered_at  = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastlogin_at   = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Info               $info           = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Member             $guildedAccount = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Fleet::class, cascade: ['persist', 'remove'])]
    private Collection          $fleets;

    #[ORM\OneToMany(mappedBy: 'created_by', targetEntity: Event::class)]
    private Collection          $events;

    #[ORM\Column(length: 255)]
    private ?string             $frontName      = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string             $signature      = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Referral           $referral       = null;

    public function __construct()
    {
        $this->info   = new Info();
        $this->fleets = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registered_at;
    }

    public function setRegisteredAt(\DateTimeImmutable $registered_at): self
    {
        $this->registered_at = $registered_at;

        return $this;
    }

    public function getLastloginAt(): ?\DateTimeImmutable
    {
        return $this->lastlogin_at;
    }

    public function setLastloginAt(?\DateTimeImmutable $lastlogin_at): self
    {
        $this->lastlogin_at = $lastlogin_at;

        return $this;
    }

    public function getInfo(): ?Info
    {
        return $this->info;
    }

    public function setInfo(Info $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getGuildedAccount(): ?Member
    {
        return $this->guildedAccount;
    }

    public function setGuildedAccount(?Member $guildedAccount): self
    {
        $this->guildedAccount = $guildedAccount;

        return $this;
    }

    /**
     * @param ArrayCollection $fleets
     * @return $this
     */
    public function setFleets(ArrayCollection $fleets): self
    {
        $this->fleets = $fleets;
        return $this;
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getFleets(): Collection
    {
        $iterator = $this->fleets->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getShip()->getName() < $b->getShip()->getName()) ? -1 : 1;
        });
        return new ArrayCollection(iterator_to_array($iterator));

//        return $this->fleets;
    }

    public function addFleet(Fleet $fleet): self
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets->add($fleet);
            $fleet->setUser($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): self
    {
        if ($this->fleets->removeElement($fleet)) {
            // set the owning side to null (unless already changed)
            if ($fleet->getUser() === $this) {
                $fleet->setUser(null);
            }
        }

        return $this;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $this->isVerified() === $user->isVerified();
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setCreatedBy($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCreatedBy() === $this) {
                $event->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getFrontName(): ?string
    {
        return $this->frontName;
    }

    public function setFrontName(?string $frontName): self
    {
        $this->frontName = $frontName;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getReferral(): ?Referral
    {
        return $this->referral;
    }

    public function setReferral(?Referral $referral): self
    {
        $this->referral = $referral;

        return $this;
    }
}
