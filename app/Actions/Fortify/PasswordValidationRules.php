<?php

namespace App\Actions\Fortify;

//use Laravel\Fortify\Rules\Password;
use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return [
            'required',
            'string',
            Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(),
                //->uncompromised(),
            'confirmed'
        ];
    }
}
