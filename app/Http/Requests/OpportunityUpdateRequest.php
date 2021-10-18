<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OpportunityUpdateRequest extends FormRequest
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
            //'name'                => 'required|max:100',
            //'account_id'          => ['required', Rule::exists('accounts', 'id')],
            //'product_id'          => ['required', Rule::exists('products', 'id')],
            'sales_stage'         => 'required|numeric|between:1,6',
            'amount'              => 'required|numeric',
            'referral_percentage' => 'required|numeric',
            'referral_amount'     => 'required|numeric',
            'referral_start_date' => 'required|date',
            'sale_start'          => 'nullable|date',
            //'sale_end'            => 'nullable|date',
        ];
    }
}
