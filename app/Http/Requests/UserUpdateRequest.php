<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'max:50'],
            'last_name'  => ['required', 'max:50'],
            'email'      => [
                'required', 'max:50', 'email',
                Rule::unique('users')->ignore($this->route('user')->id)
            ],
            'type'       => ['required', Rule::in(User::USER_TYPE_ADMIN, User::USER_TYPE_RESELLER, User::USER_TYPE_REFERRER)],
        ];
    }

}
