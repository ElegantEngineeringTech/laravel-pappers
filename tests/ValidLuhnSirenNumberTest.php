<?php

declare(strict_types=1);
use Elegantly\Pappers\Rules\ValidLuhnSirenNumber;

it('checks that a SIREN number respects the Luhn algorithm', function (string $siren, bool $expected) {

    expect(
        ValidLuhnSirenNumber::check($siren)
    )->toBe($expected);

})->with([
    ['897962361', true],
    ['939507851', true],
    ['939507752', true],
    ['123456789', false],
    ['000000000', false], // edge case
    ['939507753', false],
    ['897962362', false],
    ['897862361', false],
    ['abcdefghi', false],
    ['8979623612', false],
    ['0897962361', false],
]);
