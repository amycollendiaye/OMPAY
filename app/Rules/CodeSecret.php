<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CodeSecret implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Vérifie que c'est exactement 4 chiffres
        if (!preg_match('/^\d{4}$/', $value)) {
            $fail('Le :attribute doit contenir exactement 4 chiffres.');
            return;
        }

        // Interdit certains codes faibles
        $forbidden = ['0000', '1234', '1111', '9999'];
        if (in_array($value, $forbidden)) {
            $fail('Le :attribute est trop simple, veuillez en choisir un autre.');
        }
    }
}
