<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use React\Http\Message\Uri;

final class ReactAdapter implements AdapterInterface
{
    public static function isInstalled(): bool
    {
        return class_exists('React\Http\Message\Uri');
    }

    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }

    public static function factory(): UriFactoryInterface
    {
        return new self;
    }
}
