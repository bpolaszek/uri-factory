<?php

namespace BenTools\UriFactory\Tests;

use BenTools\UriFactory\Adapter\GuzzleAdapter;
use BenTools\UriFactory\Adapter\LeagueUriAdapter;
use BenTools\UriFactory\UriFactory;
use GuzzleHttp\Psr7\Uri as GuzzleUri;
use League\Uri\Http as LeagueUri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use function BenTools\UriFactory\Helper\current_location;
use function BenTools\UriFactory\Helper\uri;

class UriFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = UriFactory::factory();
        $this->assertInstanceOf(UriFactory::class, $factory);
    }

    public function testUri()
    {
        $uri = uri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testRequestUri()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location();
        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertEquals('http://localhost/foo/bar?foo=bar&baz=bat', (string) $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testRequestUriFailsOnCli()
    {
        current_location();
    }
}
