<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string'],
        ]);

        $groupMap = [
            'site_name' => 'general',
            'site_tagline' => 'general',
            'site_description' => 'general',
            'currency' => 'general',
            'currency_symbol' => 'general',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_address' => 'contact',
            'social_facebook' => 'social',
            'social_instagram' => 'social',
            'social_whatsapp' => 'social',
            'social_youtube' => 'social',
            'logo_path' => 'appearance',
            'favicon_path' => 'appearance',
            'footer_text' => 'appearance',
        ];

        foreach ($request->settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $groupMap[$key] ?? 'general'],
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }
}
