<?php

namespace App\Entity\User;

use App\Entity\Rsi\Ship\Ship;
use App\Entity\User;
use App\Repository\User\FleetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int  $id          = null;

    #[ORM\ManyToOne(inversedBy: 'fleets')]
    private ?Ship $ship        = null;

    #[ORM\Column]
    private ?int  $numberShips = null;

    #[ORM\ManyToOne(inversedBy: 'fleets')]
    private ?User $user        = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isBuyInGame = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->numberShips = 1;
    }

    public function __toString(): string
    {
        return sprintf('%s [%d] %s', $this->getShip()->getName(), $this->getNumberShips(), $this->isIsBuyInGame() ? 'Achat in Game' : 'Achat IRL');
    }

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): self
    {
        $this->ship = $ship;

        return $this;
    }

    public function getNumberShips(): ?int
    {
        return $this->numberShips;
    }

    public function setNumberShips(int $numberShips): self
    {
        $this->numberShips = $numberShips;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isIsBuyInGame(): ?bool
    {
        return $this->isBuyInGame;
    }

    public function setIsBuyInGame(?bool $isBuyInGame): self
    {
        $this->isBuyInGame = $isBuyInGame;

        return $this;
    }
}
