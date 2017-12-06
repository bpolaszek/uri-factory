<?php

namespace BenTools\UriFactory\Tests;

use BenTools\UriFactory\Adapter\GuzzleAdapter;
use function BenTools\UriFactory\Helper\canonicalize;
use function BenTools\UriFactory\Helper\uri;
use BenTools\UriFactory\UriCanonicalizer;
use PHPUnit\Framework\TestCase;

class UriCanonicalizerTest extends TestCase
{

    public function testEnsureSchemeIsNotBlank()
    {
        $uri = uri('www.example.org');
        $this->assertEquals('http', UriCanonicalizer::ensureSchemeIsNotBlank($uri)->getScheme());
    }

    public function testRemoveFragment()
    {
        $uri = uri('http://example.org/foo#bar');
        $this->assertEquals('', UriCanonicalizer::removeFragment($uri)->getFragment());
    }

    public function testRemoveLeadingAndTrailingDots()
    {
        $uri = uri('http://...www.example.org.../foo');
        $this->assertEquals('www.example.org', UriCanonicalizer::removeLeadingAndTrailingDots($uri)->getHost());
    }

    public function testReplaceConsecutiveDotsWithASingleDot()
    {
        $uri = uri('http://www..example...org/foo');
        $this->assertEquals('www.example.org', UriCanonicalizer::replaceConsecutiveDotsWithASingleDot($uri)->getHost());
    }

    public function testNormalizeHostname()
    {
        $uri = uri('http://WWW.EXAMPLE.ORG');
        $this->assertEquals('www.example.org', UriCanonicalizer::normalizeHostname($uri)->getHost());
    }

    public function testNormalizePath()
    {
        $uri = uri('http://example.org/apple/../../cherry/banana/strawberry/../../orange/./pear//pineapple/');
        $this->assertEquals('/cherry/orange/pear/pineapple/', UriCanonicalizer::normalizePath($uri)->getPath());
        $uri = uri('http://example.org//');
        $this->assertEquals('/', UriCanonicalizer::normalizePath($uri)->getPath());
        $uri = uri('http://example.org/../');
        $this->assertEquals('/', UriCanonicalizer::normalizePath($uri)->getPath());
        $uri = uri('http://example.org/');
        $this->assertEquals('/', UriCanonicalizer::normalizePath($uri)->getPath());
        $uri = uri('http://example.org');
        $this->assertEquals('/', UriCanonicalizer::normalizePath($uri)->getPath());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCanonicalize(string $testedUrl, string $expectedUrl)
    {
        $result = (string) canonicalize(uri($testedUrl, GuzzleAdapter::factory()));
        $this->assertEquals($expectedUrl, $result);
    }

    public function dataProvider()
    {
        return [
            ['http://host/%25%32%35', 'http://host/%25'],
            ['http://host/%25%32%35%25%32%35', 'http://host/%25%25'],
            ['http://host/%2525252525252525', 'http://host/%25'],
            ['http://host/asdf%25%32%35asd', 'http://host/asdf%25asd'],
            ['http://host/%%%25%32%35asd%%', 'http://host/%25%25%25asd%25%25'],
            ['http://www.google.com/', 'http://www.google.com/'],
            ['http://%31%36%38%2e%31%38%38%2e%39%39%2e%32%36/%2E%73%65%63%75%72%65/%77%77%77%2E%65%62%61%79%2E%63%6F%6D/', 'http://168.188.99.26/.secure/www.ebay.com/'],
            ['http://195.127.0.11/uploads/%20%20%20%20/.verify/.eBaysecure=updateuserdataxplimnbqmn-xplmvalidateinfoswqpcmlx=hgplmcx/', 'http://195.127.0.11/uploads/%20%20%20%20/.verify/.eBaysecure=updateuserdataxplimnbqmn-xplmvalidateinfoswqpcmlx=hgplmcx/'],
            ['http://host.com/%257Ea%2521b%2540c%2523d%2524e%25f%255E00%252611%252A22%252833%252944_55%252B', 'http://host.com/~a!b@c%23d$e%25f%5E00&11*22(33)44_55%20'],
            ['http://3279880203/blah', 'http://195.127.0.11/blah'],
            ['http://www.google.com/blah/..', 'http://www.google.com/'],
            ['http://www.evil.com/blah#frag', 'http://www.evil.com/blah'],
            ['http://www.GOOgle.com/', 'http://www.google.com/'],
            ['http://www.google.com.../', 'http://www.google.com/'],
            ['http://www.google.com/q?r?', 'http://www.google.com/q?r?'],
            ['http://www.google.com/q?r?s', 'http://www.google.com/q?r?s'],
            ['http://evil.com/foo#bar#baz', 'http://evil.com/foo'],
            ['http://evil.com/foo;', 'http://evil.com/foo;'],
            ['http://evil.com/foo?bar;', 'http://evil.com/foo?bar;'],
            ['http://notrailingslash.com', 'http://notrailingslash.com/'],
            ['https://www.securesite.com/', 'https://www.securesite.com/'],
            ['http://host.com/ab%23cd', 'http://host.com/ab%23cd'],
            ['http://host.com//twoslashes?more//slashes', 'http://host.com/twoslashes?more//slashes'],
        ];
    }
}
