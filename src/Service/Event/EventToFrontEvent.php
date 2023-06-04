<?php

namespace App\Service\Event;

use App\Entity\Event\Event;
use App\Model\FrontEvent;

class EventToFrontEvent
{
    private \Vich\UploaderBundle\Templating\Helper\UploaderHelper $uploaderHelper;

    public function __construct(\Vich\UploaderBundle\Templating\Helper\UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function toFrontEvent(Event $event, ?\DateTimeInterface $startedAt = null, ?\DateTimeInterface $endAt = null): FrontEvent
    {
        $frontEvent = (new FrontEvent())
            ->setId($event->getId())
            ->setHasRrule($event->isHasRrule())
            ->setTypeCode($event->getType() ? $event->getType()->getCode() : 'free')
            ->setTypeTitle($event->getType() ? $event->getType()->getTitle() : 'Libre')
            ->setTitle($event->getTitle())
            ->setContent($event->getContent())
            ->setStartedAt($startedAt ?: EventDateProvider::getNextDateStart($event))
            ->setDuration($event->getDuration())
            ->setEndAt($endAt ?: EventDateProvider::getNextDateEnd($event))
        ;

        if ($event->getImage()) {
            $frontEvent->setImagePath($this->uploaderHelper->asset($event));
        } elseif ($event->getType() && $event->getType()->getImage()) {
            $frontEvent->setImagePath($this->uploaderHelper->asset($event->getType()));
        } else {
            $frontEvent->setImagePath('images/event/default.webp');
        }

        return $frontEvent;
    }

    public function toFrontEvents(array $events): array
    {
        $frontsEvents = [];

        /** @var Event $event */
        foreach ($events as $event) {
            if (!$event->isHasRrule()) {
                $frontsEvents[] = $this->toFrontEvent($event);
                continue;
            }

            $rruleObject = $event->getRrule()->getRRuleObject();

            $occurrences = $rruleObject->getOccurrencesBetween(new \DateTime('-30 days'), new \DateTime('+30 days'), 20);

            /** @var \DateTime $startedAt */
            foreach ($occurrences as $startedAt) {
                $endAt = clone $startedAt;
                $endAt->add($event->getDuration());
                $frontsEvents[] = $this->toFrontEvent($event, $startedAt, $endAt);
            }
        }

        foreach ($frontsEvents as $key => $event) {
            if(EventHelper::isPast($event)){
                unset($frontsEvents[$key]);
            }
        }

        return $frontsEvents;
    }
}
