<?php

namespace App\Service\Rsi;

use App\Repository\Rsi\Ship\ManufacturerRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BaseProvider
{
    const PREFIX_CACHE = 4;

    const BASE_URL = "https://robertsspaceindustries.com";

    protected HttpClientInterface    $client;

    protected FilesystemAdapter      $cache;

    protected Filesystem             $filesystem;

    protected ManufacturerRepository $manufacturerRepository;

    public function __construct(
        HttpClientInterface    $client,
        ManufacturerRepository $manufacturerRepository
    )
    {
        $this->client                 = $client;
        $this->cache                  = new FilesystemAdapter();
        $this->filesystem             = new Filesystem();
        $this->manufacturerRepository = $manufacturerRepository;
    }
}
