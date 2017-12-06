<?php

namespace BenTools\UriFactory;

use Psr\Http\Message\UriInterface;

final class UriCanonicalizer
{
    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function canonicalize(UriInterface $uri): UriInterface
    {
        $uri = self::ensureIsPercentUnescaped($uri);
        $uri = self::ensureSchemeIsNotBlank($uri);
        $uri = self::removeUnwantedChars($uri);
        $uri = self::removeFragment($uri);
        $uri = self::removeLeadingAndTrailingDots($uri);
        $uri = self::replaceConsecutiveDotsWithASingleDot($uri);
        $uri = self::normalizeHostname($uri);
        $uri = self::normalizePath($uri);
        return $uri;
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function ensureIsPercentUnescaped(UriInterface $uri): UriInterface
    {
        return $uri
            ->withHost(self::percentUnescape($uri->getHost()))
            ->withPath(self::percentUnescape($uri->getPath()))
            ;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function percentUnescape(string $string): string
    {
        while ($string !== ($decoded = urldecode($string))) {
            $string = $decoded;
        }
        return $string;
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function ensureSchemeIsNotBlank(UriInterface $uri): UriInterface
    {
        return '' === $uri->getScheme() ? $uri->withScheme('http') : $uri;
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     */
    public static function removeFragment(UriInterface $uri): UriInterface
    {
        return $uri->withFragment('');
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function removeUnwantedChars(UriInterface $uri): UriInterface
    {
        $removeUnwantedChars = function (?string $string) {
            if (null === $string) {
                return null;
            }
            return str_replace(["\x09", "\x0A", "\x0D", "\x0B", "\t", "\r", "\n"], '', $string);
        };

        return $uri
            ->withUserInfo($removeUnwantedChars($uri->getUserInfo()))
            ->withHost($removeUnwantedChars($uri->getHost()))
            ->withPath($removeUnwantedChars($uri->getPath()))
            ->withQuery($removeUnwantedChars($uri->getQuery()))
            ->withFragment($removeUnwantedChars($uri->getFragment()));
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function removeLeadingAndTrailingDots(UriInterface $uri): UriInterface
    {
        return $uri->withHost(
            trim($uri->getHost(), '.')
        );
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function replaceConsecutiveDotsWithASingleDot(UriInterface $uri): UriInterface
    {
        return $uri->withHost(
            preg_replace('/\.{2,}/', '.', $uri->getHost())
        );
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function normalizeHostname(UriInterface $uri): UriInterface
    {
        $hostname = strtolower($uri->getHost());

        $hostnameIP = is_numeric($hostname) ? ip2long(long2ip($hostname)) : ip2long($hostname);

        if (false !== $hostnameIP) {
            $hostname = long2ip($hostnameIP);
        }

        return $uri->withHost($hostname);
    }

    /**
     * @param UriInterface $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function normalizePath(UriInterface $uri): UriInterface
    {
        $path = $uri->getPath();
        $segments = explode('/', $path);
        $parts = [];
        foreach ($segments as $segment) {
            switch ($segment) {
                case '.':
                    // Don't need to do anything here
                    break;
                case '..':
                    array_pop($parts);
                    break;
                default:
                    $parts[] = $segment;
                    break;
            }
        }
        $path = implode('/', $parts);
        $path = preg_replace('#/{2,}#', '/', $path);
        if (0 !== strpos($path, '/')) {
            $path = '/' . $path;
        }
        return $uri->withPath($path);
    }
}
