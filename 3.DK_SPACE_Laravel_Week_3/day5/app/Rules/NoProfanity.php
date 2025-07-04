<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoProfanity implements ValidationRule
{

    protected array $blacklist = [
            'abc', 'dm',
        ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
            $text = strtolower($value);

            foreach ($this->blacklist as $badword) {
            if (str_contains($text, $badword)) {
            $fail('No profanity allowed in '. '.');
            return;
            }
    }
    }
}
