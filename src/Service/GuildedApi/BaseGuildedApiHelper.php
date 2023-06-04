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

abstract class BaseGuildedApiHelper
{
    protected HttpClientInterface $guildedClient;

    private string                $login;

    private string                $password;

    protected ?array              $cookies;

    protected FilesystemAdapter     $cache;

    public function __construct(
        HttpClientInterface $guildedClient
    )
    {
        $this->guildedClient = $guildedClient;
        $this->login         = $_ENV['GUILDED_LOGIN'];
        $this->password      = $_ENV['GUILDED_PASSWORD'];
        $this->cache         = new FilesystemAdapter();
        $this->login();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function login()
    {
        try {
            $this->cookies = $this->cache->get('login23', function (ItemInterface $item) {

                $response = $this->guildedClient->request('POST', '/api/login', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                    ],
                    'body'    => json_encode([
                        'email'    => $this->login,
                        'password' => $this->password,
                    ]),
                ]);

                $userInfo        = $response->toArray(false);
                $responseCookies = $response->getHeaders()['set-cookie'];

                $time = 3600;
                foreach ($responseCookies as $responseCookie) {
                    preg_match('/(?<=Max-Age=)(\d+)/', $responseCookie, $matches);
                    if (count($matches) > 0) {
                        $time = (int)$matches[0];
                        break;
                    }
                }
                $item->expiresAfter($time);

                return $responseCookies;
            });
        } catch (\Exception $e) {
            $this->cookies = null;
        }
    }
}
