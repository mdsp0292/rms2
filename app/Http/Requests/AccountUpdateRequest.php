<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'max:100'],
            'email'     => ['required', 'max:50', 'email'],
            'phone'     => ['nullable', 'max:50'],
            'street'    => ['nullable', 'max:150'],
            'city'      => ['nullable', 'max:50'],
            'state'     => ['nullable', 'max:50'],
            'country'   => ['nullable', 'max:2'],
            'post_code' => ['nullable', 'max:25'],
        ];
    }
}
