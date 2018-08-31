<?php

namespace BenTools\UriFactory;

use Psr\Http\Message\UriInterface;

interface UriFactoryInterface extends \Psr\Http\Message\UriFactoryInterface
{

    /**
     * @param string $uri
     * @return UriInterface
     */
    public function createUri(string $uri = ''): UriInterface;

    /**
     * @return UriFactoryInterface
     */
    public static function factory(): UriFactoryInterface;
}
