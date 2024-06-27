<?php

namespace Elegantly\Pappers\Facades;

use Elegantly\Pappers\Integrations\France\PappersFranceConnector;
use Elegantly\Pappers\Integrations\International\PappersInternationalConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PappersFranceConnector france()
 * @method static PappersInternationalConnector international()
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
