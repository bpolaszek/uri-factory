<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\ReactAdapter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use React\Http\Message\Uri;

use function BenTools\UriFactory\Helper\current_location;

class ReactAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists(Uri::class), ReactAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = ReactAdapter::factory();
        $this->assertInstanceOf(ReactAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = ReactAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(ReactAdapter::factory());
        $this->assertInstanceOf(Uri::class, $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
