<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'shipping_address_id' => ['required', 'exists:addresses,id'],
            'billing_address_id' => ['required', 'exists:addresses,id'],
            'payment_method' => ['required', 'string', 'in:cod,bkash,nagad,rocket'],
            'notes' => ['nullable', 'string', 'max:500'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
        ];

        if ($this->payment_method !== 'cod') {
            $rules['transaction_id'] = ['required', 'string', 'max:255'];
            $rules['sender_number'] = ['nullable', 'string', 'max:50'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'transaction_id.required' => 'Transaction ID is required for advance payment.',
        ];
    }
}
