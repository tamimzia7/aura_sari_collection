<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = 'Premium '.fake()->unique()->words(2, true).' Saree';

        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'brand_id' => Brand::inRandomOrder()->first()?->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => 'SAR-'.fake()->unique()->bothify('####-????'),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 1000, 50000),
            'discount_price' => function (array $attributes) {
                return fake()->boolean(70) ? null : $attributes['price'] * 0.8;
            },
            'fabric' => fake()->randomElement(['Silk', 'Cotton', 'Georgette', 'Chiffon', 'Satin', 'Velvet', 'Linen', 'Net', 'Organza', 'Jacquard']),
            'occasion' => fake()->randomElement(['Casual', 'Formal', 'Party', 'Wedding', 'Festival', 'Office', 'Daily Wear', 'Evening']),
            'color' => fake()->randomElement(['Red', 'Blue', 'Green', 'Gold', 'Silver', 'Black', 'White', 'Pink', 'Purple', 'Orange', 'Yellow', 'Teal', 'Maroon', 'Navy', 'Emerald']),
            'pattern' => fake()->randomElement(['Solid', 'Printed', 'Embroidered', 'Handloom', 'Block Print', 'Digital Print', 'Zari', 'Stone Work']),
            'sizes' => fake()->randomElements(['S', 'M', 'L', 'XL', 'XXL'], fake()->numberBetween(2, 5)),
            'weight' => fake()->randomFloat(2, 0.3, 2.0),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'is_featured' => fake()->boolean(20),
            'is_new_arrival' => fake()->boolean(40),
            'is_best_selling' => fake()->boolean(20),
            'is_trending' => fake()->boolean(15),
            'is_discounted' => fake()->boolean(15),
            'status' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $count = fake()->numberBetween(3, 4);

            ProductImage::factory()->create([
                'product_id' => $product->id,
                'is_primary' => true,
                'sort_order' => 1,
            ]);

            for ($i = 2; $i <= $count; $i++) {
                ProductImage::factory()->create([
                    'product_id' => $product->id,
                    'is_primary' => false,
                    'sort_order' => $i,
                ]);
            }
        });
    }
}
