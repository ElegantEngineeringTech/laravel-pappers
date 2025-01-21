<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Elegantly\Pappers\Facades\Pappers;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSirenNumber implements ValidationRule
{
    /**
     * @param  bool  $found  Indicates if the SIREN number must exist in the database.
     * @param  bool  $active  Indicates if the SIREN number must represent an active entity.
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

        if ($this->luhn) {
            (new ValidLuhnSirenNumber)->validate($attribute, $value, $fail);
        }

        if (! is_string($value) && ! is_int($value)) {
            $fail('pappers::validation.siren')->translate();
        }

        /**
         * @var string|int $value
         */
        $siren = (string) $value;

        if (mb_strlen($siren) !== 9) {
            $fail('pappers::validation.siren_length')->translate();
        }

        $response = Pappers::france()->siren($siren);

        if (
            $this->found &&
            $response->failed()
        ) {
            $fail('pappers::validation.siren')->translate();
        }

        if (
            $this->active &&
            $response->json('entreprise_cessee')
        ) {
            $fail('pappers::validation.siren_active')->translate();
        }
    }
}
