<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    use PasswordValidationRules;


    /**
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function showWelcomeForm(Request $request, User $user): Response
    {
        return Inertia::render('Auth/Register', [
            'email'      => $user->email,
            'requestUri' => $request->getRequestUri()
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function savePassword(Request $request, User $user): RedirectResponse
    {
        Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
