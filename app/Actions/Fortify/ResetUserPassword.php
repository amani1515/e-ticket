<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must include at least one number.',
            'password.symbols' => 'Password must include at least one special character.',
            'password.uncompromised' => 'This password has appeared in a data leak. Please choose a different one.',
        ])->validate();


        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
