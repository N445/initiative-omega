<?php

namespace App\Model\Guilded;

use App\Interface\EventInterface;
use App\Service\Event\EventHelper;
use DateTimeInterface;

class Event implements EventInterface
{
    private int        $id;

    private string     $name;

    private ?array     $description;

    private bool       $repeats;

    private ?string    $link;

    private ?string    $location;

    private string     $visibility;

    private ?array     $rsvps;

    private int        $numGoing;

    private \DateTimeImmutable  $createdAt;

    private string     $teamId;

    private string     $createdBy;

    private int        $gameId;

    private DateTimeInterface  $happensAt;

    private DateTimeInterface  $endAt;

    private int        $durationInMinutes;

    private bool       $isPublic;

    private string     $colorLabel;

    private bool       $isAllDay;

    private bool       $isOpen;

    private bool       $isPrivate;

    private bool       $isCancelled;

    private ?array     $cancellationDescription;

    private ?string    $cancelledBy;

    private ?\DateTimeImmutable $previousHappensAt;

    private int        $eventId;

    private bool       $autofillWaitlist;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getGuildedUrl()
    {
        return 'https://www.guilded.gg/Shadow-of-Caliban/groups/Q3mv9W6D/channels/b2205c03-e9fd-4b64-bd43-3c0ec3c217f6/calendar/' . $this->getId();
    }

    /**
     * @param int $id
     * @return Event
     */
    public function setId(int $id): Event
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): Event
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getDescription(): ?array
    {
        return $this->description;
    }

    /**
     * @param array|null $description
     * @return Event
     */
    public function setDescription(?array $description): Event
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRepeats(): bool
    {
        return $this->repeats;
    }

    /**
     * @param bool $repeats
     * @return Event
     */
    public function setRepeats(bool $repeats): Event
    {
        $this->repeats = $repeats;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return Event
     */
    public function setLink(?string $link): Event
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     * @return Event
     */
    public function setLocation(?string $location): Event
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return Event
     */
    public function setVisibility(string $visibility): Event
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRsvps(): ?array
    {
        return $this->rsvps;
    }

    /**
     * @param array|null $rsvps
     * @return Event
     */
    public function setRsvps(?array $rsvps): Event
    {
        $this->rsvps = $rsvps;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumGoing(): int
    {
        return $this->numGoing;
    }

    /**
     * @param int $numGoing
     * @return Event
     */
    public function setNumGoing(int $numGoing): Event
    {
        $this->numGoing = $numGoing;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable|string $createdAt
     * @return Event
     * @throws \Exception
     */
    public function setCreatedAt($createdAt): Event
    {
        if (is_string($createdAt)) {
            $createdAt = new \DateTimeImmutable($createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->teamId;
    }

    /**
     * @param string $teamId
     * @return Event
     */
    public function setTeamId(string $teamId): Event
    {
        $this->teamId = $teamId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     * @return Event
     */
    public function setCreatedBy(string $createdBy): Event
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * @param int $gameId
     * @return Event
     */
    public function setGameId(int $gameId): Event
    {
        $this->gameId = $gameId;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getHappensAt(): DateTimeInterface
    {
        return $this->happensAt;
    }

    /**
     * @param DateTimeInterface $happensAt
     * @return Event
     * @throws \Exception
     */
    public function setHappensAt(DateTimeInterface $happensAt): Event
    {
        if (is_string($happensAt)) {
            $happensAt = new \DateTimeImmutable($happensAt);
        }
        $this->happensAt = $happensAt;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndAt(): DateTimeInterface
    {
        return $this->endAt;
    }

    /**
     * @param DateTimeInterface $endAt
     * @return Event
     */
    public function setEndAt(DateTimeInterface $endAt): Event
    {
        $this->endAt = $endAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNow(): bool
    {
        return EventHelper::isNow($this);
    }

    /**
     * @return int
     */
    public function getDurationInMinutes(): int
    {
        return $this->durationInMinutes;
    }

    /**
     * @param int $durationInMinutes
     * @return Event
     */
    public function setDurationInMinutes(int $durationInMinutes): Event
    {
        $this->durationInMinutes = $durationInMinutes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     * @return Event
     */
    public function setIsPublic(bool $isPublic): Event
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    /**
     * @return string
     */
    public function getColorLabel(): string
    {
        return $this->colorLabel;
    }

    /**
     * @param string $colorLabel
     * @return Event
     */
    public function setColorLabel(string $colorLabel): Event
    {
        $this->colorLabel = $colorLabel;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllDay(): bool
    {
        return $this->isAllDay;
    }

    /**
     * @param bool $isAllDay
     * @return Event
     */
    public function setIsAllDay(bool $isAllDay): Event
    {
        $this->isAllDay = $isAllDay;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    /**
     * @param bool $isOpen
     * @return Event
     */
    public function setIsOpen(bool $isOpen): Event
    {
        $this->isOpen = $isOpen;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    /**
     * @param bool $isPrivate
     * @return Event
     */
    public function setIsPrivate(bool $isPrivate): Event
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }

    /**
     * @param bool $isCancelled
     * @return Event
     */
    public function setIsCancelled(bool $isCancelled): Event
    {
        $this->isCancelled = $isCancelled;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCancellationDescription(): ?array
    {
        return $this->cancellationDescription;
    }

    /**
     * @param array|null $cancellationDescription
     * @return Event
     */
    public function setCancellationDescription(?array $cancellationDescription): Event
    {
        $this->cancellationDescription = $cancellationDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCancelledBy(): ?string
    {
        return $this->cancelledBy;
    }

    /**
     * @param string|null $cancelledBy
     * @return Event
     */
    public function setCancelledBy(?string $cancelledBy): Event
    {
        $this->cancelledBy = $cancelledBy;
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getPreviousHappensAt(): ?\DateTimeImmutable
    {
        return $this->previousHappensAt;
    }

    /**
     * @param \DateTimeImmutable|string|null $previousHappensAt
     * @return Event
     * @throws \Exception
     */
    public function setPreviousHappensAt($previousHappensAt): Event
    {
        if (is_string($previousHappensAt)) {
            $previousHappensAt = new \DateTimeImmutable($previousHappensAt);
        }
        $this->previousHappensAt = $previousHappensAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     * @return Event
     */
    public function setEventId(int $eventId): Event
    {
        $this->eventId = $eventId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutofillWaitlist(): bool
    {
        return $this->autofillWaitlist;
    }

    /**
     * @param bool $autofillWaitlist
     * @return Event
     */
    public function setAutofillWaitlist(bool $autofillWaitlist): Event
    {
        $this->autofillWaitlist = $autofillWaitlist;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->name;
    }

    public function getStartedAt(): DateTimeInterface
    {
        return $this->happensAt;
    }
}
