<?php

namespace BenTools\UriFactory\Helper;

use BenTools\UriFactory\UriFactory;
use BenTools\UriFactory\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * @param string $uri
 * @param UriFactoryInterface|null $factory
 * @return UriInterface
 */
function uri(string $uri, UriFactoryInterface $factory = null): UriInterface
{
    return UriFactory::factory()->createUri($uri, $factory);
}

/**
 * @param UriFactoryInterface|null $factory
 * @return UriInterface
 */
function current_location(UriFactoryInterface $factory = null): UriInterface
{
    return UriFactory::factory()->createUriFromCurrentLocation($factory);
}
