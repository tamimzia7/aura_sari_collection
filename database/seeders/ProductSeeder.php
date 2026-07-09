<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sareeNames = [
            'Katan Silk Saree', 'Banarasi Brocade Saree', 'Jamdani Cotton Saree',
            'Tangail Cotton Saree', 'Rajshahi Silk Saree', 'Mughal Embroidered Saree',
            'Benarasi Georgette Saree', 'Chiffon Floral Saree', 'Kanchipuram Silk Saree',
            'Maheshwari Cotton Saree', 'Patola Silk Saree', 'Bandhani Leheriya Saree',
            'Chanderi Silk Saree', 'Tussar Silk Saree', 'Mysore Silk Saree',
            'Kosa Silk Saree', 'Ilkal Saree', 'Pochampally Ikat Saree',
            'Gadwal Silk Saree', 'Venkatagiri Cotton Saree', 'Narayanpet Saree',
            'Kasavu Kerala Saree', 'Sambalpuri Cotton Saree', 'Bomkai Silk Saree',
            'Kota Doria Saree', 'Bhagalpuri Silk Saree', 'Dhakai Jamdani Saree',
            'Nakshi Katha Cotton Saree', 'Murshidabad Silk Saree', 'Baluchari Silk Saree',
            'Paithani Silk Saree', 'Gota Patti Saree', 'Leheriya Saree',
            'Phulkari Saree', 'Bagru Print Saree', 'Dabu Print Saree',
            'Kalamkari Cotton Saree', 'Linen Silk Saree', 'Tissue Silk Saree',
            'Half Silk Saree', 'Kanjivaram Silk Saree', 'Chettinad Cotton Saree',
            'Kerala Set Mundu Saree', 'Korvai Silk Saree', 'Sungudi Cotton Saree',
            'Himru Silk Saree', 'Patan Patola Saree', 'Phesta Silk Saree',
            'Lambadi Embroidery Saree', 'Toda Embroidery Saree',
        ];

        $fabrics = ['Silk', 'Cotton', 'Georgette', 'Chiffon', 'Satin', 'Velvet', 'Linen', 'Net', 'Organza', 'Jacquard', 'Tussar', 'Katan', 'Brocade', 'Muslin', 'Tissue'];
        $occasions = ['Casual', 'Formal', 'Party', 'Wedding', 'Festival', 'Office', 'Daily Wear', 'Evening', 'Bridal', 'Reception'];
        $colors = ['Red', 'Blue', 'Green', 'Gold', 'Silver', 'Black', 'White', 'Pink', 'Purple', 'Orange', 'Yellow', 'Teal', 'Maroon', 'Navy', 'Emerald', 'Peach', 'Lavender', 'Coral', 'Mint', 'Rose'];
        $patterns = ['Solid', 'Printed', 'Embroidered', 'Handloom', 'Block Print', 'Digital Print', 'Zari', 'Stone Work', 'Ikkat', 'Tie & Dye', 'Kalamkari', 'Dabu', 'Leheriya', 'Bandhani', 'Butti'];
        $descriptions = [
            'Handwoven with precision and care, this saree showcases the finest craftsmanship passed down through generations.',
            'Featuring intricate traditional motifs and a luxurious texture, this saree is perfect for special occasions.',
            'Crafted from premium quality fabric, this saree offers a perfect blend of comfort and elegance.',
            'This exquisite piece features delicate embroidery and a rich color palette that exudes sophistication.',
            'A stunning addition to your wardrobe, this saree combines traditional artistry with contemporary styling.',
            'Each thread tells a story in this meticulously handcrafted saree, a testament to skilled artisanship.',
            'Drape yourself in elegance with this beautiful saree featuring timeless patterns and a graceful fall.',
            'This saree embodies the rich textile heritage of India with its authentic weaving techniques and fine detailing.',
        ];
        $shortDescriptions = [
            'Handwoven premium quality saree with intricate detailing.',
            'Elegant saree featuring traditional motifs and rich textures.',
            'Beautifully crafted saree perfect for weddings and celebrations.',
            'Lightweight and comfortable saree for everyday elegance.',
            'Exquisite saree with fine embroidery and vibrant colors.',
            'Premium quality fabric with a smooth and graceful drape.',
            'Timeless design showcasing masterful artisanal craftsmanship.',
            'Stunning piece with delicate patterns and a luxurious finish.',
        ];

        $allIndexes = range(0, 149);
        shuffle($allIndexes);

        $featuredSelection = array_slice($allIndexes, 0, 30);
        $newArrivalSelection = array_slice($allIndexes, 30, 50);
        $trendingSelection = array_slice($allIndexes, 80, 25);
        $bestSellingSelection = array_slice($allIndexes, 105, 20);

        for ($i = 0; $i < 150; $i++) {
            $nameIndex = $i % count($sareeNames);
            $suffix = intdiv($i, count($sareeNames)) + 1;
            $name = $sareeNames[$nameIndex].' '.str_pad($suffix, 2, '0', STR_PAD_LEFT);
            $slug = Str::slug($name);

            $price = fake()->randomFloat(0, 1500, 50000);
            $hasDiscount = fake()->boolean(40);
            $discountPrice = $hasDiscount ? round($price * (1 - fake()->randomFloat(2, 0.10, 0.30)), 0) : null;

            $stockQty = fake()->numberBetween(0, 100);
            $stockStatus = $stockQty > 0 ? 'in_stock' : 'out_of_stock';

            $categoryId = fake()->numberBetween(1, 8);
            $brandId = fake()->numberBetween(1, 12);
            $collectionId = fake()->boolean(70) ? fake()->numberBetween(1, 8) : null;

            $mainImage = 'https://placehold.co/600x800/0a0a1a/d4af37?text='.urlencode($name);

            $existingProduct = Product::where('slug', $slug)->first();
            if ($existingProduct) {
                continue;
            }

            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'collection_id' => $collectionId,
                'product_code' => 'PRD-'.strtoupper(Str::random(8)),
                'name' => $name,
                'slug' => Str::slug($name),
                'sku' => 'SAR-'.str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'description' => fake()->randomElement($descriptions)."\n\n".fake()->randomElement($descriptions)."\n\n".fake()->randomElement($descriptions),
                'short_description' => fake()->randomElement($shortDescriptions),
                'price' => $price,
                'discount_price' => $discountPrice,
                'fabric' => fake()->randomElement($fabrics),
                'occasion' => fake()->randomElement($occasions),
                'color' => fake()->randomElement($colors),
                'pattern' => fake()->randomElement($patterns),
                'sizes' => fake()->randomElements(['S', 'M', 'L', 'XL', 'XXL'], fake()->numberBetween(2, 5)),
                'weight' => fake()->randomFloat(2, 0.3, 2.0),
                'stock_quantity' => $stockQty,
                'stock_status' => $stockStatus,
                'is_featured' => in_array($i, $featuredSelection),
                'is_new_arrival' => in_array($i, $newArrivalSelection),
                'is_trending' => in_array($i, $trendingSelection),
                'is_best_selling' => in_array($i, $bestSellingSelection),
                'status' => $i < 140,
                'meta_title' => $name.' - AURA Premium Saree Collection',
                'meta_description' => 'Shop '.$name.' from AURA. '.fake()->randomElement($shortDescriptions),
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $mainImage,
                'is_primary' => true,
                'sort_order' => 1,
            ]);

            $galleryCount = fake()->numberBetween(3, 4);
            for ($j = 2; $j <= $galleryCount; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'https://placehold.co/600x800/0a0a1a/d4af37?text='.urlencode($name).'+View+'.$j,
                    'is_primary' => false,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
