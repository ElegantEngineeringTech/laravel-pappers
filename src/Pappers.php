<?php

declare(strict_types=1);

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
            token: config()->string('pappers.france.token'),
            version: config()->string('pappers.france.version', 'v2'),
        );
    }

    public function international(): PappersInternationalConnector
    {
        return new PappersInternationalConnector(
            token: config()->string('pappers.international.token'),
            version: config()->string('pappers.international.version', 'v1'),
        );
    }
}
