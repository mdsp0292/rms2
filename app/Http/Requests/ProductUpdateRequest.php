<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'            => ['required', 'max:200'],
            'amount'          => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'reseller_amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'active'          => ['required', 'boolean'],
        ];
    }
}
