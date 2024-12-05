<?php

namespace BenTools\UriFactory\Helper;

use BenTools\UriFactory\UriCanonicalizer;
use BenTools\UriFactory\UriFactory;
use BenTools\UriFactory\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * @param string $uri
 * @param UriFactoryInterface|null $factory
 * @return UriInterface
 */
function uri(string $uri, ?UriFactoryInterface $factory = null): UriInterface
{
    return UriFactory::factory()->createUri($uri, $factory);
}

/**
 * @param UriFactoryInterface|null $factory
 * @return UriInterface
 * @throws \RuntimeException
 */
function current_location(?UriFactoryInterface $factory = null): UriInterface
{
    return UriFactory::factory()->createUriFromCurrentLocation($factory);
}

/**
 * @param UriInterface $uri
 * @return UriInterface
 * @throws \InvalidArgumentException
 */
function canonicalize(UriInterface $uri): UriInterface
{
    return UriCanonicalizer::canonicalize($uri);
}
