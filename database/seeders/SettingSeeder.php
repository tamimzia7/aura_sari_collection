<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'AURA', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Premium Saree Collection', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'BDT', 'group' => 'general'],
            ['key' => 'theme_primary', 'value' => '#0a0a2e', 'group' => 'theme'],
            ['key' => 'theme_accent', 'value' => '#d4af37', 'group' => 'theme'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
