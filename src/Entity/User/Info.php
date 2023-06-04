<?php

namespace App\Entity\User;

use App\Repository\User\InfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rsiName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $guildedName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $discordName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRsiName(): ?string
    {
        return $this->rsiName;
    }

    public function setRsiName(?string $rsiName): self
    {
        $this->rsiName = $rsiName;

        return $this;
    }

    public function getGuildedName(): ?string
    {
        return $this->guildedName;
    }

    public function setGuildedName(?string $guildedName): self
    {
        $this->guildedName = $guildedName;

        return $this;
    }

    public function getDiscordName(): ?string
    {
        return $this->discordName;
    }

    public function setDiscordName(?string $discordName): self
    {
        $this->discordName = $discordName;

        return $this;
    }
}
