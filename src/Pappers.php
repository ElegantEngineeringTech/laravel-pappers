<?php

namespace Elegantly\Pappers;

use Elegantly\Pappers\Integrations\France\PappersFranceConnector;
use Elegantly\Pappers\Integrations\International\PappersInternationalConnector;

class Pappers
{
    public function __construct()
    {
        //
    }

    public function france(): PappersFranceConnector
    {
        return new PappersFranceConnector(
            token: config('pappers.france.token'),
            version: config('pappers.france.version') ?? 'v2',
        );
    }

    public function international(): PappersInternationalConnector
    {
        return new PappersInternationalConnector(
            token: config('pappers.international.token'),
            version: config('pappers.international.version') ?? 'v1',
        );
    }
}
