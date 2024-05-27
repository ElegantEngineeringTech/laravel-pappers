<?php

namespace Elegantly\Pappers\Facades;

use Elegantly\Pappers\Integrations\Pappers\PappersConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PappersConnector client()
 *
 * @see \Elegantly\Pappers\Pappers
 */
class Pappers extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\Pappers\Pappers::class;
    }
}
