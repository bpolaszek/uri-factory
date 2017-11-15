<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use League\Uri\Factory;
use League\Uri\Http;
use Psr\Http\Message\UriInterface;

final class LeagueUriAdapter implements AdapterInterface
{
    /**
     * @inheritDoc
     */
    public function createUri(string $uri): UriInterface
    {
        return Http::createFromString($uri);
    }

    /**
     * @inheritDoc
     */
    public static function factory(): UriFactoryInterface
    {
        return new self;
    }

    /**
     * @inheritDoc
     */
    public static function isInstalled(): bool
    {
        return class_exists('League\Uri\Http');
    }
}
