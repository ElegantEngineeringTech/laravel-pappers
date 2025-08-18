<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Elegantly\Pappers\Facades\Pappers;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSirenNumber implements ValidationRule
{
    /**
     * @param  bool  $luhn  Whether the SIREN number must pass the Luhn check.
     * @param  bool  $found  Whether the SIREN number must exist in the database.
     * @param  bool  $active  Whether the SIREN number must correspond to an active entity.
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
            $fail('pappers::validation.siren_format')->translate();

            return;
        }

        $siren = (string) $value;

        if (mb_strlen($siren) !== 9) {
            $fail('pappers::validation.siren_length')->translate();

            return;
        }

        if (
            $this->luhn &&
            ! ValidLuhnSirenNumber::check($siren)
        ) {
            $fail('pappers::validation.siren_luhn')->translate();

            return;
        }

        $response = Pappers::france()->siren($siren);

        if (
            $this->found &&
            $response->failed()
        ) {
            $fail('pappers::validation.siren')->translate();

            return;
        }

        if (
            $this->active &&
            $response->json('entreprise_cessee')
        ) {
            $fail('pappers::validation.siren_active')->translate();

            return;
        }
    }
}
