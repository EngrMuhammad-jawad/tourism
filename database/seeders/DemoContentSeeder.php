<?php

namespace Database\Seeders;

use App\Enums\ModerationStatus;
use App\Enums\TransportType;
use App\Models\Album;
use App\Models\Amenity;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Lang;

class DemoContentSeeder extends Seeder
{
    /**
     * Recreates the original static site's content in the database
     * (EN/AR/RU translations come from the lang/*.json files) and adds
     * enough extra records to exercise every module.
     */
    public function run(): void
    {
        $this->seedDestinations();
        $this->seedPackages();
        $this->seedHotels();
        $this->seedTransports();
        $this->seedTestimonials();
        $this->seedFaqs();
        $this->seedGallery();
    }

    /**
     * Translations for one lang/*.json key in all supported locales.
     *
     * @return array<string, string>
     */
    private function trans(string $key): array
    {
        return collect(array_keys(config('localization.supported')))
            ->mapWithKeys(fn (string $locale) => [$locale => Lang::get($key, [], $locale)])
            ->all();
    }

    private function seedDestinations(): void
    {
        $destinations = [
            ['slug' => 'dubai', 'key' => 'dubai', 'city' => 'Dubai', 'image' => 'dubai.jpg', 'lat' => 25.2048, 'lng' => 55.2708],
            ['slug' => 'abu-dhabi', 'key' => 'abu_dhabi', 'city' => 'Abu Dhabi', 'image' => 'abu_dhabi.jpg', 'lat' => 24.4539, 'lng' => 54.3773],
            ['slug' => 'sharjah', 'key' => 'sharjah', 'city' => 'Sharjah', 'image' => 'sharjah.jpg', 'lat' => 25.3463, 'lng' => 55.4209],
            ['slug' => 'ras-al-khaimah', 'key' => 'rak', 'city' => 'Ras Al Khaimah', 'image' => 'rak.jpg', 'lat' => 25.7895, 'lng' => 55.9432],
        ];

        foreach ($destinations as $order => $data) {
            $destination = Destination::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $this->trans($data['key'].'_title'),
                    'description' => $this->trans($data['key'].'_desc'),
                    'country' => 'United Arab Emirates',
                    'city' => $data['city'],
                    'map_lat' => $data['lat'],
                    'map_lng' => $data['lng'],
                    'is_featured' => true,
                    'status' => true,
                    'sort_order' => $order,
                ]
            );

