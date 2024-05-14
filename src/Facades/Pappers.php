<?php

namespace Finller\Pappers\Facades;

use Finller\Pappers\Integrations\Pappers\PappersConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PappersConnector client()
 *
 * @see \Finller\Pappers\Pappers
 */
class Pappers extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Finller\Pappers\Pappers::class;
    }
}
