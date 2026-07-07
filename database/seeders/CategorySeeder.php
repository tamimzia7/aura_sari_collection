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
            ['name' => 'Silk Saree', 'description' => 'Elegant silk sarees for every occasion', 'sort_order' => 1],
            ['name' => 'Cotton Saree', 'description' => 'Comfortable cotton sarees for daily wear', 'sort_order' => 2],
            ['name' => 'Georgette Saree', 'description' => 'Lightweight georgette sarees with a flowy drape', 'sort_order' => 3],
            ['name' => 'Chiffon Saree', 'description' => 'Soft chiffon sarees with a sheer elegance', 'sort_order' => 4],
            ['name' => 'Satin Saree', 'description' => 'Lustrous satin sarees for a glossy finish', 'sort_order' => 5],
            ['name' => 'Velvet Saree', 'description' => 'Rich velvet sarees for winter weddings', 'sort_order' => 6],
            ['name' => 'Linen Saree', 'description' => 'Breathable linen sarees for casual elegance', 'sort_order' => 7],
            ['name' => 'Net Saree', 'description' => 'Modern net sarees for party wear', 'sort_order' => 8],
            ['name' => 'Organza Saree', 'description' => 'Crisp organza sarees with a royal look', 'sort_order' => 9],
            ['name' => 'Jacquard Saree', 'description' => 'Intricate jacquard weave sarees', 'sort_order' => 10],
            ['name' => 'Bridal Saree', 'description' => 'Exquisite bridal sarees for your special day', 'sort_order' => 11],
            ['name' => 'Daily Wear Saree', 'description' => 'Affordable sarees for everyday comfort', 'sort_order' => 12],
        ];

        foreach ($categories as $category) {
            $category['slug'] = Str::slug($category['name']);
            Category::create($category);
        }
    }
}
