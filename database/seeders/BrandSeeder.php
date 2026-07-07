<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'AURA Signature',
            'Bengal Heritage',
            'Dhakai Twist',
            'Jamdani Stories',
            'Murshidabad Silk',
            'Kashi Collection',
            'Banarasi Dreams',
            'Kanchipuram Treasure',
            'Paithani Legacy',
            'Patola Princess',
            'Sambalpore Roots',
            'Odisha Handloom',
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
                'slug' => Str::slug($brand),
                'description' => 'Premium '.$brand.' saree collection',
                'status' => true,
            ]);
        }
    }
}
