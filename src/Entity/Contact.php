<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    public const TYPE_CONTACTS = [
        'Contact',
        'Recrutement'  ,
        'Fonctionnalité pour le site',
        'Remonter un bug',
    ];


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $send_at = null;

    #[ORM\Column(length: 255)]
    private ?string $typeContact = null;

    #[ORM\Column]
    private ?bool $is_traited = false;

    public function __construct()
    {
        $this->send_at = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSendAt(): ?\DateTimeImmutable
    {
        return $this->send_at;
    }

    public function setSendAt(\DateTimeImmutable $send_at): self
    {
        $this->send_at = $send_at;

        return $this;
    }

    public function getTypeContact(): ?string
    {
        return $this->typeContact;
    }

    public function setTypeContact(string $typeContact): self
    {
        $this->typeContact = $typeContact;

        return $this;
    }

    public function isIsTraited(): ?bool
    {
        return $this->is_traited;
    }

    public function setIsTraited(bool $is_traited): self
    {
        $this->is_traited = $is_traited;

        return $this;
    }
}
