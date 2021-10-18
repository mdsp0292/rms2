<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
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
            'street'    => ['required', 'max:150'],
            'city'      => ['required', 'max:50'],
            'state'     => ['required', 'max:50'],
            'country'   => ['required', 'max:2'],
            'post_code' => ['required', 'max:25'],
        ];
    }
}
