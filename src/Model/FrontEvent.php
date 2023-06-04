<?php

namespace App\Model;

use App\Interface\EventInterface;
use App\Service\Event\EventHelper;
use DateInterval;
use DateTimeInterface;

class FrontEvent implements EventInterface
{
    private int               $id;

    private bool              $has_rrule;

    private string            $typeCode;

    private string            $typeTitle;

    private string            $title;

    private string            $content;

    private string            $imagePath;

    private DateTimeInterface $startedAt;

    private DateInterval      $duration;

    private DateTimeInterface $endAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FrontEvent
     */
    public function setId(int $id): FrontEvent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHasRrule(): bool
    {
        return $this->has_rrule;
    }

    /**
     * @param bool $has_rrule
     * @return FrontEvent
     */
    public function setHasRrule(bool $has_rrule): FrontEvent
    {
        $this->has_rrule = $has_rrule;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    /**
     * @param string $typeCode
     * @return FrontEvent
     */
    public function setTypeCode(string $typeCode): FrontEvent
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeTitle(): string
    {
        return $this->typeTitle;
    }

    /**
     * @param string $typeTitle
     * @return FrontEvent
     */
    public function setTypeTitle(string $typeTitle): FrontEvent
    {
        $this->typeTitle = $typeTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return FrontEvent
     */
    public function setTitle(string $title): FrontEvent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return FrontEvent
     */
    public function setContent(string $content): FrontEvent
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     * @return FrontEvent
     */
    public function setImagePath(string $imagePath): FrontEvent
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartedAt(): DateTimeInterface
    {
        return $this->startedAt;
    }

    /**
     * @param DateTimeInterface $startedAt
     * @return FrontEvent
     */
    public function setStartedAt(DateTimeInterface $startedAt): FrontEvent
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    /**
     * @return DateInterval
     */
    public function getDuration(): DateInterval
    {
        return $this->duration;
    }

    /**
     * @param DateInterval $duration
     * @return FrontEvent
     */
    public function setDuration(DateInterval $duration): FrontEvent
    {
        $this->duration = $duration;
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
     * @return FrontEvent
     */
    public function setEndAt(DateTimeInterface $endAt): FrontEvent
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function isNow(): bool
    {
        return EventHelper::isNow($this);
    }
}
