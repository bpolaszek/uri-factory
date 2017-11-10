<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

final class GuzzleAdapter implements AdapterInterface
{
    /**
     * GuzzleAdapter constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function createUri(string $uri): UriInterface
    {
        return new Uri($uri);
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
        return class_exists('GuzzleHttp\Psr7\Uri');
    }
}
