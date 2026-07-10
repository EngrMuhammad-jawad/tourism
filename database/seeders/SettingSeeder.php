<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'general' => [
                'site_name' => 'UAE Tourism',
                'tagline' => 'Luxury Travel',
            ],
            'contact' => [
                'email' => 'info@uaetourism.example.com',
                'phone' => '+971 4 123 4567',
                'address' => 'Sheikh Zayed Road, Dubai, United Arab Emirates',
            ],
            'social' => [
                'facebook' => 'https://facebook.com/uaetourism',
                'instagram' => 'https://instagram.com/uaetourism',
                'twitter' => 'https://x.com/uaetourism',
                'youtube' => 'https://youtube.com/@uaetourism',
            ],
            'footer' => [
                'about_text' => [
                    'en' => 'Your official guide to exploring the beauty, luxury, and culture of the United Arab Emirates.',
                    'ar' => 'دليلك الرسمي لاستكشاف جمال وفخامة وثقافة الإمارات العربية المتحدة.',
                    'ru' => 'Ваш официальный гид по красоте, роскоши и культуре Объединённых Арабских Эмиратов.',
                ],
                'copyright' => '© 2026 UAE Tourism. All Rights Reserved.',
            ],
            'seo' => [
                'meta_title' => 'UAE Tourism | Luxury Travel',
                'meta_description' => 'Discover the UAE - Experience the perfect blend of modern luxury and rich cultural heritage.',
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                Setting::updateOrCreate(['group' => $group, 'key' => $key], ['value' => $value]);
            }
        }
    }
}
