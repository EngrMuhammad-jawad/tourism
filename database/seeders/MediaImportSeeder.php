<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Enums\TransportType;
use App\Models\Album;
use App\Models\Amenity;
use App\Models\BlogCategory;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Room;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaImportSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(600);

        $tourDir = 'C:/Users/joson/Pictures/tour';
        if (!File::isDirectory($tourDir)) {
            $this->command->error("Tour pictures directory not found: {$tourDir}");
            return;
        }

        $allFiles = File::files($tourDir);
        // Sort files naturally by filename
        usort($allFiles, fn($a, $b) => strnatcmp($a->getFilename(), $b->getFilename()));

        $totalCount = count($allFiles);
        $this->command->info("Found {$totalCount} tour photos in {$tourDir}.");

        // Map files by name for easy reference
        $fileMap = [];
        foreach ($allFiles as $file) {
            $fileMap[$file->getFilename()] = $file->getRealPath();
        }

        // 1. Classify photos into thematic buckets based on reviewed samples
        // Palace/Interior: WA0090, WA0104, WA0108, WA0112
        // Mosque: WA0052-WA0054, WA0091-WA0126
        // Flying Dress: WA0046, WA0047, WA0049, WA0214-WA0226, WA0218, WA0165, WA0168
        // Desert Safari / Quad / Buggy / Sunset: all remaining
        $mosqueFiles = [];
        $palaceFiles = [];
        $flyingDressFiles = [];
        $desertSafariFiles = [];

        foreach ($fileMap as $name => $path) {
            if (in_array($name, ['IMG-20260904-WA0090.jpg', 'IMG-20260904-WA0104.jpg', 'IMG-20260904-WA0108.jpg', 'IMG-20260904-WA0112.jpg'])) {
                $palaceFiles[] = $path;
            } elseif (preg_match('/WA005[2-4]/', $name) || 
                      preg_match('/WA00(9[1-9])/', $name) ||
                      preg_match('/WA01[0-2][0-9]/', $name)) {
                $mosqueFiles[] = $path;
            } elseif (preg_match('/WA004[6-9]/', $name) || 
                      preg_match('/WA021[4-9]/', $name) || 
                      preg_match('/WA022[0-6]/', $name) ||
                      in_array($name, ['IMG-20260904-WA0165.jpg', 'IMG-20260904-WA0168.jpg', 'IMG-20260904-WA0170.jpg', 'IMG-20260904-WA0218.jpg'])) {
                $flyingDressFiles[] = $path;
            } else {
                $desertSafariFiles[] = $path;
            }
        }

        $this->command->info(sprintf(
            "Categorized: Mosque=%d, Palace/Hotel=%d, FlyingDress=%d, DesertSafari=%d",
            count($mosqueFiles),
            count($palaceFiles),
            count($flyingDressFiles),
            count($desertSafariFiles)
        ));

        // 2. Setup Albums
        $this->seedAlbums($fileMap, $mosqueFiles, $palaceFiles, $flyingDressFiles, $desertSafariFiles);

        // 3. Setup Destinations Media
        $this->seedDestinationsMedia($fileMap, $mosqueFiles, $palaceFiles, $flyingDressFiles, $desertSafariFiles);

        // 4. Setup Tour Packages Media & Add New Packages
        $this->seedTourPackagesMedia($fileMap, $mosqueFiles, $flyingDressFiles, $desertSafariFiles);

        // 5. Setup Hotels & Rooms Media
        $this->seedHotelsMedia($fileMap, $palaceFiles);

        // 6. Setup Transports Media
        $this->seedTransportsMedia($fileMap, $desertSafariFiles);

        // 7. Setup Blog Posts with Media
        $this->seedBlogPosts($fileMap, $mosqueFiles, $flyingDressFiles, $desertSafariFiles);

        $this->command->info("All media successfully uploaded and integrated into database!");
    }

    private function seedAlbums(array $fileMap, array $mosque, array $palace, array $flying, array $desert): void
    {
        $this->command->info("Seeding Gallery Albums...");

        // Album 1: Arabian Desert Safari & Quad Biking
        $albumDesert = Album::updateOrCreate(
            ['slug' => 'desert-safari-adventures'],
            [
                'name' => [
                    'en' => 'Arabian Desert Safari & Quad Biking',
                    'ar' => 'سفاري الصحراء العربية والدراجات الرباعية',
                    'ru' => 'Арабское сафари по пустыне и квадроциклы',
                ],
                'description' => [
                    'en' => 'Thrilling dune bashing, quad biking across red sands, camel rides, and golden hour desert sunsets in the Arabian dunes.',
                    'ar' => 'مغامرات الكثبان الرملية وركوب الدراجات الرباعية وركوب الجمال وغروب الشمس الذهبي.',
                    'ru' => 'Захватывающий джип-сафари, квадроциклы по красным дюнам и золотые закаты в пустыне.',
                ],
                'status' => true,
                'sort_order' => 1,
            ]
        );
        $this->attachMediaIfEmpty($albumDesert, 'images', $desert);

        // Album 2: Dubai Flying Dress Desert Photoshoot
        $albumFlying = Album::updateOrCreate(
            ['slug' => 'dubai-flying-dress-photoshoot'],
            [
                'name' => [
                    'en' => 'Dubai Flying Dress Desert Photoshoot',
                    'ar' => 'جلسة تصوير الفستان الطائر في صحراء دبي',
                    'ru' => 'Фотосессия в летящем платье в пустыне Дубая',
                ],
                'description' => [
                    'en' => 'Dramatic high-fashion flying dress photoshoots against the golden sands and radiant sunset of the Dubai desert.',
                    'ar' => 'جلسات تصوير راقية بفستان طائر وسط الرمال الذهبية وغروب الشمس الساحر.',
                    'ru' => 'Роскошная фотосессия в летящем шелковом платье на фоне песчаных дюн и заката.',
                ],
                'status' => true,
                'sort_order' => 2,
            ]
        );
        $this->attachMediaIfEmpty($albumFlying, 'images', $flying);

        // Album 3: Sheikh Zayed Grand Mosque & Culture
        $albumMosque = Album::updateOrCreate(
            ['slug' => 'sheikh-zayed-grand-mosque'],
            [
                'name' => [
                    'en' => 'Sheikh Zayed Grand Mosque & Culture',
                    'ar' => 'جامع الشيخ زايد الكبير والتراث الثقافي',
                    'ru' => 'Большая мечеть шейха Зайда и культура',
                ],
                'description' => [
                    'en' => 'Architectural majesty and cultural serenity at the world-renowned Sheikh Zayed Grand Mosque in Abu Dhabi.',
                    'ar' => 'العمارة الإسلامية الرائعة والسكينة الثقافية في جامع الشيخ زايد الكبير بأبوظبي.',
                    'ru' => 'Архитектурное величие и безмятежность всемирно известной мечети шейха Зайда в Абу-Даби.',
                ],
                'status' => true,
                'sort_order' => 3,
            ]
        );
        $this->attachMediaIfEmpty($albumMosque, 'images', $mosque);

        // Album 4: Emirates Palace & Grand Stays
        $albumPalace = Album::updateOrCreate(
            ['slug' => 'emirates-palace-luxury-stays'],
            [
                'name' => [
                    'en' => 'Emirates Palace & Grand Luxury Stays',
                    'ar' => 'قصر الإمارات والإقامات الفاخرة',
                    'ru' => 'Эмирейтс Палас и роскошный отдых',
                ],
                'description' => [
                    'en' => 'Opulent hospitality, grand palatial interiors, marble domes, and five-star luxury resort experiences.',
                    'ar' => 'ضيافة ملكية وديكورات فخمة وقباب رخامية وتجارب منتجعات خمس نجوم.',
                    'ru' => 'Царственное гостеприимство, роскошные дворцовые интерьеры и пятизвездочные курорты.',
                ],
                'status' => true,
                'sort_order' => 4,
            ]
        );
        $this->attachMediaIfEmpty($albumPalace, 'images', array_merge($palace, array_slice($mosque, 0, 8)));

        // Album 5: UAE Highlights & Guest Moments
        $albumHighlights = Album::updateOrCreate(
            ['slug' => 'uae-highlights'],
            [
                'name' => [
                    'en' => 'UAE Highlights & Guest Moments',
                    'ar' => 'أبرز معالم الإمارات ولحظات الضيوف',
                    'ru' => 'Главные достопримечательности ОАЭ и моменты гостей',
                ],
                'description' => [
                    'en' => 'A curated collection of extraordinary moments captured by our guests across Dubai, Abu Dhabi, and beyond.',
                    'ar' => 'مجموعة مختارة من اللحظات الاستثنائية لضيوفنا في دبي وأبوظبي والإمارات.',
                    'ru' => 'Курированная подборка ярких моментов наших гостей по всему Дубаю и Абу-Даби.',
                ],
                'status' => true,
                'sort_order' => 0,
            ]
        );
        // Add a curated mix of the best photos from all categories to highlights
        $curatedHighlights = array_merge(
            array_slice($desert, 0, 10),
            array_slice($flying, 0, 8),
            array_slice($mosque, 0, 10),
            array_slice($palace, 0, 4)
        );
        $this->attachMediaIfEmpty($albumHighlights, 'images', $curatedHighlights);
    }

    private function seedDestinationsMedia(array $fileMap, array $mosque, array $palace, array $flying, array $desert): void
    {
        $this->command->info("Seeding Destinations Media...");

        // Abu Dhabi: Sheikh Zayed Mosque + Emirates Palace
        $abuDhabi = Destination::where('slug', 'abu-dhabi')->first();
        if ($abuDhabi) {
            if (!empty($mosque)) {
                $abuDhabi->clearMediaCollection('featured');
                $abuDhabi->addMedia($mosque[0])->preservingOriginal()->toMediaCollection('featured');
            }
            if ($abuDhabi->getMedia('gallery')->count() < 5) {
                $gallerySelection = array_merge(array_slice($mosque, 1, 10), array_slice($palace, 0, 4));
                foreach ($gallerySelection as $path) {
                    $abuDhabi->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
                }
            }
        }

        // Dubai: Desert Safari, Flying Dress, Sunset
        $dubai = Destination::where('slug', 'dubai')->first();
        if ($dubai) {
            if (!empty($flying)) {
                $dubai->clearMediaCollection('featured');
                $dubai->addMedia($flying[0])->preservingOriginal()->toMediaCollection('featured');
            }
            if ($dubai->getMedia('gallery')->count() < 5) {
                $gallerySelection = array_merge(array_slice($flying, 1, 6), array_slice($desert, 0, 8));
                foreach ($gallerySelection as $path) {
                    $dubai->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
                }
            }
        }

        // Sharjah: Cultural & Scenic
        $sharjah = Destination::where('slug', 'sharjah')->first();
        if ($sharjah && $sharjah->getMedia('gallery')->count() < 4) {
            foreach (array_slice($desert, 8, 6) as $path) {
                $sharjah->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
            }
        }

        // Ras Al Khaimah: Mountain & Desert Adventure
        $rak = Destination::where('slug', 'ras-al-khaimah')->first();
        if ($rak && $rak->getMedia('gallery')->count() < 4) {
            foreach (array_slice($desert, 14, 6) as $path) {
                $rak->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
            }
        }
    }

    private function seedTourPackagesMedia(array $fileMap, array $mosque, array $flying, array $desert): void
    {
        $this->command->info("Seeding Tour Packages Media...");

        $dubai = Destination::where('slug', 'dubai')->first();
        $abuDhabi = Destination::where('slug', 'abu-dhabi')->first();

        // 1. Update Sheikh Zayed Grand Mosque Package
        $mosquePackage = TourPackage::where('slug', 'sheikh-zayed-grand-mosque')->first();
        if ($mosquePackage) {
            if (!empty($mosque)) {
                $mosquePackage->clearMediaCollection('featured');
                $mosquePackage->addMedia($mosque[0])->preservingOriginal()->toMediaCollection('featured');
            }
            if ($mosquePackage->getMedia('gallery')->count() < 5) {
                foreach (array_slice($mosque, 1, 8) as $path) {
                    $mosquePackage->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
                }
            }
        }

        // 2. Add or Update VIP Desert Safari & Quad Biking Package
        $safariPackage = TourPackage::updateOrCreate(
            ['slug' => 'vip-desert-safari-quad-biking'],
            [
                'destination_id' => $dubai?->id ?? 1,
                'name' => [
                    'en' => 'VIP Desert Safari & Quad Biking Adventure',
                    'ar' => 'سفاري صحراوي لكبار الشخصيات ومغامرة الدراجات الرباعية',
                    'ru' => 'VIP сафари по пустыне и катание на квадроциклах',
                ],
                'summary' => [
                    'en' => 'Experience thrilling red dune bashing, drive high-performance quad bikes & Polaris buggies, and enjoy sunset dining.',
                    'ar' => 'استمتع بمغامرة الكثبان الرملية والدراجات الرباعية وعشاء رومانسي عند غروب الشمس.',
                    'ru' => 'Захватывающий джип-сафари по красным дюнам, скоростные квадроциклы и ужин на закате.',
                ],
                'description' => [
                    'en' => "Conquer the legendary red dunes of the Arabian desert. Take the wheel of a modern Yamaha or Polaris quad bike, experience extreme dune bashing in a private 4x4 Land Cruiser, take breathtaking sunset photos with traditional headscarves, and relax under the stars with gourmet barbecue dining and cultural live performances.\n\nSuitable for solo thrill-seekers, couples, and adventurous families.",
                    'ar' => 'انطلق عبر الكثبان الرملية الحمراء الشهيرة وقُد أحدث الدراجات الرباعية مع مرشدين محترفين.',
                    'ru' => 'Покорите легендарные песчаные дюны Аравийской пустыни за рулем мощных багги и квадроциклов.',
                ],
                'price' => 120,
                'sale_price' => 95,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_guests' => 15,
                'included_services' => [
                    'en' => [
                        'VIP 4x4 Land Cruiser hotel pickup & return',
                        '60 Minutes high-powered Quad Biking / Buggy ride',
                        'Red Dune Bashing & Sandboarding',
                        'Traditional Arabic coffee, dates & refreshments',
                        'Falconry photo opportunities',
                        'Gourmet 5-Star BBQ buffet dinner with live BBQ',
                    ],
                ],
                'excluded_services' => [
                    'en' => ['Personal souvenirs', 'Alcoholic beverages'],
                ],
                'available_from' => now()->startOfYear(),
                'available_to' => now()->addYear(),
                'is_featured' => true,
                'status' => true,
            ]
        );
        if (!empty($desert)) {
            $safariPackage->clearMediaCollection('featured');
            $safariPackage->addMedia($desert[0])->preservingOriginal()->toMediaCollection('featured');
            if ($safariPackage->getMedia('gallery')->count() < 8) {
                foreach (array_slice($desert, 1, 10) as $path) {
                    $safariPackage->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
                }
            }
        }
        if ($safariPackage->itineraries()->count() === 0) {
            $safariPackage->itineraries()->createMany([
                ['day_number' => 1, 'title' => ['en' => 'Hotel Pickup in 4x4 Cruiser'], 'description' => ['en' => 'Afternoon pickup from your luxury hotel in a private air-conditioned vehicle.']],
                ['day_number' => 2, 'title' => ['en' => 'Quad Biking & Dune Bashing'], 'description' => ['en' => 'Safety briefing followed by 60 minutes thrilling ride over the dunes.']],
                ['day_number' => 3, 'title' => ['en' => 'Sunset Camp & Gourmet Dinner'], 'description' => ['en' => 'Stargazing, cultural dance show, and gourmet BBQ banquet.']],
            ]);
        }

        // 3. Add or Update Dubai Flying Dress Desert Photoshoot Package
        $flyingDressPackage = TourPackage::updateOrCreate(
            ['slug' => 'dubai-flying-dress-photoshoot'],
            [
                'destination_id' => $dubai?->id ?? 1,
                'name' => [
                    'en' => 'Dubai Flying Dress Desert Photoshoot',
                    'ar' => 'جلسة تصوير الفستان الطائر في صحراء دبي',
                    'ru' => 'Фотосессия в летящем платье в пустыне Дубая',
                ],
                'summary' => [
                    'en' => 'Feel like royalty in a dramatic long-train silk dress floating against the golden sand dunes of Dubai with a master photographer.',
                    'ar' => 'جلسة تصوير ملكية بفستان حريري فاخر ذو ذيل طويل يطير مع نسيم الصحراء الذهبية.',
                    'ru' => 'Почувствуйте себя королевой в роскошном шелковом платье с длинным шлейфом посреди дюн.',
                ],
                'description' => [
                    'en' => "Create unforgettable memories and Instagram-worthy masterpieces. Our luxury Flying Dress experience includes your choice of designer satin silk dresses with up to 10-meter trains in vibrant royal red, striking midnight black, golden yellow, or sapphire blue.\n\nA dedicated dress assistant and celebrity travel photographer accompany you to ensure every angle catches the magical desert breeze and golden sunset light.",
                    'ar' => 'جلسة تصوير احترافية خاصة مع مساعد أزياء ومصور محترف لأجمل اللقطات الأيقونية.',
                    'ru' => 'Профессиональная фотосессия с ассистентом и фотографом на закате в пустыне.',
                ],
                'price' => 350,
                'sale_price' => 290,
                'duration_days' => 1,
                'duration_nights' => 0,
                'max_guests' => 4,
                'included_services' => [
                    'en' => [
                        'Private luxury chauffeur transfer',
                        'Designer handmade flying silk dress (choice of color)',
                        'Professional fashion photographer & dress assistant',
                        '60+ professionally retouched high-resolution digital photos',
                        'All raw files delivered within 24 hours',
                        'Chilled refreshments and styling support',
                    ],
                ],
                'excluded_services' => [
                    'en' => ['Professional makeup and hair (available on request)'],
                ],
                'available_from' => now()->startOfYear(),
                'available_to' => now()->addYear(),
                'is_featured' => true,
                'status' => true,
            ]
        );
        if (!empty($flying)) {
            $flyingDressPackage->clearMediaCollection('featured');
            $flyingDressPackage->addMedia($flying[0])->preservingOriginal()->toMediaCollection('featured');
            if ($flyingDressPackage->getMedia('gallery')->count() < 8) {
                foreach (array_slice($flying, 1, 10) as $path) {
                    $flyingDressPackage->addMedia($path)->preservingOriginal()->toMediaCollection('gallery');
                }
            }
        }
        if ($flyingDressPackage->itineraries()->count() === 0) {
            $flyingDressPackage->itineraries()->createMany([
                ['day_number' => 1, 'title' => ['en' => 'Dress Selection & Chauffeur Transfer'], 'description' => ['en' => 'Choose your dress color and transfer to the private desert reserve.']],
                ['day_number' => 2, 'title' => ['en' => 'Golden Hour Photoshoot Session'], 'description' => ['en' => 'A guided 90-minute photo shoot through golden hour into sunset.']],
                ['day_number' => 3, 'title' => ['en' => 'High-Resolution Digital Delivery'], 'description' => ['en' => 'Receive your magazine-ready photos and full raw gallery.']],
            ]);
        }

        // 4. Update Burj Khalifa & Dubai Frame packages with gallery photos
        $burj = TourPackage::where('slug', 'burj-khalifa-at-the-top')->first();
        if ($burj) {
            // Remove any erroneously attached desert photos from Burj Khalifa
            $burj->clearMediaCollection('gallery');
        }
    }

    private function seedHotelsMedia(array $fileMap, array $palace): void
    {
        $this->command->info("Seeding Authentic UAE Luxury Hotels & Rooms...");

        // 1. Delete legacy generic dummy hotels and their rooms
        $oldSlugs = ['palm-royale-resort', 'corniche-grand-hotel', 'heritage-boutique-stay', 'jais-mountain-lodge'];
        foreach ($oldSlugs as $oldSlug) {
            $oldHotel = Hotel::where('slug', $oldSlug)->first();
            if ($oldHotel) {
                foreach ($oldHotel->rooms as $r) {
                    $r->clearMediaCollection('images');
                    $r->delete();
                }
                $oldHotel->clearMediaCollection('featured');
                $oldHotel->clearMediaCollection('gallery');
                $oldHotel->forceDelete();
            }
        }

        // 2. Prepare destinations
        $dubai = Destination::where('slug', 'dubai')->first();
        $abuDhabi = Destination::where('slug', 'abu-dhabi')->first();
        $sharjah = Destination::where('slug', 'sharjah')->first();
        $rak = Destination::where('slug', 'ras-al-khaimah')->first();

        // 3. Setup standard luxury amenities
        $amenityNames = [
            'Free High-Speed WiFi',
            'Private Beach Access',
            'Infinity Pool & Cabanas',
            '24/7 Dedicated Butler Service',
            'World-Class Spa & Wellness',
            'Fine Dining Restaurants',
            'Helipad Transfers',
            'Chauffeur Service',
            'Luxury Fitness Centre',
            'Kids Club & Waterpark',
            'Valet Parking',
        ];

        $amenityModels = collect($amenityNames)->map(function ($name) {
            return Amenity::firstOrCreate(
                ['name->en' => $name],
                [
                    'name' => [
                        'en' => $name,
                        'ar' => $name,
                        'ru' => $name,
                    ],
                    'icon' => null,
                ]
            );
        });

        $assetPath = storage_path('app/hotel_assets');

        // 4. Define authentic, world-famous UAE hotels
        $hotelsData = [
            [
                'slug' => 'burj-al-arab-jumeirah',
                'destination_id' => $dubai?->id,
                'name' => [
                    'en' => 'Burj Al Arab Jumeirah',
                    'ar' => 'فندق برج العرب جميرا',
                    'ru' => 'Бурдж Аль Араб Джумейра',
                ],
                'star_rating' => 5,
                'address' => 'Jumeirah Street, Umm Suqeim 3, Dubai, United Arab Emirates',
                'description' => [
                    'en' => "Widely acclaimed as the world's most luxurious hotel, Burj Al Arab Jumeirah is Dubai's iconic sail-shaped architectural marvel. Soaring 321 metres above the Arabian Gulf on its own private island, it offers lavish duplex suites, private butler service, 24-carat gold leaf interiors, world-class dining, and panoramic sea views.",
                    'ar' => "يُعد فندق برج العرب جميرا أشهر الفنادق الفاخرة في العالم وأيقونة دبي المعمارية. يرتفع 321 متراً فوق مياه الخليج العربي على جزيرة خاصة، ويضم أجنحة دوبلكس ملكية مع خدمة الخادم الشخصي على مدار الساعة.",
                    'ru' => "Культовый символ Дубая и всемирно признанный эталон роскоши в форме паруса на собственном острове. Предлагает двухуровневые люксы, персонального дворецкого и захватывающие виды на залив.",
                ],
                'featured' => "{$assetPath}/burj_al_arab_exterior.jpg",
                'gallery' => [
                    "{$assetPath}/burj_al_arab_suite.jpg",
                    "{$assetPath}/burj_al_arab_pool.jpg",
                    "{$assetPath}/presidential_suite.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Deluxe One-Bedroom Suite', 'ar' => 'جناح ديلوكس بغرفة نوم واحدة', 'ru' => 'Люкс Делюкс с одной спальней'],
                        'price' => 1850.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/burj_al_arab_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Panoramic Gulf View Suite', 'ar' => 'جناح بانورامي مطل على الخليج', 'ru' => 'Панорамный люкс с видом на залив'],
                        'price' => 2600.00,
                        'capacity' => 3,
                        'image' => "{$assetPath}/modern_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Royal Two-Bedroom Duplex', 'ar' => 'الجناح الملكي المزدوج بغرفتي نوم', 'ru' => 'Королевский двухуровневый люкс'],
                        'price' => 4800.00,
                        'capacity' => 5,
                        'image' => "{$assetPath}/presidential_suite.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'atlantis-the-palm',
                'destination_id' => $dubai?->id,
                'name' => [
                    'en' => 'Atlantis, The Palm',
                    'ar' => 'أتلانتس النخلة دبي',
                    'ru' => 'Атлантис Зе Палм',
                ],
                'star_rating' => 5,
                'address' => 'Crescent Road, Palm Jumeirah, Dubai, United Arab Emirates',
                'description' => [
                    'en' => "Crowning the apex of the world-famous Palm Jumeirah, Atlantis, The Palm is a legendary ocean-themed luxury resort. Home to the Aquaventure Waterpark, The Lost Chambers Aquarium with 65,000 marine animals, celebrity-chef restaurants by Nobu and Gordon Ramsay, and pristine private beaches.",
                    'ar' => "يتربع منتجع أتلانتس النخلة على قمة نخلة جميرا كأحد أشهر المعالم الترفيهية والفندقية الفاخرة عالمياً، ويحتوي على حديقة أكوافنتشر المائية وأحواض الأسماك ومطاعم لأشهر الطهاة.",
                    'ru' => "Легендарный океанический курорт на вершине острова Пальма Джумейра с крупнейшим в мире аквапарком Aquaventure, океанариумом The Lost Chambers и роскошными частными пляжами.",
                ],
                'featured' => "{$assetPath}/atlantis_the_palm_exterior.jpg",
                'gallery' => [
                    "{$assetPath}/atlantis_suite.jpg",
                    "{$assetPath}/atlantis_palm_pool.jpg",
                    "{$assetPath}/luxury_room.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Ocean King Room', 'ar' => 'غرفة أوشن كينغ بإطلالة بحرية', 'ru' => 'Номер Оушен Кинг с видом на море'],
                        'price' => 650.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/atlantis_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Palm View Family Suite', 'ar' => 'جناح عائلي مطل على النخلة', 'ru' => 'Семейный люкс с видом на Пальму'],
                        'price' => 1250.00,
                        'capacity' => 4,
                        'image' => "{$assetPath}/luxury_room.jpg",
                    ],
                    [
                        'name' => ['en' => 'Underwater Neptune Suite', 'ar' => 'جناح نبتون تحت الماء', 'ru' => 'Подводный люкс Нептун'],
                        'price' => 3400.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/modern_suite.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'emirates-palace-mandarin-oriental',
                'destination_id' => $abuDhabi?->id,
                'name' => [
                    'en' => 'Emirates Palace Mandarin Oriental',
                    'ar' => 'قصر الإمارات ماندرين أورينتال',
                    'ru' => 'Эмирейтс Палас Мандарин Ориентал',
                ],
                'star_rating' => 5,
                'address' => 'West Corniche Road, Abu Dhabi, United Arab Emirates',
                'description' => [
                    'en' => "A dazzling palace of Arabian hospitality and royal grandeur, Emirates Palace Mandarin Oriental Abu Dhabi sits on 1.3 kilometres of pristine private beach. Featuring 114 grand domes, Swarovski crystal chandeliers, gold leaf decor, palatial private suites, and lush landscaped gardens.",
                    'ar' => "صرحٌ ملكي للفخامة العربية الأصيلة على كورنيش أبوظبي، يمتد على شاطئ رملي أبيض بطول 1.3 كيلومتر ويتميز بـ 114 قبة مهيبة وأسقف مذهبة وحدائق غناء ساحرة.",
                    'ru' => "Величественный арабский дворец на побережье Абу-Даби с 1,3 км белоснежного частного пляжа, 114 грандиозными куполами, люстрами Swarovski и истинно королевским комфортом.",
                ],
                'featured' => "{$assetPath}/emirates_palace_2.jpg",
                'gallery' => array_filter([
                    $palace[0] ?? null,
                    $palace[1] ?? null,
                    "{$assetPath}/emirates_palace_3.jpg",
                    "{$assetPath}/palace_grand_suite.jpg",
                ]),
                'rooms' => [
                    [
                        'name' => ['en' => 'Deluxe Palace Pearl Room', 'ar' => 'غرفة لؤلؤة القصر ديلوكس', 'ru' => 'Делюкс номер Жемчужина Дворца'],
                        'price' => 750.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/palace_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Panoramic Sea View Suite', 'ar' => 'جناح بانورامي بإطلالة على البحر', 'ru' => 'Панорамный люкс с видом на море'],
                        'price' => 1400.00,
                        'capacity' => 3,
                        'image' => "{$assetPath}/palace_grand_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Royal Khaleej Palace Suite', 'ar' => 'جناح الخليج الملكي الفاخر', 'ru' => 'Королевский дворец-люкс Халидж'],
                        'price' => 3200.00,
                        'capacity' => 4,
                        'image' => $palace[0] ?? "{$assetPath}/palace_suite.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'armani-hotel-dubai',
                'destination_id' => $dubai?->id,
                'name' => [
                    'en' => 'Armani Hotel Dubai',
                    'ar' => 'فندق أرماني دبي',
                    'ru' => 'Армани Отель Дубай',
                ],
                'star_rating' => 5,
                'address' => 'Burj Khalifa, 1 Mohammed Bin Rashid Blvd, Downtown Dubai, Dubai, United Arab Emirates',
                'description' => [
                    'en' => "Nestled within the iconic Burj Khalifa, Armani Hotel Dubai was personally designed by fashion icon Giorgio Armani. Showcasing understated Italian elegance, curved minimalist walls, Japanese tatami accents, direct private access to The Dubai Mall, and front-row views of the Dubai Fountain.",
                    'ar' => "يقع فندق أرماني دبي داخل برج خليفة وصممه جورجيو أرماني، ليعكس قمة الأناقة الإيطالية والهدوء العصري مع إطلالات ساحرة على نافورة دبي والداون تاون.",
                    'ru' => "Спроектированный Джорджио Армани отель в знаменитой башне Бурдж-Халифа. Воплощение итальянской утонченности с прямым доступом в Dubai Mall и видом на танцующие фонтаны.",
                ],
                'featured' => "{$assetPath}/armani_hotel.jpg",
                'gallery' => [
                    "{$assetPath}/modern_suite.jpg",
                    "{$assetPath}/deluxe_king_bedroom.jpg",
                    "{$assetPath}/presidential_suite.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Armani Classic Room', 'ar' => 'غرفة أرماني كلاسيك', 'ru' => 'Классический номер Армани'],
                        'price' => 620.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/deluxe_king_bedroom.jpg",
                    ],
                    [
                        'name' => ['en' => 'Armani Fountain Suite', 'ar' => 'جناح أرماني بإطلالة النافورة', 'ru' => 'Люкс Армани с видом на фонтан'],
                        'price' => 1150.00,
                        'capacity' => 3,
                        'image' => "{$assetPath}/modern_suite.jpg",
                    ],
                    [
                        'name' => ['en' => 'Armani Signature Suite', 'ar' => 'جناح أرماني سجنتشر الفاخر', 'ru' => 'Фирменный представительский люкс'],
                        'price' => 2100.00,
                        'capacity' => 4,
                        'image' => "{$assetPath}/presidential_suite.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'the-ritz-carlton-abu-dhabi',
                'destination_id' => $abuDhabi?->id,
                'name' => [
                    'en' => 'The Ritz-Carlton Abu Dhabi, Grand Canal',
                    'ar' => 'فندق ريتز كارلتون أبوظبي، القناة الكبرى',
                    'ru' => 'Ритц-Карлтон Абу-Даби, Гранд Канал',
                ],
                'star_rating' => 5,
                'address' => 'Al Maqta Area, Khor Al Maqta, Abu Dhabi, United Arab Emirates',
                'description' => [
                    'en' => "Inspired by 15th to 17th-century Renaissance architecture and the waterways of Venice, The Ritz-Carlton Abu Dhabi is a 57-acre luxury waterfront oasis overlooking the Sheikh Zayed Grand Mosque. Boasting private villas, lush gardens, and a sprawling beachfront pool.",
                    'ar' => "مستوحى من الطراز الفينيسي الإيطالي وحدائق عصر النهضة، يمتد ريتز كارلتون أبوظبي على ضفاف القناة الكبرى مع إطلالة استثنائية مباشرة على جامع الشيخ زايد الكبير.",
                    'ru' => "Роскошный курорт в стиле ренессансной Венеции на берегу Гранд-канала с прямым видом на Большую мечеть шейха Зайда и 57 акрами ухоженных садов.",
                ],
                'featured' => "{$assetPath}/ritz_carlton.jpg",
                'gallery' => [
                    "{$assetPath}/deluxe_king_bedroom.jpg",
                    "{$assetPath}/luxury_room.jpg",
                    "{$assetPath}/presidential_suite.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Venetian Deluxe Room', 'ar' => 'غرفة فينيسية ديلوكس', 'ru' => 'Венецианский номер Делюкс'],
                        'price' => 480.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/deluxe_king_bedroom.jpg",
                    ],
                    [
                        'name' => ['en' => 'Grand Canal Executive Suite', 'ar' => 'جناح تنفيذي بإطلالة القناة الكبرى', 'ru' => 'Представительский люкс Гранд Канал'],
                        'price' => 980.00,
                        'capacity' => 3,
                        'image' => "{$assetPath}/luxury_room.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'the-chedi-al-bait-sharjah',
                'destination_id' => $sharjah?->id,
                'name' => [
                    'en' => 'The Chedi Al Bait, Sharjah',
                    'ar' => 'فندق ذا تشيدي البيت، الشارقة',
                    'ru' => 'Зе Чеди Аль Байт, Шарджа',
                ],
                'star_rating' => 5,
                'address' => 'Heart of Sharjah, Al Mareija, Sharjah, United Arab Emirates',
                'description' => [
                    'en' => "Nestled in the UNESCO-nominated historic district 'Heart of Sharjah', The Chedi Al Bait is an award-winning luxury heritage boutique hotel spread across restored manor houses. Blending traditional Emirati coral architecture with five-star luxury and serene Arabian courtyards.",
                    'ar' => "يقع في قلب الشارقة التراثي، ويعد تحفة معمارية تم ترميمها بعناية لتعكس التراث الإماراتي الأصيل في أجواء من الفخامة والسكينة والضيافة الراقية.",
                    'ru' => "Уникальный бутик-отель в историческом районе Шарджи, бережно восстановленный из старинных особняков с традиционной коралловой архитектурой и премиальным комфортом.",
                ],
                'featured' => "{$assetPath}/chedi_al_bait.jpg",
                'gallery' => [
                    "{$assetPath}/deluxe_king_bedroom.jpg",
                    "{$assetPath}/palace_suite.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Heritage King Room', 'ar' => 'غرفة كينغ تراثية أصيلة', 'ru' => 'Традиционный номер Кинг'],
                        'price' => 350.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/deluxe_king_bedroom.jpg",
                    ],
                    [
                        'name' => ['en' => 'The Chedi Grand Suite', 'ar' => 'جناح ذا تشيدي الكبير', 'ru' => 'Гранд люкс Зе Чеди'],
                        'price' => 720.00,
                        'capacity' => 3,
                        'image' => "{$assetPath}/palace_suite.jpg",
                    ],
                ],
            ],
            [
                'slug' => 'the-cove-rotana-resort',
                'destination_id' => $rak?->id,
                'name' => [
                    'en' => 'The Cove Rotana Resort',
                    'ar' => 'منتجع الكوف روتانا رأس الخيمة',
                    'ru' => 'Ков Ротана Резорт, Рас-эль-Хайма',
                ],
                'star_rating' => 5,
                'address' => 'Sheikh Mohamed Bin Zayed Road, Al Dhait South, Ras Al Khaimah, United Arab Emirates',
                'description' => [
                    'en' => "Perched along an idyllic hillside inlet opening into the azure waters of the Arabian Gulf, The Cove Rotana Resort blends charming Nubian architecture with five-star contemporary comfort. Featuring 600 metres of private beach, hillside infinity pools, and peaceful lagoon views.",
                    'ar' => "يتربع منتجع الكوف روتانا على تلال رأس الخيمة الساحرة المطلة على مياه الخليج، متميزاً بطرازه النوبي الخلاب مع 600 متر من الشواطئ الرملية الخاصة وأحواض السباحة الفاخرة.",
                    'ru' => "Живописный курорт на холме с видом на Арабский залив, сочетающий нубийский стиль с современным пятизвездочным комфортом, 600-метровым пляжем и инфинити-бассейнами.",
                ],
                'featured' => "{$assetPath}/cove_rotana.jpg",
                'gallery' => [
                    "{$assetPath}/luxury_room.jpg",
                    "{$assetPath}/modern_suite.jpg",
                ],
                'rooms' => [
                    [
                        'name' => ['en' => 'Classic Sea View Room', 'ar' => 'غرفة كلاسيك بإطلالة بحرية', 'ru' => 'Классический номер с видом на море'],
                        'price' => 290.00,
                        'capacity' => 2,
                        'image' => "{$assetPath}/luxury_room.jpg",
                    ],
                    [
                        'name' => ['en' => 'Premium Lagoon Villa Suite', 'ar' => 'فيلا بريميوم مطلة على اللاغون', 'ru' => 'Премиум вилла-люкс с видом на лагуну'],
                        'price' => 680.00,
                        'capacity' => 4,
                        'image' => "{$assetPath}/modern_suite.jpg",
                    ],
                ],
            ],
        ];

        foreach ($hotelsData as $data) {
            $hotel = Hotel::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'destination_id' => $data['destination_id'],
                    'name' => $data['name'],
                    'star_rating' => $data['star_rating'],
                    'address' => $data['address'],
                    'description' => $data['description'],
                    'status' => true,
                ]
            );

            // Featured image
            if (File::exists($data['featured'])) {
                $hotel->clearMediaCollection('featured');
                $hotel->addMedia($data['featured'])->preservingOriginal()->toMediaCollection('featured');
            }

            // Gallery images
            $hotel->clearMediaCollection('gallery');
            foreach ($data['gallery'] as $galleryImg) {
                if ($galleryImg && File::exists($galleryImg)) {
                    $hotel->addMedia($galleryImg)->preservingOriginal()->toMediaCollection('gallery');
                }
            }

            // Sync amenities
            $hotel->amenities()->sync($amenityModels->random(min(6, $amenityModels->count()))->pluck('id'));

            // Seed/Update rooms
            $hotel->rooms()->delete();
            foreach ($data['rooms'] as $roomData) {
                $room = $hotel->rooms()->create([
                    'name' => $roomData['name'],
                    'price_per_night' => $roomData['price'],
                    'capacity' => $roomData['capacity'],
                    'quantity' => 10,
                    'status' => true,
                ]);

                if (!empty($roomData['image']) && File::exists($roomData['image'])) {
                    $room->addMedia($roomData['image'])->preservingOriginal()->toMediaCollection('images');
                }
            }
        }
    }

    private function seedTransportsMedia(array $fileMap, array $desert): void
    {
        $this->command->info("Seeding Transports Media...");

        // Remove buggy photos from standard road/flight transports if attached
        $nonSafariTransports = ['domestic-flight', 'luxury-sedan', 'tour-coach', 'family-van', 'airport-pickup'];
        foreach ($nonSafariTransports as $slug) {
            $t = Transport::where('slug', $slug)->first();
            if ($t) {
                $t->clearMediaCollection('images');
            }
        }

        // Create dedicated Desert Safari 4x4 & Buggy transports
        $safariLandCruiser = Transport::updateOrCreate(
            ['slug' => 'desert-safari-4x4-land-cruiser'],
            [
                'type' => TransportType::Car,
                'name' => [
                    'en' => 'VIP Desert Safari 4x4 Land Cruiser',
                    'ar' => 'سيارة لاند كروزر 4x4 لسفاري الصحراء لكبار الشخصيات',
                    'ru' => 'VIP сафари на внедорожнике Toyota Land Cruiser 4x4',
                ],
                'description' => [
                    'en' => 'Customized roll-cage equipped luxury 4x4 Land Cruiser driven by licensed desert safari marshals.',
                    'ar' => 'سيارة دفع رباعي فاخرة ومجهزة بقفص حماية وسائقين محترفين مرخصين للكثبان الرملية.',
                    'ru' => 'Мощный внедорожник Land Cruiser с защитным каркасом для экстремального сафари по дюнам.',
                ],
                'capacity' => 6,
                'price' => 150,
                'price_unit' => 'per_day',
                'status' => true,
            ]
        );
        $safariLandCruiser->clearMediaCollection('images');
        if (!empty($desert)) {
            foreach (array_slice($desert, 0, 4) as $path) {
                $safariLandCruiser->addMedia($path)->preservingOriginal()->toMediaCollection('images');
            }
        }

        $polarisBuggy = Transport::updateOrCreate(
            ['slug' => 'polaris-dune-buggy-yamaha-quad'],
            [
                'type' => TransportType::Car,
                'name' => [
                    'en' => 'Polaris RZR Dune Buggy & Yamaha Quad',
                    'ar' => 'عربات بولاريس الصحراوية ودراجات ياماها الرباعية',
                    'ru' => 'Багги Polaris RZR и квадроциклы Yamaha',
                ],
                'description' => [
                    'en' => 'High-octane 1000cc Polaris off-road dune buggies and high-performance Yamaha quad bikes with full safety gear.',
                    'ar' => 'عربات بولاريس الصحراوية بقوة 1000 سي سي ودراجات ياماها مع كامل معدات السلامة.',
                    'ru' => 'Мощные 1000-кубовые багги Polaris и квадроциклы Yamaha для покорения песчаных барханов.',
                ],
                'capacity' => 2,
                'price' => 220,
                'price_unit' => 'per_day',
                'status' => true,
            ]
        );
        $polarisBuggy->clearMediaCollection('images');
        if (!empty($desert)) {
            foreach (array_slice($desert, 4, 4) as $path) {
                $polarisBuggy->addMedia($path)->preservingOriginal()->toMediaCollection('images');
            }
        }
    }

    private function seedBlogPosts(array $fileMap, array $mosque, array $flying, array $desert): void
    {
        $this->command->info("Seeding Blog Posts...");

        $user = User::first() ?? User::factory()->create([
            'name' => 'Editorial Staff',
            'email' => 'editor@uaetourism.test',
        ]);

        $category = BlogCategory::firstOrCreate(
            ['slug' => 'travel-guides'],
            ['name' => ['en' => 'Travel Guides', 'ar' => 'أدلة السفر', 'ru' => 'Путеводители']]
        );

        $postsData = [
            [
                'slug' => 'ultimate-sheikh-zayed-grand-mosque-guide',
                'title' => [
                    'en' => 'The Ultimate Visitor Guide to Sheikh Zayed Grand Mosque',
                    'ar' => 'الدليل الشامل لزيارة جامع الشيخ زايد الكبير',
                    'ru' => 'Полный путеводитель по Большой мечети шейха Зайда',
                ],
                'excerpt' => [
                    'en' => 'Everything you need to know before visiting Abu Dhabi’s architectural wonder — dress codes, photography etiquette, and sunset magic.',
                    'ar' => 'كل ما تحتاج لمعرفته قبل زيارة هذه التحفة المعمارية في أبوظبي.',
                    'ru' => 'Все, что нужно знать перед посещением архитектурного шедевра Абу-Даби.',
                ],
                'content' => [
                    'en' => "Rising gracefully against the Abu Dhabi skyline, the Sheikh Zayed Grand Mosque is widely regarded as one of the world's most magnificent architectural achievements. Crafted with pristine white Macedonian marble, 82 domes, and hand-woven Iranian carpets, it welcomes millions of international guests each year.\n\n### Dress Code and Etiquette\nVisitors are asked to dress respectfully. Abayas and headscarves are welcomed and celebrated, allowing travelers to immerse themselves in Arabian hospitality.\n\n### Best Time to Visit\nThe golden hour before sunset offers unforgettable photo opportunities as the white marble reflects the setting sun and transitions into ethereal twilight blue lighting.",
                ],
                'image' => $mosque[0] ?? null,
            ],
            [
                'slug' => 'thrill-of-dubai-desert-safari-and-quad-biking',
                'title' => [
                    'en' => 'Adrenaline & Romance: VIP Desert Safari & Quad Biking',
                    'ar' => 'إثارة وسحر: سفاري الصحراء والدراجات الرباعية في دبي',
                    'ru' => 'Адреналин и романтика: VIP сафари и квадроциклы в Дубае',
                ],
                'excerpt' => [
                    'en' => 'From thrilling 4x4 dune bashing to driving quad bikes into the golden desert sunset — the quintessential Dubai adventure.',
                    'ar' => 'من ركوب الكثبان الرملية إلى قيادة الدراجات عند غروب الشمس الذهبي.',
                    'ru' => 'От джип-сафари по красным дюнам до поездок на квадроциклах на закате.',
                ],
                'content' => [
                    'en' => "No trip to the United Arab Emirates is complete without journeying into the endless waves of red sand. Just 45 minutes from Downtown Dubai, the rolling dunes provide the ultimate playground for adventure seekers.\n\n### Quad Biking in the Dunes\nFeel the power of a 350cc quad bike as you scale steep desert ridges and witness panoramic views stretching across the Arabian horizon.\n\n### Arabian Camp & Dining\nAs dusk settles, retreat to a luxury desert camp where bedouin hospitality awaits: fresh dates, aromatic mint tea, falconry displays, and a feast of gourmet grilled delicacies.",
                ],
                'image' => $desert[0] ?? null,
            ],
            [
                'slug' => 'why-dubai-flying-dress-photoshoot-is-unmissable',
                'title' => [
                    'en' => 'The Viral Magic of the Dubai Flying Dress Photoshoot',
                    'ar' => 'سحر جلسة تصوير الفستان الطائر في صحراء دبي',
                    'ru' => 'Магия фотосессии в летящем платье в пустыне Дубая',
                ],
                'excerpt' => [
                    'en' => 'Why this high-fashion experience has become the most sought-after keepsake for travelers visiting the Emirates.',
                    'ar' => 'لماذا أصبحت هذه التجربة الفاخرة أكثر الذكريات طلباً لزوار الإمارات.',
                    'ru' => 'Почему эта модная фотосессия стала самой желанной для путешественников в ОАЭ.',
                ],
                'content' => [
                    'en' => "Imagine standing atop a golden desert crest as a 10-meter silk train billows into the gentle desert breeze, catching the warm rays of the setting sun. The Flying Dress photoshoot is more than a photography session — it is an unforgettable couture experience.\n\n### Vibrant Color Palettes\nWhether you choose majestic scarlet red, midnight black, or imperial gold, each custom gown is tailored to create breathtaking motion and contrast with the sand.\n\n### Memories for a Lifetime\nGuided by professional fashion photographers, you will walk away with magazine-worthy portraits that capture the timeless majesty of the desert.",
                ],
                'image' => $flying[0] ?? null,
            ],
        ];

        foreach ($postsData as $data) {
            $post = Post::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $user->id,
                    'blog_category_id' => $category->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'meta_title' => $data['title']['en'],
                    'meta_description' => $data['excerpt']['en'],
                    'status' => PostStatus::Published,
                    'published_at' => now(),
                ]
            );

            if ($data['image'] && !$post->hasMedia('featured')) {
                $post->addMedia($data['image'])->preservingOriginal()->toMediaCollection('featured');
            }
        }
    }

    private function attachMediaIfEmpty(Album $album, string $collection, array $filePaths): void
    {
        // Check how many images are currently attached
        $existingCount = $album->getMedia($collection)->count();
        if ($existingCount >= count($filePaths)) {
            return;
        }

        foreach ($filePaths as $path) {
            if (File::exists($path)) {
                $album->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection($collection);
            }
        }
    }
}
