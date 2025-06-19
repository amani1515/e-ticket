<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
 protected function passwordRules(): array
{
    return [
        'required',
        'string',
        'confirmed',
        Password::min(8)
            ->mixedCase()        // Must have upper and lower case
            ->letters()          // Must include at least one letter
            ->numbers()          // Must include at least one number
            ->symbols()          // Must include a special character (!@#$...)
            ->uncompromised(),   // Check against leaked passwords
    ];

}
}