            if (! $destination->hasMedia('featured')) {
                $destination->addMedia(public_path('assets/images/'.$data['image']))
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }
        }
    }

    private function seedPackages(): void
    {
        $packages = [
            [
                'slug' => 'burj-khalifa-at-the-top', 'key' => 'tour_1', 'destination' => 'dubai',
                'image' => 'tour_burj.jpg', 'price' => 45, 'days' => 1,
            ],
            [
                'slug' => 'sheikh-zayed-grand-mosque', 'key' => 'tour_2', 'destination' => 'abu-dhabi',
                'image' => 'tour_mosque.jpg', 'price' => 0, 'days' => 1,
            ],
            [
                'slug' => 'jebel-jais-zipline', 'key' => 'tour_3', 'destination' => 'ras-al-khaimah',
                'image' => 'tour_jais.jpg', 'price' => 80, 'days' => 1,
            ],
            [
                'slug' => 'dubai-frame', 'key' => 'tour_4', 'destination' => 'dubai',
                'image' => 'tour_frame.jpg', 'price' => 15, 'days' => 1,
            ],
        ];

        foreach ($packages as $data) {
            $destination = Destination::where('slug', $data['destination'])->first();

            $package = TourPackage::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'destination_id' => $destination->id,
                    'name' => $this->trans($data['key'].'_title'),
                    'summary' => ['en' => 'One of the most popular experiences in the UAE.'],
                    'description' => ['en' => 'Enjoy a memorable experience with hotel pickup, a professional guide and skip-the-line access. Suitable for families, couples and solo travellers alike.'],
                    'price' => $data['price'],
                    'duration_days' => $data['days'],
                    'duration_nights' => 0,
                    'max_guests' => 20,
                    'included_services' => ['en' => ['Hotel pickup & drop-off', 'Professional guide', 'Entry tickets']],
                    'excluded_services' => ['en' => ['Personal expenses', 'Meals unless stated']],
                    'available_from' => now()->startOfYear(),
                    'available_to' => now()->addYear(),
                    'is_featured' => true,
                    'status' => true,
                ]
            );

            if (! $package->hasMedia('featured')) {
                $package->addMedia(public_path('assets/images/'.$data['image']))
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }

            if ($package->itineraries()->count() === 0) {
                $package->itineraries()->create([
                    'day_number' => 1,
                    'title' => ['en' => 'Tour day'],
                    'description' => ['en' => 'Pickup, guided experience and return transfer.'],
                ]);
            }
        }
    }

    private function seedHotels(): void
    {
        $amenities = collect(['Free WiFi', 'Swimming Pool', 'Spa', 'Gym', 'Restaurant', 'Beach Access', 'Airport Shuttle', 'Kids Club'])
            ->map(fn (string $name) => Amenity::firstOrCreate(
                ['name->en' => $name],
                ['name' => ['en' => $name], 'icon' => null]
            ));

        $hotels = [
            ['slug' => 'palm-royale-resort', 'name' => 'Palm Royale Resort', 'destination' => 'dubai', 'stars' => 5, 'image' => 'dubai.jpg'],
            ['slug' => 'corniche-grand-hotel', 'name' => 'Corniche Grand Hotel', 'destination' => 'abu-dhabi', 'stars' => 5, 'image' => 'abu_dhabi.jpg'],
            ['slug' => 'heritage-boutique-stay', 'name' => 'Heritage Boutique Stay', 'destination' => 'sharjah', 'stars' => 4, 'image' => 'sharjah.jpg'],
            ['slug' => 'jais-mountain-lodge', 'name' => 'Jais Mountain Lodge', 'destination' => 'ras-al-khaimah', 'stars' => 4, 'image' => 'rak.jpg'],
        ];

        foreach ($hotels as $data) {
            $destination = Destination::where('slug', $data['destination'])->first();

            $hotel = Hotel::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'destination_id' => $destination->id,
                    'name' => ['en' => $data['name']],
                    'star_rating' => $data['stars'],
                    'description' => ['en' => 'World-class hospitality with stunning views, fine dining and premium service.'],
                    'address' => $destination->city.', United Arab Emirates',
                    'status' => true,
                ]
            );

            if (! $hotel->hasMedia('featured')) {
                $hotel->addMedia(public_path('assets/images/'.$data['image']))
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }

            $hotel->amenities()->sync($amenities->random(5)->pluck('id'));

            if ($hotel->rooms()->count() === 0) {
                $hotel->rooms()->createMany([
                    ['name' => ['en' => 'Deluxe Room'], 'price_per_night' => 180, 'capacity' => 2, 'quantity' => 20, 'status' => true],
                    ['name' => ['en' => 'Executive Suite'], 'price_per_night' => 420, 'capacity' => 4, 'quantity' => 8, 'status' => true],
                ]);
            }
        }
    }

    private function seedTransports(): void
    {
        $transports = [
            ['slug' => 'luxury-sedan', 'name' => 'Luxury Sedan', 'type' => TransportType::Car, 'capacity' => 3, 'price' => 120],
            ['slug' => 'family-van', 'name' => 'Family Van', 'type' => TransportType::Van, 'capacity' => 7, 'price' => 180],
            ['slug' => 'tour-coach', 'name' => 'Tour Coach', 'type' => TransportType::Bus, 'capacity' => 45, 'price' => 450],
            ['slug' => 'domestic-flight', 'name' => 'Domestic Flight', 'type' => TransportType::Flight, 'capacity' => 150, 'price' => 250],
            ['slug' => 'airport-pickup', 'name' => 'Airport Pickup', 'type' => TransportType::Pickup, 'capacity' => 3, 'price' => 60],
        ];

        foreach ($transports as $data) {
            Transport::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'type' => $data['type'],
                    'name' => ['en' => $data['name']],
                    'description' => ['en' => 'Comfortable, air-conditioned and driven by licensed professionals.'],
                    'capacity' => $data['capacity'],
                    'price' => $data['price'],
                    'price_unit' => $data['type'] === TransportType::Flight ? 'per_person' : 'per_day',
                    'status' => true,
                ]
            );
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['key' => 'test_1', 'nameKey' => 'test_name_1', 'name' => 'Sarah T.', 'country' => 'United Kingdom'],
            ['key' => 'test_2', 'nameKey' => 'test_name_2', 'name' => 'Michael R.', 'country' => 'United States'],
        ];

        foreach ($testimonials as $data) {
            Testimonial::firstOrCreate(
                ['name' => $data['name']],
                [
                    'country' => $data['country'],
                    'rating' => 5,
                    'content' => trim(Lang::get($data['key'], [], 'en'), '"'),
                    'status' => ModerationStatus::Approved,
                ]
            );
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'q' => 'Do I need a visa to visit the UAE?',
                'a' => 'Citizens of many countries receive a visa on arrival. Check with your local UAE embassy or your airline before travelling.',
            ],
            [
                'q' => 'What is the best time to visit?',
                'a' => 'November to March offers the most pleasant weather, with temperatures between 20°C and 30°C.',
            ],
            [
                'q' => 'Can I cancel my booking?',
                'a' => 'Yes — bookings can be cancelled free of charge from your dashboard while they are pending or approved.',
            ],
            [
                'q' => 'Are your tours family friendly?',
                'a' => 'Most tours welcome all ages. Each package page lists any age or height restrictions.',
            ],
        ];

        foreach ($faqs as $order => $faq) {
            Faq::firstOrCreate(
                ['question->en' => $faq['q']],
                [
                    'question' => ['en' => $faq['q']],
                    'answer' => ['en' => $faq['a']],
                    'sort_order' => $order,
                    'status' => true,
                ]
            );
        }
    }

    private function seedGallery(): void
    {
        $album = Album::updateOrCreate(
            ['slug' => 'uae-highlights'],
            [
                'name' => ['en' => 'UAE Highlights'],
                'description' => ['en' => 'A glimpse of the Emirates — from record-breaking skylines to serene mountains.'],
                'status' => true,
                'sort_order' => 0,
            ]
        );

        if (! $album->hasMedia('images')) {
            foreach (['hero.jpg', 'dubai.jpg', 'abu_dhabi.jpg', 'sharjah.jpg', 'rak.jpg', 'tour_burj.jpg', 'tour_mosque.jpg', 'tour_jais.jpg', 'tour_frame.jpg'] as $image) {
                $album->addMedia(public_path('assets/images/'.$image))
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }

        $videos = [
            [
                'title' => ['en' => 'Dubai Helicopter & City Skyline Tour'],
                'video_url' => 'https://www.youtube.com/embed/IdejM6wCkxA',
                'album_id' => $album->id,
            ],
            [
                'title' => ['en' => 'VIP Arabian Desert Safari & Red Dune Bashing'],
                'video_url' => 'https://www.youtube.com/embed/gTly_Vv-1a4',
                'album_id' => $album->id,
            ],
            [
                'title' => ['en' => 'Museum of the Future & Downtown Dubai'],
                'video_url' => 'https://www.youtube.com/embed/RaK5zM7c84k',
                'album_id' => $album->id,
            ],
            [
                'title' => ['en' => 'Abu Dhabi Sheikh Zayed Grand Mosque Experience'],
                'video_url' => 'https://www.youtube.com/embed/04Xqj8g-42U',
                'album_id' => $album->id,
            ],
        ];

        foreach ($videos as $order => $videoData) {
            \App\Models\GalleryVideo::firstOrCreate(
                ['video_url' => $videoData['video_url']],
                [
                    'album_id' => $videoData['album_id'],
                    'title' => $videoData['title'],
                    'sort_order' => $order,
                    'status' => true,
                ]
            );
        }
    }
}
