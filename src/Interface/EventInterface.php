<?php

namespace App\Interface;

use DateTimeInterface;

interface EventInterface
{
    public function getTitle(): string;

    public function getStartedAt(): DateTimeInterface;

    public function getEndAt(): DateTimeInterface;

    public function isNow(): bool;
}
