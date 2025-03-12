<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stripeToken' => 'required',
            'amount' => 'required|numeric|min:1',

            'address_1'=>'nullable',
            'address_2'=>'nullable',
            'phone_number'=>'nullable',
            'street_name'=>'nullable',
            'building_number'=>'nullable',
            'floor_number'=>'nullable',
            'appartment_number'=>'nullable',
            'note'=>'nullable',

        ];
    }
}
