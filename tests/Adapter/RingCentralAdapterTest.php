<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\RingCentralAdapter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use function BenTools\UriFactory\Helper\current_location;

class RingCentralAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists('RingCentral\Psr7\Uri'), RingCentralAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = RingCentralAdapter::factory();
        $this->assertInstanceOf(RingCentralAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = RingCentralAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(RingCentralAdapter::factory());
        $this->assertInstanceOf('RingCentral\Psr7\Uri', $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
