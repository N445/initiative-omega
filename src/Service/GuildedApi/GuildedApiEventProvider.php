<?php

namespace App\Service\GuildedApi;

use App\Model\Guilded\Event;
use App\Service\DiscordApi\BaseDiscordApiHelper;
use DateInterval;
use DateTime;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @property FilesystemAdapter $cache
 */
class GuildedApiEventProvider extends BaseGuildedApiHelper
{
    /**
     * @return Event[]
     * @throws InvalidArgumentException
     * @throws ExceptionInterface
     */
    public function getEvents(): array
    {
        if (!$this->cookies) {
            return [];
        }

        try {
            $rawData = $this->cache->get('guildedEvents', function (ItemInterface $item) {
                $item->expiresAfter(3600);
                $startDate = new DateTime('-7 days');
//                $startDate = new \DateTime('now');
                $endDate = new DateTime('+7 days');
//                $endDate = new \DateTime('now');

                $response = $this->guildedClient->request('GET', '/api/channels/b2205c03-e9fd-4b64-bd43-3c0ec3c217f6/events', [
                    'headers' => [
                        'Content-Type'    => 'application/json',
                        'Accept'          => 'application/json',
                        'Cookie'          => implode(';', $this->cookies),
                    ],
                    'query'   => [
                        'maxItems'  => 20,
                        'startDate' => $startDate->format(DateTime::ATOM),
                        'endDate'   => $endDate->format(DateTime::ATOM),
                    ],
                ]);

                $rawData = $response->toArray(false)['events'] ?? [];

                return $rawData;
            });
        } catch (Exception $e) {
            return [];
        }

        $encoders    = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer  = new Serializer($normalizers, $encoders);

        return array_map(function ($rawDatum) use ($serializer) {
            /** @var Event $event */
            $event = $serializer->denormalize($rawDatum, Event::class);
            $endAt = clone $event->getHappensAt();
            $event->setEndAt($endAt->add(new DateInterval("PT{$event->getDurationInMinutes()}M")));
            return $event;
        }, $rawData);
    }
}
