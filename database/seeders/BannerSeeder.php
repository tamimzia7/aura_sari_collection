<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Elegance Redefined',
                'subtitle' => 'Discover the finest collection of premium handcrafted sarees',
                'image' => 'https://placehold.co/1920x600/0a0a1a/d4af37?text=Elegance+Redefined',
                'button_text' => 'Shop Now',
                'link' => '/collection',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'New Collection 2026',
                'subtitle' => 'Explore our latest arrivals with traditional craftsmanship',
                'image' => 'https://placehold.co/1920x600/0a0a1a/d4af37?text=New+Collection+2026',
                'button_text' => 'Shop Now',
                'link' => '/collection',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Festival Special',
                'subtitle' => 'Shop the exclusive festival collection at special prices',
                'image' => 'https://placehold.co/1920x600/0a0a1a/d4af37?text=Festival+Special',
                'button_text' => 'Shop Now',
                'link' => '/collection',
                'sort_order' => 3,
                'status' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title'], 'sort_order' => $banner['sort_order']],
                $banner
            );
        }
    }
}
