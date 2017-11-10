<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\Uri;

final class ZendDiactorosAdapter implements AdapterInterface
{

    /**
     * ZendDiactorosAdapter constructor.
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
        return class_exists('Zend\Diactoros\Uri');
    }
}
