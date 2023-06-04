<?php

namespace App\Service\GuildedApi;

use App\Model\Guilded\Event;
use App\Model\Guilded\Media;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @property FilesystemAdapter $cache
 */
class GuildedApiMediaProvider extends BaseGuildedApiHelper
{
    /**
     * @return Media[]
     * @throws InvalidArgumentException
     */
    public function getMedias(?int $pageSize = null)
    {
        if (null === $pageSize) {
            $pageSize = 40;
        }
        if (!$this->cookies) {
            return [];
        }
        try {
            return $this->cache->get('medias2' . $pageSize, function (ItemInterface $item) use ($pageSize) {
                $item->expiresAfter(3600);

                $response = $this->guildedClient->request('GET', sprintf('/api/channels/16a4ed58-18f0-4264-aa5a-19497a4c0421/media?pageSize=%d', $pageSize), [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                        'Cookie'       => implode(';', $this->cookies),
                    ],
                ]);

                $rawData = $response->toArray(false);
                if ($rawData['code'] ?? null) {
                    return [];
                }

                $encoders    = [new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];
                $serializer  = new Serializer($normalizers, $encoders);

                return array_map(function ($rawDatum) use ($serializer) {
                    return $serializer->denormalize($rawDatum, Media::class);
                }, $rawData);
            }, INF);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getMediasByIds(array $ids)
    {
        if (!$this->cookies) {
            return [];
        }
        try {
            $medias = $this->cache->get('medias2', function (ItemInterface $item) {
                $item->expiresAfter(3600);

                $response = $this->guildedClient->request('GET', '/api/channels/16a4ed58-18f0-4264-aa5a-19497a4c0421/media', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                        'Cookie'       => implode(';', $this->cookies),
                    ],
                ]);

                $rawData = $response->toArray(false);

                $encoders    = [new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];
                $serializer  = new Serializer($normalizers, $encoders);

                return array_map(function ($rawDatum) use ($serializer) {
                    return $serializer->denormalize($rawDatum, Media::class);
                }, $rawData);
            }, INF);
        } catch (\Exception $e) {
            return [];
        }

        return array_filter($medias, function (Media $media) use ($ids) {
            return in_array($media->getId(), $ids);
        });
    }
}
