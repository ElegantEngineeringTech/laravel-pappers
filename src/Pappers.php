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
        /** @var string $version */
        $version = config('pappers.france.version') ?? 'v2';

        return new PappersFranceConnector(
            token: config()->string('pappers.france.token'),
            version: $version,
        );
    }

    public function international(): PappersInternationalConnector
    {/** @var string $version */
        $version = config('pappers.international.version') ?? 'v1';

        return new PappersInternationalConnector(
            token: config()->string('pappers.international.token'),
            version: $version,
        );
    }
}
