<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use RingCentral\Psr7\Uri;
use Psr\Http\Message\UriInterface;

final class RingCentralAdapter implements AdapterInterface
{
    protected function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function createUri(string $uri = ''): UriInterface
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
        return class_exists('\RingCentral\Psr7\Uri');
    }
}
