<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\NyholmAdapter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use function BenTools\UriFactory\Helper\current_location;

class NyholmAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists('Nyholm\Psr7\Uri'), NyholmAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = NyholmAdapter::factory();
        $this->assertInstanceOf(NyholmAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = NyholmAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(NyholmAdapter::factory());
        $this->assertInstanceOf('Nyholm\Psr7\Uri', $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
