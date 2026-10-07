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
                'site_name' => 'Dubai Tour Book',
                'site_url' => 'https://dubaitourbook.com',
                'tagline' => 'Luxury Tours, Desert Safaris & VIP Experiences',
                'logo' => '/assets/images/logo.svg',
                'logo_icon' => '/assets/images/logo-icon.svg',
                'favicon' => '/favicon.svg',
            ],
            'contact' => [
                'email' => 'info@dubaitourbook.com',
                'support_email' => 'support@dubaitourbook.com',
                'phone' => '+971 4 321 8899',
                'whatsapp' => '+971 50 888 7766',
                'address' => 'Sheikh Mohammed bin Rashid Blvd, Downtown Dubai, United Arab Emirates',
                'working_hours' => '24/7 VIP Concierge & Booking Desk',
            ],
            'social' => [
                'facebook' => 'https://facebook.com/dubaitourbook',
                'instagram' => 'https://instagram.com/dubaitourbook',
                'twitter' => 'https://x.com/dubaitourbook',
                'youtube' => 'https://youtube.com/@dubaitourbook',
                'whatsapp' => 'https://wa.me/971508887766',
            ],
            'footer' => [
                'about_text' => [
                    'en' => 'Dubai Tour Book (dubaitourbook.com) is your premier luxury portal to experience Dubai’s iconic skyline, golden desert safaris, VIP yacht cruises, and 7-star Arabian hospitality.',
                    'ar' => 'دبي تور بوك (dubaitourbook.com) هي بوابتك الفاخرة لاكتشاف سحر دبي ورحلات السفاري الصحراوية وأرقى الفنادق واليخوت والتجارب السياحية الحصرية.',
                    'ru' => 'Dubai Tour Book (dubaitourbook.com) — ваш премиальный путеводитель по Дубаю: сафари по золотым барханам, роскошные яхты и VIP-впечатления.',
                ],
                'copyright' => '© 2026 Dubai Tour Book (dubaitourbook.com). All Rights Reserved.',
            ],
            'seo' => [
                'meta_title' => 'Dubai Tour Book | Luxury Tours, Desert Safaris & Dubai Experiences',
                'meta_description' => 'Book unforgettable Dubai tours, private desert safaris, Burj Khalifa tickets, luxury yachts, and customized holiday packages at dubaitourbook.com.',
                'meta_keywords' => 'Dubai tour book, Dubai tours, luxury Dubai travel, desert safari Dubai, Burj Khalifa tickets, Dubai yacht rental, UAE holiday packages',
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                Setting::updateOrCreate(['group' => $group, 'key' => $key], ['value' => $value]);
            }
        }
    }
}
