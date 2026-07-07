<?php

namespace Database\Factories;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        return [
            'image_path' => 'https://picsum.photos/seed/'.fake()->uuid().'/600/800',
            'is_primary' => false,
            'sort_order' => 0,
        ];
    }
}
