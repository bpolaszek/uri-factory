[![Latest Stable Version](https://poser.pugx.org/bentools/uri-factory/v/stable)](https://packagist.org/packages/bentools/uri-factory)
[![License](https://poser.pugx.org/bentools/uri-factory/license)](https://packagist.org/packages/bentools/uri-factory)
[![Build Status](https://img.shields.io/travis/bpolaszek/uri-factory/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/uri-factory)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/uri-factory/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/uri-factory?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/uri-factory.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/uri-factory)
[![Total Downloads](https://poser.pugx.org/bentools/uri-factory/downloads)](https://packagist.org/packages/bentools/uri-factory)

# Uri Factory

This library discovers which PSR-7 library is included in your project in order to create PSR-7 `UriInterface` objects.

Current supported libraries:

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

## Installation

PHP 7.1+ is required.

> composer require bentools/uri-factory 1.0.x-dev

## Tests

> ./vendor/bin/phpunit

## License

MIT.