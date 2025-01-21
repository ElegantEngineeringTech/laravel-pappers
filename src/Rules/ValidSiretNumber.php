<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Elegantly\Pappers\Facades\Pappers;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSiretNumber implements ValidationRule
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
            $fail('pappers::validation.siret')->translate();

            return;
        }

        $siret = (string) $value;

        if (mb_strlen($siret) !== 14) {
            $fail('pappers::validation.siret_length')->translate();

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
