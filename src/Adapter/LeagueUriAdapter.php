<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;
use League\Uri\Factory;
use Psr\Http\Message\UriInterface;

final class LeagueUriAdapter implements AdapterInterface
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * LeagueUriAdapter constructor.
     * @param Factory $factory
     */
    protected function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function createUri(string $uri): UriInterface
    {
        return $this->factory->create($uri);
    }

    /**
     * @inheritDoc
     */
    public static function factory(Factory $factory = null): UriFactoryInterface
    {
        return new self($factory ?? new Factory());
    }

    /**
     * @inheritDoc
     */
    public static function isInstalled(): bool
    {
        return class_exists('League\Uri\Factory');
    }
}
