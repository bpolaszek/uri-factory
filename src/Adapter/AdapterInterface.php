<?php

namespace BenTools\UriFactory\Adapter;

use BenTools\UriFactory\UriFactoryInterface;

interface AdapterInterface extends UriFactoryInterface
{

    /**
     * Check if the dependency is installed or not.
     *
     * @return bool
     */
    public static function isInstalled(): bool;
}
