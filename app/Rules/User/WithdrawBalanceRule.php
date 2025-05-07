<?php

namespace App\Rules\User;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithdrawBalanceRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = user();

        if ($user->balance < $value) {
            $fail('You do not have enough balance to withdraw.');
        }
    }
}
