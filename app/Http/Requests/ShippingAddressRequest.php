<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingAddressRequest extends FormRequest
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
            'country_code' => ['required', 'string', 'exists:countries,code'],
            'full_name' => ['required', 'string'],
            'type' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'address1' => ['required', 'string'],
            'address2' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'primary' => ['required', 'boolean'],
            'delivery_instructions' => ['nullable', 'string'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'type' => 'shipping',
        ]);
    }
}
