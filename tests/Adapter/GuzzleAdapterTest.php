<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\GuzzleAdapter;
use function BenTools\UriFactory\Helper\current_location;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class GuzzleAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists('GuzzleHttp\Psr7\Uri'), GuzzleAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = GuzzleAdapter::factory();
        $this->assertInstanceOf(GuzzleAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = GuzzleAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(GuzzleAdapter::factory());
        $this->assertInstanceOf('GuzzleHttp\Psr7\Uri', $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
