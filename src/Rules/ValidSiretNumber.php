<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Elegantly\Pappers\Facades\Pappers;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSiretNumber implements ValidationRule
{
    /**
     * @param  bool  $luhn  Whether the SIRET number must pass the Luhn check.
     * @param  bool  $found  Whether the SIRET number must exist in the database.
     * @param  bool  $active  Whether the SIRET number must correspond to an active entity.
     */
    public function __construct(
        public bool $luhn = true,
        public bool $found = true,
        public bool $active = true,
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) && ! is_int($value)) {
            $fail('pappers::validation.siret_format')->translate();

            return;
        }

        $siret = (string) $value;

        if (mb_strlen($siret) !== 14) {
            $fail('pappers::validation.siret_length')->translate();

            return;
        }

        $siren = mb_substr($siret, 0, 9);

        if (
            $this->luhn &&
            ! ValidLuhnSirenNumber::check($siren)
        ) {
            $fail('pappers::validation.siret_luhn')->translate();

            return;
        }

        $response = Pappers::france()->siret($siret);

        if (
            $this->found &&
            $response->failed()
        ) {
            $fail('pappers::validation.siret')->translate();

            return;
        }

        if (
            $this->active &&
            $response->json('entreprise_cessee')
        ) {
            $fail('pappers::validation.siret_active')->translate();

            return;
        }
    }
}
