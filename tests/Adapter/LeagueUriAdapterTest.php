<?php

namespace BenTools\UriFactory\Tests\Adapter;

use BenTools\UriFactory\Adapter\LeagueUriAdapter;
use function BenTools\UriFactory\Helper\current_location;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class LeagueUriAdapterTest extends TestCase
{

    public function testClassCheck()
    {
        $this->assertEquals(class_exists('League\Uri\Factory'), LeagueUriAdapter::isInstalled());
    }

    public function testFactory()
    {
        $factory = LeagueUriAdapter::factory();
        $this->assertInstanceOf(LeagueUriAdapter::class, $factory);
    }

    public function testUri()
    {
        $factory = LeagueUriAdapter::factory();
        $uri = $factory->createUri('http://www.example.net');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testInFactory()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/foo/bar?foo=bar&baz=bat';
        $uri = current_location(LeagueUriAdapter::factory());
        $this->assertInstanceOf('League\Uri\Http', $uri);
        unset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);
    }
}
