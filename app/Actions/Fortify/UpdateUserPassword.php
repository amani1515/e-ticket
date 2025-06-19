<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
public function update(User $user, array $input): void
{
    Validator::make($input, [
        'current_password' => ['required', 'string', 'current_password:web'],
        'password' => $this->passwordRules(),
    ], [
        'current_password.current_password' => __('The provided password does not match your current password.'),
        'password.min' => __('Password must be at least 8 characters.'),
        'password.mixed' => __('Password must contain both uppercase and lowercase letters.'),
        'password.numbers' => __('Password must include at least one number.'),
        'password.symbols' => __('Password must include at least one special character.'),
        'password.uncompromised' => __('This password has appeared in a data leak. Please choose a different one.'),
    ])->validateWithBag('updatePassword');

    $user->forceFill([
        'password' => Hash::make($input['password']),
    ])->save();
}

}
