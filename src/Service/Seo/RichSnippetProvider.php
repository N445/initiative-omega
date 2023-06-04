<?php

namespace App\Service\Seo;

use App\Model\Guilded\Event;
use App\Service\DiscordApi\DiscordApiEventProvider;
use App\Service\GuildedApi\GuildedApiEventProvider;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\RequestStack;

class RichSnippetProvider
{
    private GuildedApiEventProvider $guildedApiEventProvider;

    private RequestStack            $requestStack;

    public function __construct(
        GuildedApiEventProvider $guildedApiEventProvider,
        RequestStack            $requestStack
    )
    {
        $this->guildedApiEventProvider = $guildedApiEventProvider;
        $this->requestStack            = $requestStack;
    }

    public function getRichSnippetGlobal()
    {
        $package = new UrlPackage($this->requestStack->getMainRequest()->getSchemeAndHttpHost(), new EmptyVersionStrategy());
        return [
            "@context"     => "https://schema.org",
            "@type"        => "Organization",
            "name"         => "Shadow of Caliban",
            "legalName"    => "Shadow of Caliban",
            "slogan"       => "Flotte nomade des Shadow of Caliban",
            "areaServed"   => "France",
            "location"     => "France",
            "logo"         => $package->getUrl('images/logo/logo-couleur.svg'),
            "foundingDate" => "2021-05-18",
            "keywords"     => [
                'Star Citizen', 'Robert Space industries', 'Shadow of Caliban', 'Star Citizen Corporation', 'Role Play',
            ],
            "brand"        => [
                "@type"         => "brand",
                "name"          => "Star Citizen",
                "logo"          => "https://robertsspaceindustries.com/rsi/static/packages/platformbar/sc.png",
                "alternateName" => "Robert space industries",
                "url"           => "https://robertsspaceindustries.com/star-citizen",
            ],
            "contactPoint" => [
                "@type"             => "contactPoint",
                "areaServed"        => "France",
                "availableLanguage" => [
                    "@type"         => "Language",
                    "name"          => "French",
                    "alternateName" => "fr",
                ],
                "contactType"       => [
                    "Discord",
                    "Guilded",
                ],
            ],
            "event"        => $this->getRichSnippetEvents(),
        ];
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    private function getRichSnippetEvents(): array
    {
        return array_map(function (Event $event) {
            return [
                "@type"     => "Event",
                "name"      => $event->getName(),
                "startDate" => $event->getHappensAt()->format("Y-m-d H:i"),
                "endDate"   => $event->getEndAt()->format("Y-m-d H:i"),
            ];
        }, $this->guildedApiEventProvider->getEvents());
    }
}
