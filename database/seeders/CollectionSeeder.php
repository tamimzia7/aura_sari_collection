<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            ['name' => 'New Arrival', 'description' => 'Discover our latest saree arrivals featuring contemporary designs and traditional craftsmanship.', 'sort_order' => 1],
            ['name' => 'Trending', 'description' => 'Explore the most popular saree styles that everyone is talking about this season.', 'sort_order' => 2],
            ['name' => 'Wedding Collection', 'description' => 'Exquisite bridal and wedding guest sarees for your special celebrations.', 'sort_order' => 3],
            ['name' => 'Silk Collection', 'description' => 'Luxurious pure silk sarees with intricate zari work and timeless elegance.', 'sort_order' => 4],
            ['name' => 'Cotton Collection', 'description' => 'Breathable and comfortable cotton sarees perfect for daily wear and casual occasions.', 'sort_order' => 5],
            ['name' => 'Jamdani Collection', 'description' => 'Traditional handwoven Jamdani sarees showcasing fine muslin craftsmanship.', 'sort_order' => 6],
            ['name' => 'Banarasi Collection', 'description' => 'Opulent Banarasi silk sarees with rich brocade patterns and gold zari.', 'sort_order' => 7],
            ['name' => 'Katan Collection', 'description' => 'Pure Katan silk sarees known for their durability, sheen, and intricate weaving.', 'sort_order' => 8],
        ];

        foreach ($collections as $collection) {
            $slug = Str::slug($collection['name']);
            $collection['image'] = 'https://placehold.co/400x500/0a0a1a/d4af37?text='.urlencode($collection['name']);
            $collection['status'] = true;

            Collection::updateOrCreate(
                ['slug' => $slug],
                $collection
            );
        }
    }
}
