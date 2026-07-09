<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Silk Sarees', 'description' => 'Luxurious pure silk sarees with intricate zari work and timeless elegance for weddings and special occasions.', 'sort_order' => 1],
            ['name' => 'Cotton Sarees', 'description' => 'Breathable and comfortable cotton sarees perfect for daily wear, summers, and casual occasions.', 'sort_order' => 2],
            ['name' => 'Bridal Sarees', 'description' => 'Exquisite bridal sarees featuring rich embroidery, heavy zari work, and regal designs for your special day.', 'sort_order' => 3],
            ['name' => 'Designer Sarees', 'description' => 'Contemporary designer sarees blending traditional artistry with modern aesthetics.', 'sort_order' => 4],
            ['name' => 'Casual Sarees', 'description' => 'Effortlessly stylish casual sarees for everyday elegance and comfort.', 'sort_order' => 5],
            ['name' => 'Party Wear Sarees', 'description' => 'Glamorous party wear sarees with sequins, embellishments, and vibrant colors.', 'sort_order' => 6],
            ['name' => 'Festival Collection', 'description' => 'Celebrate festivals in style with our exclusive range of festive sarees.', 'sort_order' => 7],
            ['name' => 'Office Wear Sarees', 'description' => 'Professional and polished sarees perfect for the modern working woman.', 'sort_order' => 8],
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            $category['image'] = 'https://placehold.co/400x500/0a0a1a/d4af37?text='.urlencode($category['name']);
            $category['status'] = true;

            Category::updateOrCreate(
                ['slug' => $slug],
                $category
            );
        }
    }
}
