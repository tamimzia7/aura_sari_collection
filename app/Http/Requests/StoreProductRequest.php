<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'unique:products,slug'],
            'sku' => ['required', 'unique:products,sku'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'fabric' => ['nullable', 'string'],
            'occasion' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'is_featured' => ['boolean'],
            'is_new_arrival' => ['boolean'],
            'is_best_selling' => ['boolean'],
            'status' => ['boolean'],
        ];
    }
}
