<?php

namespace App\Http\Requests;

use App\Models\Address;
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
            'address_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === 'new') {
                        return;
                    }
                    if (! Address::where('id', $value)->where('user_id', auth()->id())->exists()) {
                        $fail('The selected shipping address is invalid.');
                    }
                },
            ],
            'payment_method' => ['required', 'string', 'in:cod,bkash,nagad,rocket'],
            'notes' => ['nullable', 'string', 'max:500'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
        ];

        if ($this->address_id === 'new') {
            $rules['shipping_name'] = ['required', 'string', 'max:255'];
            $rules['shipping_phone'] = ['required', 'string', 'max:20'];
            $rules['shipping_address_line1'] = ['required', 'string', 'max:500'];
            $rules['shipping_city'] = ['required', 'string', 'max:255'];
            $rules['shipping_state'] = ['required', 'string', 'max:255'];
            $rules['shipping_zip'] = ['required', 'string', 'max:20'];
            $rules['shipping_address_line2'] = ['nullable', 'string', 'max:500'];
        }

        if ($this->payment_method !== 'cod') {
            $rules['transaction_id'] = ['required', 'string', 'max:255'];
            $rules['sender_number'] = ['nullable', 'string', 'max:50'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'address_id.required' => 'Please select a shipping address.',
            'transaction_id.required' => 'Transaction ID is required for advance payment.',
            'shipping_name.required' => 'Please enter your full name.',
            'shipping_phone.required' => 'Please enter your phone number.',
            'shipping_address_line1.required' => 'Please enter your address.',
            'shipping_city.required' => 'Please enter your city.',
            'shipping_state.required' => 'Please enter your state.',
            'shipping_zip.required' => 'Please enter your ZIP code.',
        ];
    }
}
