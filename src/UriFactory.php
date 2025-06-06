<?php

namespace BenTools\UriFactory;

use BenTools\UriFactory\Adapter\AdapterInterface;
use BenTools\UriFactory\Adapter\GuzzleAdapter;
use BenTools\UriFactory\Adapter\LeagueUriAdapter;
use BenTools\UriFactory\Adapter\NyholmAdapter;
use BenTools\UriFactory\Adapter\ReactAdapter;
use BenTools\UriFactory\Adapter\RingCentralAdapter;
use Psr\Http\Message\UriInterface;

class UriFactory implements UriFactoryInterface
{

    /**
     * @var AdapterInterface[]
     */
    private $adapters = [];

    /**
     * UriFactory constructor.
     */
    protected function __construct()
    {
        $this->adapters = $this->getDefaultAdapters();
    }

    /**
     * @return array
     */
    private function getDefaultAdapters(): array
    {
        return [
            NyholmAdapter::class,
            GuzzleAdapter::class,
            LeagueUriAdapter::class,
            RingCentralAdapter::class,
            ReactAdapter::class,
        ];
    }

    /**
     * @param string $uri
     * @param UriFactoryInterface|null $factory
     * @return UriInterface
     */
    public function createUri(string $uri = '', ?UriFactoryInterface $factory = null): UriInterface
    {
        if (null !== $factory) {
            return $factory->createUri($uri);
        }

        // Automatic discovery
        foreach ($this->adapters as $adapter) {
            if ($adapter::isInstalled()) {
                return $adapter::factory()->createUri($uri);
            }
        }
        throw new \RuntimeException(
            "No adapter is installed. Please install nyholm/psr7, ringcentral/psr7, guzzlehttp/psr7 or league/uri."
        );
    }

    /**
     * @param UriFactoryInterface|null $factory
     * @return UriInterface
     */
    public function createUriFromCurrentLocation(?UriFactoryInterface $factory = null): UriInterface
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            throw new \RuntimeException('$_SERVER[\'HTTP_HOST\'] has not been set.');
        }
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new \RuntimeException('$_SERVER[\'REQUEST_URI\'] has not been set.');
        }
        $currentLocation = sprintf(
            '%s://%s%s',
            $this->getSchemeFromServer($_SERVER),
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        return $this->createUri($currentLocation, $factory);
    }

    /**
     * @param array $server
     * @return string
     */
    private function getSchemeFromServer(array $server): string
    {
        if (!empty($server['REQUEST_SCHEME'])) {
            return $server['REQUEST_SCHEME'];
        }

        switch ($server['HTTPS'] ?? null) {
            case 'on':
            case '1':
                return 'https';
        }
        return 'http';
    }

    /**
     * @return UriFactory
     */
    public static function factory(): UriFactoryInterface
    {
        return new self;
    }
}
