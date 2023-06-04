<?php

namespace App\Entity\Event;

use App\Repository\Event\DateRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateRepository::class)]
#[ORM\Table(name: 'event_date')]
class Date
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int               $id    = null;

    #[ORM\Column]
    private ?DateTimeImmutable $start_at  = null;

    #[ORM\Column]
    private ?DateTimeImmutable $end_at = null;

    #[ORM\ManyToOne(inversedBy: 'dates')]
    private ?Event             $event = null;

    /**
     * @throws \Exception
     */
    public function __construct(DateTime $dateTime, DateTime $endAt)
    {
        $this->start_at  = new DateTimeImmutable($dateTime->format(DATE_ATOM));
        $this->end_at = new DateTimeImmutable($endAt->format(DATE_ATOM));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(?DateTimeImmutable $start_at): Date
    {
        $this->start_at = $start_at;
        return $this;
    }

    public function getEndAt(): ?DateTimeImmutable
    {
        return $this->end_at;
    }

    public function setEndAt(?DateTimeImmutable $end_at): Date
    {
        $this->end_at = $end_at;
        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
