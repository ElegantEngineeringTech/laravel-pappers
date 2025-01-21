<?php

declare(strict_types=1);

namespace Elegantly\Pappers\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidLuhnSirenNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
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

        if (! static::check($siren)) {
            $fail('pappers::validation.siren')->translate();
        }
    }

    public static function checksum(int|string $siren): int
    {
        if (! is_numeric($siren)) {
            throw new \InvalidArgumentException(__FUNCTION__.' can only accept numeric values.');
        }

        $value = (string) $siren;

        $length = mb_strlen($value);
        $parity = $length % 2;
        $sum = 0;

        for ($i = $length - 1; $i >= 0; $i--) {
            // Extract a character from the value.
            $char = (int) $value[$i];
            if ($i % 2 != $parity) {
                $char *= 2;
                if ($char > 9) {
                    $char -= 9;
                }
            }
            // Add the character to the sum of characters.
            $sum += $char;
        }

        // Return the value of the sum multiplied by 9 and then modulus 10.
        return ($sum * 9) % 10;
    }

    public static function extractValue(string $siren): string
    {
        return mb_substr($siren, 0, -1);
    }

    public static function extractChecksum(string $siren): int
    {
        return (int) mb_substr($siren, -1);
    }

    public static function check(string $siren): bool
    {

        if (! is_numeric($siren)) {
            return false;
        }

        if (mb_strlen($siren) !== 9) {
            return false;
        }

        if ($siren === '000000000') {
            return false;
        }

        $extractedValue = static::extractValue($siren);

        return static::extractChecksum($siren) == static::checksum($extractedValue);
    }
}
