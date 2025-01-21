<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Elegantly\Pappers\Facades\Pappers;

class ValidSiretNumber
{
    /**
     * @param  bool  $found  Indicates if the SIREN number must exist in the database.
     * @param  bool  $active  Indicates if the SIREN number must represent an active entity.
     */
    public function __construct(
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
            $fail('The :attribute is not a valid SIRET number.');
        }

        /**
         * @var string|int $value
         */
        $siret = (string) $value;

        if (mb_strlen($siret) !== 14) {
            $fail('The :attribute must be exactly 14 digits.');
        }

        $response = Pappers::france()->siret($siret);

        if (
            $this->found &&
            $response->failed()
        ) {
            $fail('The :attribute is not a valid SIRET number.');
        }

        if (
            $this->active &&
            $response->json('entreprise_cessee')
        ) {
            $fail('The :attribute is not associated with an active entity.');
        }
    }
}
