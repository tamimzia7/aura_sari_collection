<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'AURA - Premium Saree Collection', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Discover the finest collection of premium sarees', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'AURA is a premium e-commerce platform offering an exquisite collection of handcrafted sarees from across India and Bangladesh. From luxurious Banarasi silks to comfortable cotton sarees, we bring you the finest craftsmanship at your fingertips.', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'INR', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => '₹', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hello@aurasaree.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+91 98765 43210', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '123 Fashion Street, Mumbai, India', 'group' => 'contact'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/aurasaree', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/aurasaree', 'group' => 'social'],
            ['key' => 'social_whatsapp', 'value' => '+919876543210', 'group' => 'social'],
            ['key' => 'footer_text', 'value' => '© 2026 AURA. All rights reserved.', 'group' => 'appearance'],
            ['key' => 'theme_primary', 'value' => '#0a0a1a', 'group' => 'appearance'],
            ['key' => 'theme_accent', 'value' => '#d4af37', 'group' => 'appearance'],
            ['key' => 'payment_bkash_number', 'value' => '01XXXXXXXXX', 'group' => 'payment'],
            ['key' => 'payment_nagad_number', 'value' => '01XXXXXXXXX', 'group' => 'payment'],
            ['key' => 'payment_rocket_number', 'value' => '01XXXXXXXXX', 'group' => 'payment'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
