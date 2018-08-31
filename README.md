[![Latest Stable Version](https://poser.pugx.org/bentools/uri-factory/v/stable)](https://packagist.org/packages/bentools/uri-factory)
[![License](https://poser.pugx.org/bentools/uri-factory/license)](https://packagist.org/packages/bentools/uri-factory)
[![Build Status](https://img.shields.io/travis/bpolaszek/uri-factory/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/uri-factory)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/uri-factory/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/uri-factory?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/uri-factory.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/uri-factory)
[![Total Downloads](https://poser.pugx.org/bentools/uri-factory/downloads)](https://packagist.org/packages/bentools/uri-factory)

# Uri Factory

A library / framework agnostic PSR-7 `UriInterface` factory.

There are several PSR-7 libraries on packagist but each one has its own factory for creating an `UriInterface` object from a string.

[bentools/uri-factory](https://github.com/bpolaszek/uri-factory) has no explicit dependency and automatically picks up your favorite library for creating `UriInterface` instances.

Supported libraries so far:

* `guzzlehttp/psr7`
* `zendframework/zend-diactoros`
* `league/uri`

## Usage

On any URL string:
```php
use function BenTools\UriFactory\Helper\uri;
$uri = uri('http://www.example.net'); // Will convert to a Psr\Http\Message\UriInterface instance
```

On current location:
```php
use function BenTools\UriFactory\Helper\current_location;
$uri = current_location(); // Will convert the current location to a Psr\Http\Message\UriInterface instance
```

You can specify which library to use, by using the corresponding adapter:
```php
use BenTools\UriFactory\Adapter\GuzzleAdapter;
use BenTools\UriFactory\Adapter\LeagueUriAdapter;
use BenTools\UriFactory\Adapter\ZendDiactorosAdapter;
use function BenTools\UriFactory\Helper\current_location;
use function BenTools\UriFactory\Helper\uri;

$uri = uri('http://www.example.net', GuzzleAdapter::factory());
$uri = uri('http://www.example.net', LeagueUriAdapter::factory());
$uri = uri('http://www.example.net', ZendDiactorosAdapter::factory());

$uri = current_location(GuzzleAdapter::factory());
$uri = current_location(LeagueUriAdapter::factory());
$uri = current_location(ZendDiactorosAdapter::factory());
```

## Canonicalizer

This library ships with an URL canonicalizer. 

It is not a perfect one since your PSR-7 library may behave differently regarding special chars, but it should work most of the time.

The `canonicalize()` function accepts any PSR-7 `UriInterface` object and will return a canonicalized one.

```php
require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\UriFactory\Helper\canonicalize;
use function BenTools\UriFactory\Helper\uri;

$url = 'http://example.org../foo/../bar/?#baz';
echo canonicalize(uri($url)); // http://example.org/bar/
```


## Installation

PHP 7.1+ is required.

> composer require bentools/uri-factory

## Tests

> ./vendor/bin/phpunit

## Contribute

If you want [bentools/uri-factory](https://github.com/bpolaszek/uri-factory) to support more PSR-7 libraries, feel free to submit a PR.

## License

MIT.