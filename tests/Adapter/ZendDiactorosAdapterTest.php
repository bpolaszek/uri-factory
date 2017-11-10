<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\ZendDiactorosAdapter;
use function BenTools\UriFactory\Helper\current_location;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class ZendDiactorosAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists('Zend\Diactoros\Uri'), ZendDiactorosAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = ZendDiactorosAdapter::factory();
        $this->assertInstanceOf(ZendDiactorosAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = ZendDiactorosAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(ZendDiactorosAdapter::factory());
        $this->assertInstanceOf('Zend\Diactoros\Uri', $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
