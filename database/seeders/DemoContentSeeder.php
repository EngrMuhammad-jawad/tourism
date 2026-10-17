<?php

namespace Database\Seeders;

use App\Enums\ModerationStatus;
use App\Enums\PostStatus;
use App\Enums\TransportType;
use App\Models\Album;
use App\Models\Amenity;
use App\Models\BlogCategory;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
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
        $this->seedPosts();
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
            [
                'slug' => 'dubai',
                'custom_name' => [
                    'en' => 'Dubai',
                    'ar' => 'دبي',
                    'ru' => 'Дубай',
                ],
                'custom_desc' => [
                    'en' => 'The jewel of the UAE, famed for ultra-modern architecture, luxury shopping, Burj Khalifa, Palm Jumeirah, and vibrant nightlife.',
                    'ar' => 'لؤلؤة الإمارات ووجهة الفخامة العالمية، موطن برج خليفة ونخلة جميرا وأرقى مراكز التسوق والتجارب الفندقية الفارهة.',
                    'ru' => 'Жемчужина ОАЭ, знаменитая ультрасовременной архитектурой, роскошным шопингом, Бурдж Халифа и Пальмой Джумейра.',
                ],
                'city' => 'Dubai',
                'image' => 'dubai.jpg',
                'lat' => 25.2048,
                'lng' => 55.2708,
            ],
            [
                'slug' => 'abu-dhabi',
                'custom_name' => [
                    'en' => 'Abu Dhabi',
                    'ar' => 'أبوظبي',
                    'ru' => 'Абу-Даби',
                ],
                'custom_desc' => [
                    'en' => 'The majestic capital of the UAE, home to the Sheikh Zayed Grand Mosque, Louvre Abu Dhabi, Qasr Al Watan, and Yas Island theme parks.',
                    'ar' => 'عاصمة دولة الإمارات العريقة، موطن جامع الشيخ زايد الكبير ومتحف اللوفر وقصر الوطن وعالم فيراري بجزيرة ياس.',
                    'ru' => 'Величественная столица ОАЭ, где расположены Мечеть Шейха Зайда, Лувр Абу-Даби, Президентский дворец и остров Яс.',
                ],
                'city' => 'Abu Dhabi',
                'image' => 'abu_dhabi.jpg',
                'lat' => 24.4539,
                'lng' => 54.3773,
            ],
            [
                'slug' => 'sharjah',
                'custom_name' => [
                    'en' => 'Sharjah',
                    'ar' => 'الشارقة',
                    'ru' => 'Шарджа',
                ],
                'custom_desc' => [
                    'en' => 'The cultural and heritage capital of the Arab world, celebrated for Islamic museums, art foundations, and the stunning Al Noor Island.',
                    'ar' => 'عاصمة الثقافة والتراث في العالم العربي، تضم أرقى المتاحف الإسلامية ومؤسسات الفنون وجزيرة النور الساحرة.',
                    'ru' => 'Культурная столица ОАЭ, известная исламскими музеями, объектами искусства и прекрасным островом Аль-Нур.',
                ],
                'city' => 'Sharjah',
                'image' => 'sharjah.jpg',
                'lat' => 25.3463,
                'lng' => 55.4209,
            ],
            [
                'slug' => 'ajman',
                'custom_name' => [
                    'en' => 'Ajman',
                    'ar' => 'عجمان',
                    'ru' => 'Аджман',
                ],
                'custom_desc' => [
                    'en' => 'Charming coastal emirate renowned for Al Zorah nature reserve mangroves, flamingos, tranquil white sand beaches, and historic dhow yards.',
                    'ar' => 'إمارة ساحلية هادئة تتميز بمحمية الزوراء الطبيعية وملاذ طيور الفلامنجو وشواطئها الخلابة وصناعة المراكب الشراعية العريقة.',
                    'ru' => 'Живописный прибрежный эмират, славящийся мангровыми зарослями Аль-Зора, фламинго и белоснежными пляжами.',
                ],
                'city' => 'Ajman',
                'image' => 'ajman.jpg',
                'lat' => 25.4052,
                'lng' => 55.5136,
            ],
            [
                'slug' => 'umm-al-quwain',
                'custom_name' => [
                    'en' => 'Umm Al Quwain',
                    'ar' => 'أم القيوين',
                    'ru' => 'Умм-эль-Кайвайн',
                ],
                'custom_desc' => [
                    'en' => 'Untouched coastal tranquility, authentic Emirati atmosphere, Mangrove Beach, calm tidal lagoons, and scenic coastal nature.',
                    'ar' => 'أجواء ساحلية هادئة وتراث إماراتي أصيل، تشتهر بشاطئ القرم الساحر والبحيرات الشاطئية ورحلات الطبيعة الهادئة.',
                    'ru' => 'Спокойный прибрежный эмират с нетронутой природой, знаменитым Мангровым пляжем и тихими лагунами.',
                ],
                'city' => 'Umm Al Quwain',
                'image' => 'umm_al_quwain.jpg',
                'lat' => 25.5647,
                'lng' => 55.5532,
            ],
            [
                'slug' => 'ras-al-khaimah',
                'custom_name' => [
                    'en' => 'Ras Al Khaimah',
                    'ar' => 'رأس الخيمة',
                    'ru' => 'Рас-эль-Хайма',
                ],
                'custom_desc' => [
                    'en' => 'The UAE’s premier adventure haven, boasting the soaring peaks of Jebel Jais, world-class zipline, terra desert retreats, and luxury island resorts.',
                    'ar' => 'وجهة المغامرات الأولى في الإمارات، موطن جبل جيس الشاهق وأطول مسار انزلاقي بالعالم والمنتجعات الصحراوية والجبلية الفاخرة.',
                    'ru' => 'Главный центр приключенческого туризма в ОАЭ: высочайшая гора Джебель Джейс, рекордный зиплайн и роскошные отели.',
                ],
                'city' => 'Ras Al Khaimah',
                'image' => 'rak.jpg',
                'lat' => 25.7895,
                'lng' => 55.9432,
            ],
            [
                'slug' => 'fujairah',
                'custom_name' => [
                    'en' => 'Fujairah',
                    'ar' => 'الفجيرة',
                    'ru' => 'Фуджейра',
                ],
                'custom_desc' => [
                    'en' => 'The eastern jewel on the Gulf of Oman, famous for dramatic Hajar mountain backdrops, pristine Indian Ocean diving, Snoopy Island, and Al Bidyah Mosque.',
                    'ar' => 'درة الساحل الشرقي على خليج عمان، تتميز بسلاسل جبال الحجر وغوص المحيط الهندي وجزيرة سنوبي ومسجد البدية التاريخي.',
                    'ru' => 'Восточный эмират на побережье Оманского залива (Индийский океан): горы Хаджар, дайвинг, остров Снупи и древняя мечеть Аль-Бидия.',
                ],
                'city' => 'Fujairah',
                'image' => 'fujairah.jpg',
                'lat' => 25.1288,
                'lng' => 56.3265,
            ],
            [
                'slug' => 'al-ain',
                'custom_name' => [
                    'en' => 'Al Ain',
                    'ar' => 'العين',
                    'ru' => 'Аль-Айн',
                ],
                'custom_desc' => [
                    'en' => 'The historic "Garden City" of Abu Dhabi and UNESCO World Heritage oasis, featuring Jebel Hafeet, Al Jahili Fort, and thousand-year-old falaj irrigation date palms.',
                    'ar' => 'مدينة الواحات والحدائق الغنّاء وإرث اليونسكو العالمي بأبوظبي، موطن جبل حفيت وقلعة الجاهلي وقنوات الفلج التاريخية.',
                    'ru' => 'Исторический город-сад в эмирате Абу-Даби под защитой ЮНЕСКО: зеленые оазисы, гора Джебель Хафит и форт Аль-Джахили.',
                ],
                'city' => 'Al Ain',
                'image' => 'al_ain.jpg',
                'lat' => 24.2075,
                'lng' => 55.7447,
            ],
            [
                'slug' => 'hatta',
                'custom_name' => [
                    'en' => 'Hatta',
                    'ar' => 'حتا',
                    'ru' => 'Хатта',
                ],
                'custom_desc' => [
                    'en' => 'Scenic mountain enclave of Dubai, famous for the turquoise waters of Hatta Dam, kayak adventures, Hatta Heritage Village, and wadi hiking trails.',
                    'ar' => 'محمية دبي الجبلية الساحرة، تشتهر بمياه سد حتا الفيروزية ومغامرات الكاياك وقرية حتا التراثية ومسارات المشي الجبلية.',
                    'ru' => 'Живописный горный анклав Дубая: бирюзовое озеро дамбы Хатта, каякинг, историческая деревня и горные тропы.',
                ],
                'city' => 'Hatta',
                'image' => 'hatta.jpg',
                'lat' => 24.8058,
                'lng' => 56.1264,
            ],
        ];

        foreach ($destinations as $order => $data) {
            $destination = Destination::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['custom_name'] ?? $this->trans($data['key'].'_title'),
                    'description' => $data['custom_desc'] ?? $this->trans($data['key'].'_desc'),
                    'country' => 'United Arab Emirates',
                    'city' => $data['city'],
                    'map_lat' => $data['lat'],
                    'map_lng' => $data['lng'],
                    'is_featured' => true,
                    'status' => true,
                    'sort_order' => $order,
                ]
            );

            if (! $destination->hasMedia('featured') && file_exists(public_path('assets/images/'.$data['image']))) {
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
                'slug' => 'dubai-city-tour-luxury-experience',
                'destination' => 'dubai',
                'image' => 'dubai.jpg',
                'price' => 150,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Dubai City Tour: Full Day Luxury Sightseeing & Iconic Landmarks',
                    'ar' => 'جولة دبي السياحية الشاملة: أرقى المعالم الأيقونية، مارينا وبرج خليفة',
                    'ru' => 'Гранд-Тур по Дубаю: Все Главные Достопримечательности и Бурдж Халифа 2026',
                ],
                'summary' => [
                    'en' => 'The ultimate Dubai tour experience! Discover Burj Khalifa, Dubai Marina, Palm Jumeirah, Atlantis, Museum of the Future, and traditional Gold Souk with a private luxury guide.',
                    'ar' => 'الجولة السياحية الأفضل في دبي! استكشف برج خليفة، دبي مارينا، نخلة جميرا، أتلانتس، متحف المستقبل وأسواق الذهب التراثية مع مرشد سياحي فاخر.',
                    'ru' => 'Лучший экскурсионный тур по Дубаю! Посетите Бурдж Халифа, Дубай Марину, Пальму Джумейра, Музей Будущего и Золотой базар с персональным гидом.',
                ],
                'description' => [
                    'en' => "Immerse yourself in the world's most glamorous metropolis with our premier Full Day Dubai City Tour. Designed specifically for discerning travelers and GCC families seeking comfort, luxury, and cultural depth.\n\nYour day begins with private hotel pickup in a premium air-conditioned luxury vehicle. Witness the ultra-modern skyline of Downtown Dubai, capture unforgettable photos at the iconic Museum of the Future and Dubai Frame, cruise past million-dollar yachts in Dubai Marina, and journey onto the world-famous Palm Jumeirah archipelago with a stop at Atlantis The Palm.\n\nIn the afternoon, travel back in time to the historical Al Fahidi district, cross the historic Dubai Creek on a traditional Abra water taxi, and discover the fragrant Spice Souk and dazzling Gold Souk. Finish with VIP skip-the-line access to Burj Khalifa At The Top and the magical Dubai Fountain show.",
                    'ar' => "عش تجربة سياحية استثنائية في قلب دبي مع جولتنا اليومية المتكاملة المخصصة للعوائل الخليجية وكبار الشخصيات.\n\nتبدأ الجولة باستقبال خاص من فندقكم بسيارة فارهة ومكيفة، وتتضمن زيارة أرقى معالم دبي: برج خليفة، متحف المستقبل، نخلة جميرا، فندق أتلانتس، دبي مارينا، مع جولة تراثية في خور دبي وسوق الذهب وأسواق التوابل، واختتام اليوم مع عروض نافورة دبي الراقصة.",
                    'ru' => "Погрузитесь в великолепие Дубая в рамках нашего премиального однодневного тура. Частный трансфер на роскошном авто, персональный русскоговорящий гид, проход без очередей на Бурдж Халифа, прогулка по Пальме Джумейра, Дубай Марине и историческому району Аль-Фахиди с поездкой на лодке абра.",
                ],
                'included_services' => [
                    'en' => ['Private luxury hotel pickup & return transfer', 'Certified multilingual professional tour guide', 'Burj Khalifa observation deck admission ticket', 'Scenic traditional Abra boat cruise across Dubai Creek', 'Complimentary chilled water, dates & Arabic coffee'],
                    'ar' => ['استقبال وتوصيل خاص من وإلى الفندق بسيارة VIP مكيفة', 'مرشد سياحي معتمد ومحترف يتحدث العربية بطلاقة', 'تذكرة دخول سريعة لبرج خليفة', 'جولة بحرية في قارب العبرة التراثي في خور دبي', 'ضيافة عربية ومياه معدنية مجانية طوال الرحلة'],
                    'ru' => ['Индивидуальный трансфер из отеля и обратно', 'Лицензированный русскоговорящий гид', 'Входной билет на Бурдж Халифа', 'Прогулка на лодке абра по Дубай Крик'],
                ],
            ],
            [
                'slug' => 'burj-khalifa-at-the-top',
                'destination' => 'dubai',
                'image' => 'tour_burj.jpg',
                'price' => 45,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Burj Khalifa At The Top: 124th & 125th Floor Observation Deck Tickets',
                    'ar' => 'تذاكر برج خليفة قمة البرج: الطابق 124 و125 مع إطلالة بانورامية',
                    'ru' => 'Билеты на Бурдж Халифа: Смотровая площадка 124 и 125 этаж 2026',
                ],
                'summary' => [
                    'en' => 'Ascend the world\'s tallest skyscraper in high-speed double-decker elevators to enjoy 360-degree views across Dubai, the Arabian Gulf, and desert skyline.',
                    'ar' => 'اصعد إلى أعلى ناطحة سحاب في العالم بأسرع مصاعد واستمتع بإطلالات بانورامية ساحرة 360 درجة على معالم دبي والخليج العربي.',
                    'ru' => 'Поднимитесь на вершину самого высокого здания в мире с панорамным обзором на 360 градусов на Дубай и Персидский залив.',
                ],
                'description' => [
                    'en' => "Experience the pinnacle of Dubai luxury with prime admission to Burj Khalifa At The Top. Travel in ultra-fast double-decker elevators travelling at 10 metres per second with immersive multimedia projections up to Levels 124 and 125.\n\nEnjoy breathtaking 360-degree panoramas of Downtown Dubai, Dubai Mall, the Arabian Gulf, and the distant desert horizon through floor-to-ceiling glass walls and open-air observation terraces. High-powered optical telescopes let you zoom into city landmarks in real-time.",
                    'ar' => "عش قمة الفخامة في دبي مع تذاكر الدخول المميزة لقمة برج خليفة (الطابق 124 و125). تنقل عبر أسرع مصاعد العالم بسرعة 10 أمتار بالثانية المزودة بعروض وسائط رقمية تفاعلية.\n\nاستمتع بمناظر بانورامية ساحرة لوسط مدينة دبي، دبي مول، ونافورة دبي الراقصة عبر شرفات مفتوحة ونوافذ زجاجية عملاقة، مع تلسكوبات رقمية عالية الدقة لاستكشاف المعالم.",
                    'ru' => "Испытайте незабываемые эмоции на вершине самого высокого здания планеты. Скоростной лифт поднимет вас на 124-й и 125-й этажи менее чем за минуту. Вас ждут панорамный обзор на 360 градусов, открытая терраса и мощные телескопы.",
                ],
                'included_services' => [
                    'en' => ['Burj Khalifa Level 124 & 125 admission pass', 'High-speed double-decker elevator experience', 'Use of viewing telescopes and observation deck', 'Complimentary high-speed WiFi'],
                    'ar' => ['تذكرة دخول الطابقين 124 و125 لبرج خليفة', 'تجربة المصاعد المزدوجة فائقة السرعة', 'استخدام التلسكوبات الرقمية والشرفة المفتوحة', 'واي فاي مجاني فائق السرعة'],
                    'ru' => ['Входные билеты на 124 и 125 этажи', 'Скоростной подъем на лифте', 'Доступ к смотровой площадке и телескопам', 'Бесплатный Wi-Fi'],
                ],
            ],
            [
                'slug' => 'sheikh-zayed-grand-mosque',
                'destination' => 'abu-dhabi',
                'image' => 'tour_mosque.jpg',
                'price' => 65,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Abu Dhabi Sheikh Zayed Grand Mosque Day Tour from Dubai',
                    'ar' => 'رحلة جامع الشيخ زايد الكبير بأبوظبي من دبي مع مرشد VIP',
                    'ru' => 'Экскурсия в Белую Мечеть Шейха Зайда в Абу-Даби из Дубая',
                ],
                'summary' => [
                    'en' => 'Marvel at the world-renowned architectural masterpiece of the Sheikh Zayed Grand Mosque with luxury transfers from Dubai and a certified cultural guide.',
                    'ar' => 'استكشف التحفة المعمارية الإسلامية الأبرز عالمياً جامع الشيخ زايد الكبير بأبوظبي مع توصيل فاخر من دبي ومرشد ثقافي معتمد.',
                    'ru' => 'Посетите великолепную Мечеть Шейха Зайда в Абу-Даби с комфортабельным трансфером из Дубая и сертифицированным гидом.',
                ],
                'description' => [
                    'en' => "Journey from Dubai along the coast of the Arabian Gulf to Abu Dhabi, the capital of the United Arab Emirates, to visit the magnificent Sheikh Zayed Grand Mosque.\n\nAdmire white Macedonian marble facades, 82 Moroccan-designed domes, gold-plated Swarovski crystal chandeliers, reflective water pools, and the world's largest hand-knotted Persian carpet. Learn about Islamic art, history, and Emirati tolerance through an engaging guided tour suitable for visitors of all cultures.",
                    'ar' => "انطلق في رحلة راقية من دبي إلى العاصمة أبوظبي لزيارة صرح التسامح الإنساني والجمال المعماري، جامع الشيخ زايد الكبير.\n\nتأمل الرخام الأبيض النقي، و82 قبة مصممة بأعلى درجات الإتقان، وثريات الكريستال السواروفسكي المذهبة، وأكبر سجادة إيرانية منسوجة يدوياً في العالم، برفقة مرشد سياحي يقدم شرحاً ثقافياً غنياً.",
                    'ru' => "Увлекательное путешествие из Дубая в столицу ОАЭ Абу-Даби. Величественная Мечеть Шейха Зайда поразит вас белоснежным мрамором, люстрами с кристаллами Swarovski и самым большим ковром ручной работы в мире.",
                ],
                'included_services' => [
                    'en' => ['Roundtrip luxury transfer from Dubai hotel', 'Certified bilingual cultural tour guide', 'Abaya and modest attire provided for women', 'Bottled mineral water & Arabic dates'],
                    'ar' => ['توصيل فاخر ذهاب وعودة من فندقكم بدبي', 'مرشد سياحي ثقافي معتمد يتحدث العربية والإنجليزية', 'توفير عبايات وملابس محتشمة للسيدات مجاناً', 'مياه معدنية وضيافة تمور إماراتية'],
                    'ru' => ['Трансфер из отеля Дубая и обратно', 'Лицензированный гид', 'Предоставление традиционной одежды (абайи)', 'Питьевая вода'],
                ],
            ],
            [
                'slug' => 'jebel-jais-zipline',
                'destination' => 'ras-al-khaimah',
                'image' => 'tour_jais.jpg',
                'price' => 80,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Jebel Jais Zipline Flight: World\'s Longest Zipline Adventure',
                    'ar' => 'مغامرة مسار جبل جيس الانزلاقی: أطول زيب لاين في العالم برأس الخيمة',
                    'ru' => 'Зиплайн на Джебель Джейс: Самый длинный зиплайн в мире',
                ],
                'summary' => [
                    'en' => 'Soar like a falcon over breathtaking peaks in the Hajar Mountains at speeds up to 160 km/h on the Guinness World Record-holding longest zipline.',
                    'ar' => 'حلّق كالصقر فوق قمم جبال الحجر بسرعة تصل إلى 160 كم/ساعة على أطول مسار انزلاقي في العالم المسجل بموسوعة غينيس.',
                    'ru' => 'Полет на рекордном самом длинном зиплайне мира среди величественных гор Джебель Джейс на скорости до 160 км/ч.',
                ],
                'description' => [
                    'en' => "Unleash your inner adrenaline seeker on Jebel Jais Flight, officially recognized by Guinness World Records as the world's longest zipline at 2.83 kilometers long.\n\nPerched 1,680 meters above sea level on the UAE's highest peak, you will be fitted with professional safety gear and lie belly-down in the superhero falcon position. Rocket across jagged mountain canyons at exhilarating speeds between 120 and 160 km/h before landing on a suspended glass platform hanging in mid-air.",
                    'ar' => "عش قمة الإثارة والمغامرة مع مسار جبل جيس الانزلاقي الحاصل على رقم قياسي عالمي في موسوعة غينيس بطول 2.83 كيلومتر.\n\nعلى ارتفاع 1,680 متراً فوق سطح البحر بأعلى قمة في دولة الإمارات، استعد للتحليق بوضعية الصقر بسرعة تتراوح بين 120 إلى 160 كم/ساعة فوق الوديان الجبلية الشاهقة، مع هبوط استثنائي على منصة معلقة في الهواء.",
                    'ru' => "Для любителей экстрима: самый длинный в мире зиплайн протяженностью 2,83 км на высшей точке ОАЭ. Полет на скорости до 160 км/ч над горными каньонами в специальном снаряжении супергероя.",
                ],
                'included_services' => [
                    'en' => ['Guinness Record Jebel Jais Flight zipline ticket', 'Professional safety harness, helmet & briefing', 'Suspended platform transfer experience', 'High-altitude mountain viewing deck access'],
                    'ar' => ['تذكرة المسار الانزلاقي الأطول عالمياً بجبل جيس', 'معدات أمان وخوذة معتمدة مع تدريب مسبق', 'تجربة المنصة المعلقة في الهواء', 'دخول منصات المشاهدة الجبلية'],
                    'ru' => ['Билет на зиплайн Jebel Jais Flight', 'Полная экипировка и инструктаж', 'Доступ на смотровые площадки'],
                ],
            ],
            [
                'slug' => 'dubai-frame',
                'destination' => 'dubai',
                'image' => 'tour_frame.jpg',
                'price' => 15,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Dubai Frame Tickets & Sky Deck Glass Bridge Experience',
                    'ar' => 'تذاكر برواز دبي وجسر الممشى الزجاجي المعلق في حديقة زعبيل',
                    'ru' => 'Билеты на Дубайскую Рамку (Dubai Frame) и Стеклянный Мост',
                ],
                'summary' => [
                    'en' => 'Step onto the 150-meter luminous glass bridge bridging Old and New Dubai, with interactive historical galleries, future Dubai VR exhibits, and skyline views.',
                    'ar' => 'امشِ فوق الجسر الزجاجي المضيء على ارتفاع 150 متراً الذي يربط بين دبي القديمة ودبي الحديثة مع معارض تفاعلية وإطلالات ساحرة.',
                    'ru' => 'Пройдитесь по стеклянному прозрачному мосту на высоте 150 метров между Старым и Новым Дубаем с панорамным видом.',
                ],
                'description' => [
                    'en' => "Discover the world's largest picture frame soaring 150 meters above Zabeel Park. Dubai Frame presents a unique architectural concept connecting Dubai’s storied past with its visionary future.\n\nBegin with an immersive Old Dubai heritage gallery exhibiting the city’s transformation from a humble pearl-diving port. Take the panoramic elevator to the Sky Deck and walk across the state-of-the-art 50-meter liquid-crystal glass bridge that switches from translucent to completely transparent beneath your feet. Finish with the vortex tunnel showcasing Dubai's futuristic metropolis 50 years ahead.",
                    'ar' => "اكتشف أكبر إطار صور في العالم بارتفاع 150 متراً في حديقة زعبيل، والذي يربط بعبقرية معمارية بين تاريخ دبي العريق ومستقبلها المشرق.\n\nابدأ جولتك في معرض دبي القديمة، ثم اصعد بالمصعد البانورامي إلى قمة البرواز لتعبر الممشى الزجاجي التفاعلي الذي يتحول إلى شفاف تحت أقدامك على ارتفاع شاهق، واختتم الجولة بنفق المستقبل الافتراضي.",
                    'ru' => "Уникальная достопримечательность в парке Забиль высотой 150 метров. Прогуляйтесь по прозрачному стеклянному мосту на вершине рамки, любуясь панорамой исторических районов с одной стороны и футуристических небоскребов с другой.",
                ],
                'included_services' => [
                    'en' => ['Dubai Frame full-access entry ticket', 'Sky Deck and 50m glass bridge walk', 'Old Dubai Past Gallery & Future Dubai Tunnel', 'Free parking & elevator access'],
                    'ar' => ['تذكرة دخول شاملة لبرواز دبي', 'دخول الجسر الزجاجي العلوي المعلق', 'معرض دبي التراثي ونفق المستقبل الافتراضي', 'مواقف مجانية ومصاعد بانورامية'],
                    'ru' => ['Входной билет на Dubai Frame', 'Проход по стеклянному мосту на высоте 150м', 'Посещение музея истории и будущего Дубая'],
                ],
            ],
            [
                'slug' => 'dubai-vip-red-dune-desert-safari',
                'destination' => 'dubai',
                'image' => 'tour_desert_safari.jpg',
                'price' => 55,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Dubai VIP Red Dune Desert Safari: Dune Bashing, Camel Trekking & Royal BBQ Dinner',
                    'ar' => 'سفاري صحراء دبي VIP: مغامرة الكثبان الحمراء، ركوب الجمال، عروض حية وعشاء مشاوي فاخر',
                    'ru' => 'VIP Сафари по Красным Дюнам в Дубае: Джип-сафари, Верблюды, Фаер-шоу и Барбекю',
                ],
                'summary' => [
                    'en' => 'Experience the magic of the Arabian desert! High red dune bashing in a 4x4 Land Cruiser, camel rides, sandboarding, falconry photos, and 5-star Bedouin camp dinner with live fire & Tanoura shows.',
                    'ar' => 'عش سحر الصحراء العربية مع رحلة السفاري الفاخرة: تطعيس الكثبان الرملية الحمراء، ركوب الجمال، التزلج على الرمال، وعشاء مشاوي فاخر مع عروض التنورة والنار الحية.',
                    'ru' => 'Настоящее восточное приключение в пустыне: катание по высоким дюнам на Land Cruiser, верблюды, сэндбординг и ужин в лагере с шоу огня.',
                ],
                'description' => [
                    'en' => "Escape into the mesmerizing red dunes of the Lahbab desert for an unforgettable Arabian adventure. Your VIP experience begins with hotel pickup in a modified 4x4 Land Cruiser.\n\nThrilling roller-coaster dune bashing over towering red dunes with sunset photo stops. Arrive at an authentic Arabian desert fortress camp where Arabic coffee, dates, and fresh falafel welcome you. Enjoy quad biking options, camel trekking, henna body painting, and hubbly bubbly shisha. Savor a lavish 5-star international buffet dinner with live BBQ grilling while being entertained by belly dancing, Egyptian Tanoura dancers, and an astonishing fire show.",
                    'ar' => "انطلق إلى رمال لهباب الحمراء الساحرة في تجربة صحراوية لا تُنسى. تبدأ الرحلة باستقبال خاص بسيارة لاند كروزر رباعية الدفع.\n\nاستمتع بتطعيس مثير فوق أعلى الكثبان مع وقفات تصوير الغروب، ثم التوجه إلى المخيم الملكي مع ضيافة القهوة العربية والتمور، وركوب الجمال، ونقش الحناء، واختتام الأمسية مع بوفيه عشاء ومشاوي فاخرة وعروض استعراضية حية.",
                    'ru' => "Покорите бескрайние красные пески пустыни Лахбаб на подготовленном внедорожнике. Захватывающий дрифт по дюнам, закат в пустыне, верблюжья ферма, роспись хной и королевский ужин-барбекю под звездным небом с шоу танца живота и огненным представлением.",
                ],
                'included_services' => [
                    'en' => ['Hotel pickup & return in luxury 4x4 Land Cruiser', '45-minute thrilling red dune bashing', 'Camel ride, sandboarding & sunset photography', 'VIP Bedouin camp seating & unlimited soft drinks, coffee & tea', 'International gourmet BBQ buffet dinner', 'Live fire show, Tanoura dance & belly dance performances'],
                    'ar' => ['توصيل ذهاب وعودة من الفندق بسيارة دفع رباعي VIP', 'تطعيس 45 دقيقة فوق الكثبان الرملية الحمراء', 'ركوب الجمال والتزلج على الرمال وتصوير الغروب', 'جلسات مخيم فاخرة ومشروبات وقهوة غير محدودة', 'بوفيه عشاء مشاوي ملكي مفتوح', 'عروض التنورة ورقصة النار الحية'],
                    'ru' => ['Трансфер из отеля на 4x4 Land Cruiser', 'Экстремальное джип-сафари по дюнам', 'Катание на верблюдах и сэндборд', 'Ужин-барбекю (шведский стол) и напитки', 'Шоу огня и танцевальная программа'],
                ],
            ],
            [
                'slug' => 'abu-dhabi-sharing-city-tour',
                'destination' => 'abu-dhabi',
                'image' => 'abu_dhabi.jpg',
                'price' => 70,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Abu Dhabi Full Day Tour: Sheikh Zayed Mosque, Corniche, Emirates Palace & Heritage',
                    'ar' => 'جولة أبوظبي الشاملة: جامع الشيخ زايد الكبير، الكورنيش، قصر الإمارات والقرية التراثية',
                    'ru' => 'Гранд-Тур по Абу-Даби: Мечеть Шейха Зайда, Корниш, Эмирейтс Палас и Наследие',
                ],
                'summary' => [
                    'en' => 'Discover the rich heritage and modern luxury of the UAE capital! Tour the Sheikh Zayed Mosque, scenic Corniche, Emirates Palace photo stop, and presidential landmarks.',
                    'ar' => 'اكتشف عاصمة دولة الإمارات بكل فخامتها وتراثها: زيارة جامع الشيخ زايد، كورنيش أبوظبي، قصر الإمارات، وقصر الوطن الرئاسي.',
                    'ru' => 'Откройте для себя столицу ОАЭ: экскурсия в Белую Мечеть, набережная Корниш, дворец Эмирейтс Палас и остров Яс.',
                ],
                'description' => [
                    'en' => "Experience the cultural wealth and breathtaking opulence of Abu Dhabi with our comprehensive day tour. Pickups available from Dubai, Sharjah, Ajman, and Abu Dhabi hotels.\n\nExplore the iconic Sheikh Zayed Grand Mosque with complimentary abayas provided for women. Cruise along the turquoise waters of the Abu Dhabi Corniche, visit the Breakwater Heritage Village showcasing pre-oil Bedouin life, stop for photos outside the gold-clad Emirates Palace hotel, and view the Presidential Palace Qasr Al Watan.",
                    'ar' => "استكشف معالم العاصمة أبوظبي الأبرز في جولة يومية متكاملة تشمل الاستقبال من الفندق في دبي أو الشارقة أو عجمان أو أبوظبي.\n\nزيارة تفصيلية لجامع الشيخ زايد الكبير مع توفير عبايات محتشمة للسيدات، والتجول على كورنيش أبوظبي والقرية التراثية، مع التقاط أروع الصور التذكارية أمام قصر الإمارات الشهير.",
                    'ru' => "Полный тур по столице Объединенных Арабских Эмиратов. Вы увидите главные символы города: Мечеть Шейха Зайда, набережную Корниш, легендарный отель Emirates Palace и традиционную деревню наследия.",
                ],
                'included_services' => [
                    'en' => ['Hotel pickup & drop-off in comfortable luxury vehicle', 'Licensed multilingual cultural tour guide', 'Grand Mosque entry & modest attire provided', 'Chilled water & local snacks during the tour', 'Payment after tour available'],
                    'ar' => ['توصيل ذهاب وعودة من الفندق بسيارة سياحية مريحة', 'مرشد سياحي معتمد ومتعدد اللغات', 'دخول جامع الشيخ زايد وتوفير عبايات نسائية', 'مياه مبردة وضيافة خفيفة طوال الرحلة', 'إمكانية الدفع بعد الجولة'],
                    'ru' => ['Трансфер из отеля и обратно', 'Лицензированный гид', 'Вход в мечеть и предоставление традиционной одежды', 'Питьевая вода в поездке'],
                ],
            ],
            [
                'slug' => 'fujairah-snoopy-island-snorkeling',
                'destination' => 'fujairah',
                'image' => 'fujairah.jpg',
                'price' => 85,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Fujairah East Coast Discovery & Snoopy Island Snorkeling Adventure',
                    'ar' => 'رحلة الساحل الشرقي بالفجيرة والغطس في جزيرة سنوبي ومسجد البدية التاريخي',
                    'ru' => 'Тур на Индийский океан в Фуджейру: Снорклинг у острова Снупи и пляжный отдых',
                ],
                'summary' => [
                    'en' => 'Escape to the Indian Ocean! Cross the dramatic Hajar Mountains, snorkel with sea turtles around iconic Snoopy Island, visit the 15th-century Al Bidyah Mosque, and relax on Sandy Beach.',
                    'ar' => 'اهرب إلى شواطئ المحيط الهندي الخلابة! اعبر جبال الحجر الساحرة، ومارس السباحة والسنوركلنج مع السلاحف البحرية حول جزيرة سنوبي، وزر أقدم مساجد الإمارات.',
                    'ru' => 'Поездка на побережье Индийского океана: снорклинг среди кораллов и морских черепах возле острова Снупи, горы Хаджар и древняя мечеть.',
                ],
                'description' => [
                    'en' => "Discover the only UAE emirate located on the Gulf of Oman with our Fujairah East Coast excursion. Travel through picturesque mountain passes and oasis towns.\n\nSnorkel in crystal-clear coastal waters surrounding Snoopy Island, famous for abundant marine life, vibrant coral reefs, and frequent sea turtle encounters. Visit the UAE’s oldest standing mosque, Al Bidyah Mosque, and Khorfakkan amphitheater waterfall, finishing with beachfront relaxation at a 5-star ocean resort.",
                    'ar' => "اكتشف الإمارة الوحيدة المطلة على خليج عمان وبحر العرب مع جولة الفجيرة والساحل الشرقي.\n\nاستمتع بالسنوركلينج والسباحة في مياه جزيرة سنوبي الشفافة الغنية بالشعاب المرجانية والسلاحف البحرية، ثم زيارة أقدم مسجد تاريخي في الإمارات مسجد البدية وشلال مدرج خورفكان الساحر.",
                    'ru' => "Прекрасный отдых на чистейших пляжах Фуджейры. Прогулка на лодке, аренда масок и ласт для снорклинга у знаменитого острова Снупи, знакомство с древней архитектурой и водопадом в Хорфаккане.",
                ],
                'included_services' => [
                    'en' => ['Roundtrip luxury transfer from Dubai, Sharjah or Ajman', 'Full snorkeling equipment (masks, fins, life vests)', 'Resort beach & pool day access', 'Scenic mountain photo stops & Al Bidyah Mosque visit', 'Chilled refreshments & water'],
                    'ar' => ['توصيل سياحي فاخر ذهاب وعودة من دبي والشارقة وعجمان', 'معدات السنوركلينج والسباحة بالكامل', 'دخول شاطئ ومسابح المنتجع الشاطئي', 'جولة جبلية وزيارة مسجد البدية الأثري', 'مشروبات ومياه معدنية مبردة'],
                    'ru' => ['Трансфер из отеля и обратно', 'Снаряжение для снорклинга', 'Доступ на пляж и бассейн отеля', 'Питьевая вода'],
                ],
            ],
            [
                'slug' => 'ajman-al-zorah-mangrove-kayak',
                'destination' => 'ajman',
                'image' => 'ajman.jpg',
                'price' => 50,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Ajman Al Zorah Mangroves Eco-Kayak Tour & Flamingo Lagoon Sanctuary',
                    'ar' => 'جولة التجديف بالكاياك في محمية الزوراء بعجمان وملاذ طيور الفلامنجو الطبيعي',
                    'ru' => 'Эко-тур на каяках по мангровым лесам Аль-Зора в Аджмане с фламинго',
                ],
                'summary' => [
                    'en' => 'Paddle through tranquil turquoise mangrove canals in the protected Al Zorah Nature Reserve, spotting pink flamingos, herons, and marine biodiversity with expert eco-guides.',
                    'ar' => 'جدف بقارب الكاياك عبر قنوات القرم الفيروزية الهادئة في محمية الزوراء الطبيعية بعجمان، واستمتع بمشاهدة أسراب الفلامنجو الوردية والطيور المهاجرة.',
                    'ru' => 'Увлекательный каякинг по тихим лагунам среди мангровых лесов заповедника Аль-Зора. Уникальная возможность увидеть розовых фламинго в естественной среде обитания.',
                ],
                'description' => [
                    'en' => "Experience the serene and untouched natural beauty of Ajman in the Al Zorah Nature Reserve, a designated Ramsar wetland of international importance.\n\nGuided by professional eco-instructors, paddle peaceful sit-on-top kayaks through narrow winding channels bordered by dense gray mangroves. Observe over 60 bird species including magnificent pink flamingos, kingfishers, and egrets in an oasis of peace just minutes away from urban bustle.",
                    'ar' => "عش تجربة الطبيعة الهادئة والتنوع البيئي في محمية الزوراء الطبيعية بإمارة عجمان المصنفة عالمياً ضمن أهم المناطق الرطبة.\n\nبرفقة مدربين محترفين، خض تجربة الكاياك الآمنة والممتعة بين أشجار القرم الكثيفة وشاهد أكثر من 60 نوعاً من الطيور النادرة والأسماك الصغيرة في أجواء من الاسترخاء التام.",
                    'ru' => "Спокойное путешествие по нетронутой природе Аджмана. Мангровый заповедник Аль-Зора — это рай для птиц и любителей природы. Безопасные каяки, опытный гид-инструктор и потрясающие виды.",
                ],
                'included_services' => [
                    'en' => ['Single or double kayak & paddle rental', 'Life jackets & safety briefing', 'Expert nature eco-guide', 'Bottled water & waterproof phone pouch', 'Free parking & shower facilities'],
                    'ar' => ['قارب كاياك فردي أو مزدوج مع المجاديف', 'سترات نجاة وتدريب أمان مسبق', 'مرشد بيئي متخصص', 'مياه معدنية وحافظة هاتف مضادة للماء', 'مواقف مجانية ومرافق استحمام'],
                    'ru' => ['Аренда каяков и спасательных жилетов', 'Услуги гида-инструктора', 'Питьевая вода', 'Раздевалки и душ'],
                ],
            ],
            [
                'slug' => 'umm-al-quwain-mangrove-beach-tour',
                'destination' => 'umm-al-quwain',
                'image' => 'umm_al_quwain.jpg',
                'price' => 45,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Umm Al Quwain Mangrove Beach Nature Escape & Coastal Boardwalk Day',
                    'ar' => 'رحلة شاطئ القرم الساحر بأم القيوين: ممشى الطبيعة الخشبي والاسترخاء الساحلي',
                    'ru' => 'Тур на Мангровый Пляж Умм-эль-Кайвайн: Деревянный променад и релакс на море',
                ],
                'summary' => [
                    'en' => 'Unwind on the pristine shores of Umm Al Quwain Mangrove Beach with its scenic wooden walkways stretching over shallow turquoise waters, coastal birdwatching, and pure tranquility.',
                    'ar' => 'استمتع بالهدوء التام على رمال شاطئ القرم الذهبية في أم القيوين، وتجول على الممشى الخشبي الممتد فوق المياه الفيروزية الصافية وسط بيئة طبيعية نقية.',
                    'ru' => 'Отдых на живописном Мангровом пляже в Умм-эль-Кайвайне с деревянными мостиками над лазурной водой, чистым песчаным берегом и умиротворением.',
                ],
                'description' => [
                    'en' => "Discover the UAE's hidden seaside sanctuary at Umm Al Quwain Mangrove Beach. Known for its laid-back atmosphere, gentle tidal waves, and extensive wooden promenades elevated above coastal mangrove canopies.\n\nPerfect for families and nature lovers wanting an unhurried day away from busy cities. Enjoy beach lounging, shallow swimming safe for children, scenic photography on the boardwalks, and fresh coastal seafood dining.",
                    'ar' => "اكتشف الملاذ الشاطئي الهادئ في شاطئ القرم بإمارة أم القيوين، المكان المثالي للعوائل للاستمتاع بالطبيعة البكر والمياه الضحلة الآمنة للأطفال.\n\nتأمل جمال الممشى الخشبي الممتد فوق غابات المانجروف، والتقط أجمل الصور التذكارية واستمتع بنسيم البحر العليل.",
                    'ru' => "Прекрасное место для семейного умиротворенного отдыха. Неглубокое теплое море, экологические деревянные дорожки среди мангровых зарослей, свежий бриз и уединенные пляжи.",
                ],
                'included_services' => [
                    'en' => ['Roundtrip transfer from hotel', 'Mangrove Beach entry passes', 'Beach sun loungers & umbrellas', 'Coastal nature walking tour', 'Chilled water & soft beverages'],
                    'ar' => ['توصيل ذهاب وعودة من الفندق', 'تذاكر دخول شاطئ القرم', 'كراسي ومظلات شاطئية مريحة', 'جولة مشي على الممشى الخشبي البيئي', 'مشروبات ومياه مبردة'],
                    'ru' => ['Трансфер из отеля и обратно', 'Входные билеты на пляж', 'Шезлонги и зонтики', 'Прохладительные напитки'],
                ],
            ],
            [
                'slug' => 'al-ain-oasis-jebel-hafeet-tour',
                'destination' => 'al-ain',
                'image' => 'al_ain.jpg',
                'price' => 75,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Al Ain Garden City Tour: Jebel Hafeet Summit, UNESCO Oasis & Al Jahili Fort',
                    'ar' => 'جولة مدينة العين التاريخية: قمة جبل حفيت، واحة العين للتراث العالمي وقلعة الجاهلي',
                    'ru' => 'Экскурсия в Аль-Айн: Вершина Джебель Хафит, Оазис ЮНЕСКО и Форт Аль-Джахили',
                ],
                'summary' => [
                    'en' => 'Journey to the ancient green oasis of Al Ain! Drive up the winding mountain highway to Jebel Hafeet peak (1,240m), stroll beneath 147,000 date palms in the UNESCO Oasis, and tour 19th-century desert forts.',
                    'ar' => 'انطلق إلى عاصمة الواحات والجمال الطبيعي مدينة العين: اصعد طريق جبل حفيت الجبلي الشاهق، وتجول بين 147 ألف نخلة في واحة العين التراثية وقلعة الجاهلي العريقة.',
                    'ru' => 'Увлекательный тур в город-оазис Аль-Айн: подъем на вершину горы Джебель Хафит (1240 м), прогулка по тенистым аллеям финиковых пальм оазиса ЮНЕСКО и старинным фортам.',
                ],
                'description' => [
                    'en' => "Travel across red desert highways to Al Ain, the ancestral home of the UAE's founding father Sheikh Zayed bin Sultan Al Nahyan.\n\nDrive along one of the world's most famous driving roads ascending Jebel Hafeet for panoramic views stretching into the Empty Quarter desert. Relax at Green Mubazzarah hot springs, walk through the serene shade of Al Ain Oasis with its ancient Falaj gravity irrigation system, and explore the historic towers of Al Jahili Fort and Qasr Al Muwaiji.",
                    'ar' => "رحلة إلى قلب الأصالة والتاريخ الإماراتي في مدينة العين الخضراء.\n\nاصعد أحد أشهر الطرق الجبلية عالمياً إلى قمة جبل حفيت للاستمتاع بإطلالة بانورامية ساحرة، ثم الاسترخاء عند ينابيع المبزرة الخضراء الكبريتية، والتجول في واحة العين التاريخية بنظام الأفلاج التراثي وقلعة الجاهلي الشامخة.",
                    'ru' => "Путешествие в колыбель истории ОАЭ. Захватывающий серпантин на гору Джебель Хафит, целебные горячие источники Зеленой Мубаззары, тенистые аллеи финикового оазиса и величественные глинобитные крепости.",
                ],
                'included_services' => [
                    'en' => ['Private or small group luxury transfer from Dubai/Abu Dhabi', 'Licensed historical and cultural tour guide', 'Jebel Hafeet mountain summit drive & photo stop', 'Al Ain Oasis & Al Jahili Fort entry', 'Traditional lunch & mineral water'],
                    'ar' => ['توصيل سياحي مريح ذهاب وعودة من دبي أو أبوظبي', 'مرشد سياحي ثقافي وتاريخي معتمد', 'صعود قمة جبل حفيت والوقوف للتصوير', 'دخول واحة العين وقلعة الجاهلي', 'وجبة غداء تراثية ومياه معدنية'],
                    'ru' => ['Комфортный трансфер на весь день', 'Русскоговорящий лицензированный гид', 'Подъем на вершину Джебель Хафит', 'Вход в оазис и форт Аль-Джахили', 'Обед и питьевая вода'],
                ],
            ],
            [
                'slug' => 'hatta-mountain-dam-kayak-adventure',
                'destination' => 'hatta',
                'image' => 'hatta.jpg',
                'price' => 60,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Hatta Mountain Safari: Hatta Dam Kayak, Wadi Hub Adventure & Heritage Village',
                    'ar' => 'مغامرة حتا الجبلية: تجديف كاياك سد حتا، قرية حتا التراثية ومنتزه وادي هب',
                    'ru' => 'Горное приключение в Хатте: Каякинг на плотине Хатта Дам и Вади Хаб',
                ],
                'summary' => [
                    'en' => 'Experience Dubai’s rugged mountain paradise! Kayak on the turquoise waters of Hatta Dam enclosed by jagged Hajar peaks, explore the 3,000-year-old Hatta Heritage Village, and try outdoor wadi activities.',
                    'ar' => 'عش أروع مغامرة في محمية دبي الجبلية بحتا: جدف بقوارب الكاياك في بحيرة سد حتا الفيروزية المحاطة بالجبال الشاهقة، واستكشف قرية حتا التراثية وأنشطة وادي هب المثيرة.',
                    'ru' => 'Горный оазис посреди скал: каякинг по зеркальной глади бирюзового озера плотины Хатта, старинная крепость и центр активного отдыха Hatta Wadi Hub.',
                ],
                'description' => [
                    'en' => "Journey into the rocky highlands of the Hajar Mountains to Hatta, Dubai’s picturesque mountain sanctuary.\n\nGlide across the crystal turquoise waters of Hatta Dam in a kayak or pedal boat flanked by towering mountain peaks. Discover traditional mountain life at Hatta Heritage Village with its restored watchtowers and clay houses, and visit Hatta Wadi Hub for optional mountain biking, archery, and ziplining before returning comfortably to Dubai.",
                    'ar' => "انطلق في رحلة جبلية منعشة إلى حتا، ملاذ الطبيعة الجبلية الساحر التابع لإمارة دبي.\n\nاستمتع بالتجديف في بحيرة سد حتا الهادئة المحاطة بقمم الجبال الوعرة، وزر قرية حتا التراثية بأبراج المراقبة التاريخية وبيوت الطين العتيقة، مع فرصة ممارسة الأنشطة الترفيهية في وادي هب.",
                    'ru' => "Прекрасный побег от шума мегаполиса в горы Хаджар. Прогулка на каяках или катамаранах по чистейшему озеру дамбы Хатта, осмотр сторожевых башен древней деревни и свежий горный воздух.",
                ],
                'included_services' => [
                    'en' => ['Roundtrip luxury transfer from Dubai hotel', 'Hatta Dam kayak or pedal boat rental ticket', 'Hatta Heritage Village & Fort visit', 'Scenic Hajar Mountain road drive & photo stops', 'Chilled water & refreshments'],
                    'ar' => ['توصيل ذهاب وعودة من فندقكم بدبي بسيارة VIP', 'تذكرة قارب الكاياك أو البدال في بحيرة سد حتا', 'زيارة قرية حتا التراثية والحصن الأثري', 'جولة عبر المناظر الجبلية مع وقفات للتصوير', 'مياه مبردة وضيافة منعشة'],
                    'ru' => ['Трансфер из отеля Дубая и обратно', 'Аренда каяка на плотине Хатта Дам', 'Посещение исторической деревни Хатта', 'Питьевая вода'],
                ],
            ],
            [
                'slug' => 'sharjah-cultural-heritage-al-noor',
                'destination' => 'sharjah',
                'image' => 'sharjah.jpg',
                'price' => 40,
                'days' => 1,
                'custom_name' => [
                    'en' => 'Sharjah Cultural Capital Tour: Museum of Islamic Civilization & Al Noor Island',
                    'ar' => 'جولة الشارقة عاصمة الثقافة: متحف الحضارة الإسلامية وجزيرة النور الساحرة',
                    'ru' => 'Культурный тур по Шардже: Музей исламской цивилизации и остров Аль-Нур',
                ],
                'summary' => [
                    'en' => 'Immerse yourself in authentic Arabian arts and architecture in Sharjah! Tour the world-class Museum of Islamic Civilization, walk through the lush gardens and butterfly house of Al Noor Island, and browse the Blue Souk.',
                    'ar' => 'انغمس في أصالة الفنون والعمارة الإسلامية في الشارقة: زر متحف الحضارة الإسلامية العالمي، وتجول في حدائق جزيرة النور وبيت الفراشات والسوق المركزي الأزرق.',
                    'ru' => 'Познакомьтесь с культурной столицей арабского мира: уникальные экспонаты Музея исламской цивилизации, тропический дом бабочек на острове Аль-Нур и колоритный Голубой рынок.',
                ],
                'description' => [
                    'en' => "Explore Sharjah, recognized by UNESCO as the Cultural Capital of the Arab World. Located adjacent to Dubai, this tour reveals the true heart of Islamic art, craftsmanship, and coastal heritage.\n\nAdmire thousands of rare Islamic artifacts, astrolabes, manuscripts, and gold calligraphy at the Sharjah Museum of Islamic Civilization. Cross the pedestrian bridge to enchanting Al Noor Island with its landscaped sculpture gardens, tranquil literature pavilion, and exotic Butterfly House before exploring the Blue Souk (Central Market) with over 600 antique, rug, and jewelry shops.",
                    'ar' => "استكشف إمارة الشارقة العريقة المعترف بها من اليونسكو عاصمة للثقافة في العالم العربي.\n\nشاهد آلاف المخطوطات والتحف الفنية والأسطرلابات التاريخية في متحف الحضارة الإسلامية، ثم اعبر الجسر إلى جزيرة النور ذات الحدائق الخلابة وبيت الفراشات الاستوائي، واختتم الجولة في السوق الأزرق التراثي الشهير بالمجوهرات والسجاد الفاخر.",
                    'ru' => "Увлекательная экскурсия в эмират Шарджа, культурное сердце ОАЭ. Шедевры исламского искусства в главном музее цивилизации, прогулка по современному арт-острову Аль-Нур и шопинг на знаменитом Голубом рынке.",
                ],
                'included_services' => [
                    'en' => ['Hotel pickup & drop-off from Dubai, Sharjah or Ajman', 'Museum of Islamic Civilization admission ticket', 'Al Noor Island & Butterfly House entry pass', 'Licensed cultural tour guide', 'Bottled water & Arabic dates'],
                    'ar' => ['توصيل ذهاب وعودة من دبي أو الشارقة أو عجمان', 'تذكرة دخول متحف الحضارة الإسلامية', 'تذكرة دخول جزيرة النور وبيت الفراشات', 'مرشد سياحي ثقافي معتمد', 'مياه معدنية وضيافة تمور'],
                    'ru' => ['Трансфер из отеля и обратно', 'Билеты в музей и на остров Аль-Нур с домом бабочек', 'Лицензированный гид', 'Питьевая вода'],
                ],
            ],
        ];

        foreach ($packages as $data) {
            $destination = Destination::where('slug', $data['destination'])->first();

            $package = TourPackage::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'destination_id' => $destination->id,
                    'name' => $data['custom_name'] ?? $this->trans($data['key'].'_title'),
                    'summary' => $data['summary'] ?? ['en' => 'One of the most popular experiences in the UAE.'],
                    'description' => $data['description'] ?? ['en' => 'Enjoy a memorable experience with hotel pickup, a professional guide and skip-the-line access. Suitable for families, couples and solo travellers alike.'],
                    'price' => $data['price'],
                    'duration_days' => $data['days'],
                    'duration_nights' => 0,
                    'max_guests' => 20,
                    'included_services' => $data['included_services'] ?? ['en' => ['Hotel pickup & drop-off', 'Professional guide', 'Entry tickets']],
                    'excluded_services' => $data['excluded_services'] ?? ['en' => ['Personal expenses', 'Meals unless stated']],
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
                    'title' => ['en' => 'Tour day experience'],
                    'description' => ['en' => 'Hotel pickup, fully guided landmark experience and comfortable return transfer.'],
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
            [
                'slug' => 'palm-royale-resort',
                'destination' => 'dubai',
                'stars' => 5,
                'image' => 'dubai.jpg',
                'name' => [
                    'en' => 'Palm Royale Luxury Beach Resort & Spa Dubai',
                    'ar' => 'منتجع بالم رويال الفاخر والسبا بنخلة جميرا دبي',
                    'ru' => 'Курортный Отель Palm Royale Resort & Spa на Пальме Дубай',
                ],
                'description' => [
                    'en' => "Nestled on the iconic Palm Jumeirah archipelago, Palm Royale Resort offers quintessential 5-star Arabian luxury. Features pristine private white-sand beach access, infinity pools overlooking Dubai Marina skyline, Michelin-starred dining, and an opulent holistic spa retreat.",
                    'ar' => "يقع منتجع بالم رويال الفاخر على هلال نخلة جميرا الأيقوني، ويوفر إقامة 5 نجوم استثنائية مع شاطئ رملي خاص، مسابح لامتناهية تطل على أفق دبي مارينا، ومطاعم عالمية راقية وسبا علاجي متكامل.",
                    'ru' => "Роскошный 5-звездочный курортный отель на острове Пальма Джумейра с собственным песчаным пляжем, видовыми бассейнами с панорамой на Дубай Марину, ресторанами высокой кухни и премиальным спа.",
                ],
                'address' => 'The Crescent, Palm Jumeirah, Dubai, United Arab Emirates',
                'rooms' => [
                    [
                        'name' => ['en' => 'Deluxe Sea View Room', 'ar' => 'غرفة ديلوكس بإطلالة بحرية', 'ru' => 'Делюкс с видом на море'],
                        'price_per_night' => 240,
                        'capacity' => 2,
                        'quantity' => 20,
                    ],
                    [
                        'name' => ['en' => 'Royal Palm Suite with Private Pool', 'ar' => 'جناح بالم الملكي مع مسبح خاص', 'ru' => 'Королевский люкс с приватным бассейном'],
                        'price_per_night' => 580,
                        'capacity' => 4,
                        'quantity' => 8,
                    ],
                ],
            ],
            [
                'slug' => 'corniche-grand-hotel',
                'destination' => 'abu-dhabi',
                'stars' => 5,
                'image' => 'abu_dhabi.jpg',
                'name' => [
                    'en' => 'Corniche Grand 5-Star Waterfront Hotel Abu Dhabi',
                    'ar' => 'فندق كورنيش جراند الفاخر 5 نجوم الواجهة البحرية أبوظبي',
                    'ru' => 'Отель Corniche Grand Hotel 5 Звезд Абу-Даби',
                ],
                'description' => [
                    'en' => "Overlooking the azure waters of the Arabian Gulf and the manicured Abu Dhabi Corniche promenade, Corniche Grand Hotel combines regal Emirati hospitality with modern elegance. Steps away from business districts, luxury malls, and cultural landmarks.",
                    'ar' => "بإطلالة ساحرة على مياه الخليج العربي وكورنيش أبوظبي، يجمع فندق كورنيش جراند بين أصالة الضيافة الإماراتية وفخامة التصميم المعاصر، على بُعد دقائق من قصر الإمارات والمعالم الثقافية.",
                    'ru' => "Элегантный 5-звездочный отель на знаменитой набережной Корниш в Абу-Даби с видом на Персидский залив, роскошными номерами и близостью к главным достопримечательностям столицы.",
                ],
                'address' => 'Corniche Road West, Al Ras Al Akhdar, Abu Dhabi, United Arab Emirates',
                'rooms' => [
                    [
                        'name' => ['en' => 'Superior Gulf View Room', 'ar' => 'غرفة سوبريور مطلة على الخليج', 'ru' => 'Номер с видом на залив'],
                        'price_per_night' => 190,
                        'capacity' => 2,
                        'quantity' => 15,
                    ],
                    [
                        'name' => ['en' => 'Diplomatic Executive Suite', 'ar' => 'جناح تنفيذي دبلوماسي فاخر', 'ru' => 'Дипломатический люкс'],
                        'price_per_night' => 450,
                        'capacity' => 4,
                        'quantity' => 6,
                    ],
                ],
            ],
            [
                'slug' => 'heritage-boutique-stay',
                'destination' => 'sharjah',
                'stars' => 4,
                'image' => 'sharjah.jpg',
                'name' => [
                    'en' => 'Heritage House Boutique Hotel & Cultural Retreat Sharjah',
                    'ar' => 'فندق البيت التراثي بوتيك والواحة الثقافية بالشارقة',
                    'ru' => 'Бутик-Отель Heritage Boutique Stay в Шардже',
                ],
                'description' => [
                    'en' => "Immerse yourself in authentic Emirati cultural heritage within the restored historic district of Heart of Sharjah. Traditional coral stone architecture harmonizes with bespoke luxury furnishings, serene courtyard dining, and peaceful library lounges.",
                    'ar' => "عش عبق التاريخ وأصالة التراث الإماراتي في قلب الشارقة التاريخي. عمارة تراثية من الحجر المرجاني تمتزج بأرقى وسائل الراحة الحديثة، مع فناء أندلسي هادئ ومطاعم تراثية مميزة.",
                    'ru' => "Атмосферный бутик-отель в историческом сердце Шарджи. Традиционная архитектура из кораллового камня, уютные восточные дворики и премиальный комфорт для ценителей культуры.",
                ],
                'address' => 'Heart of Sharjah, Al Shiokh District, Sharjah, United Arab Emirates',
                'rooms' => [
                    [
                        'name' => ['en' => 'Heritage Traditional King Room', 'ar' => 'غرفة كينغ تراثية فاخرة', 'ru' => 'Традиционный номер King'],
                        'price_per_night' => 120,
                        'capacity' => 2,
                        'quantity' => 12,
                    ],
                    [
                        'name' => ['en' => 'Courtyard Heritage Suite', 'ar' => 'جناح الفناء التراثي الواسع', 'ru' => 'Люкс с выходом во дворик'],
                        'price_per_night' => 250,
                        'capacity' => 3,
                        'quantity' => 5,
                    ],
                ],
            ],
            [
                'slug' => 'jais-mountain-lodge',
                'destination' => 'ras-al-khaimah',
                'stars' => 4,
                'image' => 'rak.jpg',
                'name' => [
                    'en' => 'Jais Mountain Heights Luxury Adventure Lodge',
                    'ar' => 'نزل جبل جيس الجبلي الفاخر وملاذ المغامرات برأس الخيمة',
                    'ru' => 'Горный Лодж Jais Mountain Lodge в Рас-эль-Хайме',
                ],
                'description' => [
                    'en' => "Elevated 1,200 meters into the crisp, cool air of the Hajar Mountains in Ras Al Khaimah, Jais Mountain Lodge offers an extraordinary eco-luxury mountain escape. Minutes from the world's longest zipline and via ferrata trails.",
                    'ar' => "على ارتفاع 1200 متر في الهواء الجبلي النقي لجبال الحجر برأس الخيمة، يقدم نزل جبل جيس تجربة ضيافة جبلية بيئية فاخرة، بجوار أطول مسار انزلاقي ومسارات التسلق والمغامرات.",
                    'ru' => "Уникальный горный эко-лодж на высоте 1200 метров на вершине Джебель Джейс. Захватывающие виды на каньоны, чистый горный воздух и близость к зиплайну.",
                ],
                'address' => 'Jebel Jais Mountain Peak Road, Ras Al Khaimah, United Arab Emirates',
                'rooms' => [
                    [
                        'name' => ['en' => 'Mountain Vista Chalet', 'ar' => 'شاليه بإطلالة على قمم الجبال', 'ru' => 'Шале с видом на горы'],
                        'price_per_night' => 160,
                        'capacity' => 2,
                        'quantity' => 14,
                    ],
                    [
                        'name' => ['en' => 'Stargazer Luxury Villa', 'ar' => 'فيلا النجوم الجبلية الفاخرة', 'ru' => 'Вилла для наблюдения за звездами'],
                        'price_per_night' => 340,
                        'capacity' => 4,
                        'quantity' => 4,
                    ],
                ],
            ],
        ];

        foreach ($hotels as $data) {
            $destination = Destination::where('slug', $data['destination'])->first();

            $hotel = Hotel::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'destination_id' => $destination->id,
                    'name' => $data['name'],
                    'star_rating' => $data['stars'],
                    'description' => $data['description'],
                    'address' => $data['address'],
                    'status' => true,
                ]
            );

            if (! $hotel->hasMedia('featured')) {
                $hotel->addMedia(public_path('assets/images/'.$data['image']))
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }

            $hotel->amenities()->sync($amenities->random(5)->pluck('id'));

            // Clear & re-seed rooms with multilingual names
            $hotel->rooms()->delete();
            foreach ($data['rooms'] as $roomData) {
                $hotel->rooms()->create([
                    'name' => $roomData['name'],
                    'price_per_night' => $roomData['price_per_night'],
                    'capacity' => $roomData['capacity'],
                    'quantity' => $roomData['quantity'],
                    'status' => true,
                ]);
            }
        }
    }

    private function seedTransports(): void
    {
        $transports = [
            [
                'slug' => 'luxury-sedan',
                'type' => TransportType::Car,
                'capacity' => 3,
                'price' => 120,
                'name' => [
                    'en' => 'VIP Luxury Chauffeur Sedan (Mercedes S-Class / BMW 7)',
                    'ar' => 'سيارة سيدان VIP فارهة مع سائق خاص (مرسيدس الفئة S)',
                    'ru' => 'VIP Седан с Личным Водителем (Mercedes S-Class)',
                ],
                'description' => [
                    'en' => 'Executive chauffeured transfers across Dubai, Abu Dhabi, and the UAE with complimentary bottled water, leather interiors, and flight tracking.',
                    'ar' => 'خدمة توصيل كبار الشخصيات مع سائق خاص في دبي وأبوظبي والإمارات بسيارات مرسيدس حديثة ومكيفة مع ضيافة مجانية.',
                    'ru' => 'Премиальные поездки по Дубаю и ОАЭ с личным водителем на автомобилях представительского класса.',
                ],
            ],
            [
                'slug' => 'family-van',
                'type' => TransportType::Van,
                'capacity' => 7,
                'price' => 180,
                'name' => [
                    'en' => 'Luxury Family Minivan (Mercedes V-Class VIP)',
                    'ar' => 'فان عائلي فاخر 7 ركاب لكبار الشخصيات (مرسيدس V-Class)',
                    'ru' => 'Семейный Минивэн Люкс (Mercedes V-Class 7 мест)',
                ],
                'description' => [
                    'en' => 'Spacious 7-seater luxury minivan ideal for GCC family holidays, shopping tours to Dubai Mall, and intercity UAE transfers with ample luggage space.',
                    'ar' => 'فان عائلي فسيح وفاخر مثالي للعوائل الخليجية وجولات التسوق في دبي مول مع مساحة واسعة للأمتعة وخدمة راقية.',
                    'ru' => 'Просторный комфортабельный минивэн для семейных путешествий, шопинга и трансферов между городами ОАЭ.',
                ],
            ],
            [
                'slug' => 'tour-coach',
                'type' => TransportType::Bus,
                'capacity' => 45,
                'price' => 450,
                'name' => [
                    'en' => 'Executive Luxury Tour Coach (45 Seater)',
                    'ar' => 'حافلة سياحية فاخرة 45 راكب للوفود والمجموعات',
                    'ru' => 'Туристический Автобус Люкс (45 мест)',
                ],
                'description' => [
                    'en' => 'Modern 45-passenger tour bus with onboard PA system, reclining seats, panoramic windows, and experienced professional driver for group sightseeing.',
                    'ar' => 'حافلة سياحية متطورة ومريحة تتسع لـ 45 راكباً مع مقاعد جلدية قابلة للميلان ونظام صوتي متكامل للرحلات الجماعية.',
                    'ru' => 'Комфортабельный туристический автобус для групповых экскурсий и корпоративных мероприятий.',
                ],
            ],
            [
                'slug' => 'domestic-flight',
                'type' => TransportType::Flight,
                'capacity' => 6,
                'price' => 250,
                'name' => [
                    'en' => 'Dubai Scenic Helicopter & Private Aerial Tour',
                    'ar' => 'جولة هليكوبتر وطيران بانورامي خاص فوق معالم دبي',
                    'ru' => 'Вертолетная Экскурсия над Дубаем и Пальмой Джумейра',
                ],
                'description' => [
                    'en' => 'Breathtaking 12 to 22-minute aerial helicopter flights over Burj Khalifa, Palm Jumeirah, Burj Al Arab, and the Dubai coastline.',
                    'ar' => 'رحلات جوية استثنائية بالهليكوبتر فوق برج خليفة، نخلة جميرا، برج العرب وساحل دبي الخلاب.',
                    'ru' => 'Захватывающие дух полеты на вертолете над Бурдж Халифа, Пальмой и побережьем Персидского залива.',
                ],
            ],
            [
                'slug' => 'airport-pickup',
                'type' => TransportType::Pickup,
                'capacity' => 3,
                'price' => 60,
                'name' => [
                    'en' => 'Dubai Airport (DXB/DWC) VIP Meet & Greet Chauffeur Transfer',
                    'ar' => 'استقبال وتوصيل مطار دبي الدولي VIP مع سائق خاص',
                    'ru' => 'VIP Трансфер из Аэропорта Дубая (DXB / DWC) в Отель',
                ],
                'description' => [
                    'en' => 'Fast, stress-free direct airport arrival transfers from DXB or DWC terminal straight to your hotel with 60 minutes free flight delay waiting time.',
                    'ar' => 'خدمة استقبال فوري وخاص عند بوابة الوصول بمطار دبي الدولي، مع مساعدة بالأمتعة وتوصيل مباشر للفندق.',
                    'ru' => 'Встреча с табличкой в зале прилета, помощь с багажом и прямой комфортный трансфер до вашего отеля.',
                ],
            ],
        ];

        foreach ($transports as $data) {
            $transport = Transport::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'capacity' => $data['capacity'],
                    'price' => $data['price'],
                    'price_unit' => $data['type'] === TransportType::Flight ? 'per_person' : 'per_day',
                    'status' => true,
                ]
            );

            if (! $transport->hasMedia('featured')) {
                $imgName = match ($data['slug']) {
                    'tour-coach' => 'transport_coach.jpg',
                    'family-van' => 'transport_van.jpg',
                    default => 'transport_sedan.jpg',
                };
                if (file_exists(public_path('assets/images/'.$imgName))) {
                    $transport->addMedia(public_path('assets/images/'.$imgName))
                        ->preservingOriginal()
                        ->toMediaCollection('featured');
                }
            }
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
                'question' => [
                    'en' => 'Do I need a tourist visa to visit Dubai and the UAE?',
                    'ar' => 'هل أحتاج إلى تأشيرة سياحية لزيارة دبي ودولة الإمارات؟',
                    'ru' => 'Нужна ли туристическая виза для посещения Дубая и ОАЭ?',
                ],
                'answer' => [
                    'en' => 'Citizens of GCC nations (Saudi Arabia, Kuwait, Qatar, Bahrain, Oman), UK, EU, USA, and over 70 nationalities receive a free visa-on-arrival in the UAE. For other passport holders, our team provides assistance with quick 30 or 60-day tourist e-visas before travelling.',
                    'ar' => 'يحصل مواطنو دول مجلس التعاون الخليجي، وبريطانيا ودول الاتحاد الأوروبي وأمريكا وأكثر من 70 دولة على تأشيرة دخول مجانية عند الوصول لمطارات دبي والإمارات. كما يقدم فريقنا الدعم لإصدار التأشيرات السياحية الإلكترونية السريعة لبقية الجنسيات.',
                    'ru' => 'Гражданам РФ, стран СНГ, ЕС и более 70 стран виза оформляется бесплатно по прилету на срок от 30 до 90 дней. Для граждан других государств доступно быстрое онлайн-оформление туристической визы.',
                ],
            ],
            [
                'question' => [
                    'en' => 'What is the best time of year to visit Dubai for tours and outdoor activities?',
                    'ar' => 'ما هو أفضل وقت في السنة لزيارة دبي وحجز الرحلات والأنشطة الخارجية؟',
                    'ru' => 'В какое время года лучше всего приезжать в Дубай на экскурсии?',
                ],
                'answer' => [
                    'en' => 'November through April is the peak tourism season, offering pleasant sunny weather with temperatures between 22°C and 30°C — ideal for desert safaris, private yacht cruises, and outdoor sightseeing. Year-round air-conditioned indoor attractions like Burj Khalifa, Dubai Mall, and luxury resorts are open 365 days.',
                    'ar' => 'تعد الفترة من نوفمبر إلى أبريل أفضل موسم سياحي في دبي مع طقس مشمس ومعتدل (22 إلى 30 درجة مئوية)، وهو التوقيت المثالي لرحلات السفاري واليخوت والجولات. كما أن المعالم الداخلية كبرج خليفة ودبي مول مكيفة بالكامل ومفتوحة طوال العام.',
                    'ru' => 'Период с ноября по апрель считается лучшим туристическим сезоном в Дубае с комфортной температурой 22–30°C для сафари, яхтинга и экскурсий. Все ключевые закрытые комплексы и Бурдж Халифа работают круглый год.',
                ],
            ],
            [
                'question' => [
                    'en' => 'What is your cancellation and booking rescheduling policy?',
                    'ar' => 'ما هي سياسة الإلغاء واسترداد الأموال وتعديل المواعيد؟',
                    'ru' => 'Каковы условия отмены бронирования и возврата средств?',
                ],
                'answer' => [
                    'en' => 'We offer 100% free cancellation and instant full refunds up to 24 hours prior to scheduled departure. You can easily modify your tour date or cancel with one click from your personal booking dashboard.',
                    'ar' => 'نوفر إلغاء مجاني 100% واسترداد كامل للمبلغ حتى 24 ساعة قبل موعد انطلاق الجولة، مع إمكانية تعديل تاريخ الرحلة بنقرة واحدة عبر لوحة تحكم حسابك.',
                    'ru' => 'Мы предоставляем 100% бесплатную отмену и полный возврат средств при отмене не менее чем за 24 часа до начала экскурсии через личный кабинет.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Are your tour packages family-friendly and are Arabic/Russian guides available?',
                    'ar' => 'هل تناسب بكجاتكم السياحية العوائل والأطفال وهل يتوفر مرشدون يتحدثون العربية؟',
                    'ru' => 'Подходят ли экскурсии для семей с детьми и есть ли русскоговорящие гиды?',
                ],
                'answer' => [
                    'en' => 'Yes! All our curated packages are tailored for families, couples, and GCC travelers with child safety seats and private luxury vehicles. Licensed multilingual tour guides fluent in Arabic, Russian, and English are provided upon request at no extra fee.',
                    'ar' => 'نعم بالتأكيد! صُممت جميع برامجنا السياحية لتلائم العوائل الخليجية وكبار الشخصيات مع سيارات VIP خاصة ومقاعد للأطفال، ونوفر مرشدين سياحيين مرخصين يتحدثون العربية بطلاقة وبدون أي تكلفة إضافية.',
                    'ru' => 'Да, все программы адаптированы для комфортного семейного отдыха. Лицензированные русскоговорящие гиды и детские кресла предоставляются по запросу бесплатно.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Is hotel pickup and drop-off included in all Dubai tour packages?',
                    'ar' => 'هل يشمل سعر الجولة خدمة التوصيل والاستقبال من باب الفندق؟',
                    'ru' => 'Включен ли трансфер из отеля в стоимость туров?',
                ],
                'answer' => [
                    'en' => 'Yes, every luxury tour package and desert safari includes complimentary private or semi-private door-to-door transfer in an air-conditioned luxury vehicle from any hotel or residence in Dubai or Sharjah.',
                    'ar' => 'نعم، تتضمن جميع باقاتنا السياحية ورحلات السفاري خدمة الاستقبال والتوصيل من باب مقر إقامتكم في دبي والشارقة بسيارات حديثة ومكيفة.',
                    'ru' => 'Да, во все пакеты экскурсий и сафари включен трансфер туда и обратно от вашего отеля в Дубае или Шардже на комфортабельном авто.',
                ],
            ],
        ];

        // Re-seed FAQs with full multilingual SEO
        Faq::truncate();
        foreach ($faqs as $order => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'sort_order' => $order,
                'status' => true,
            ]);
        }
    }

    private function seedGallery(): void
    {
        $album = Album::updateOrCreate(
            ['slug' => 'uae-highlights'],
            [
                'name' => [
                    'en' => 'Dubai & UAE Highlights: Luxury Tours & Landmarks Gallery',
                    'ar' => 'أبرز معالم دبي والإمارات: ألبوم الرحلات الفاخرة والمعالم الأيقونية',
                    'ru' => 'Главные Достопримечательности Дубая и ОАЭ: Фотогалерея Туров',
                ],
                'description' => [
                    'en' => 'Explore high-resolution photography and 4K visual tours of Dubai Burj Khalifa, desert safaris, private yachts in Dubai Marina, Palm Jumeirah, and iconic UAE landmarks.',
                    'ar' => 'استكشف معرض الصور عالي الدقة وجولات 4K لأبرز معالم دبي: برج خليفة، سفاري الكثبان الرملية، يخوت دبي مارينا، نخلة جميرا وأرقى المعالم السياحية.',
                    'ru' => 'Эксклюзивная фотогалерея премиальных экскурсий в Дубае: Бурдж Халифа, сафари в пустыне, аренда яхт в Дубай Марине и остров Пальма Джумейра.',
                ],
                'status' => true,
                'sort_order' => 0,
            ]
        );

        if (! $album->hasMedia('images')) {
            foreach (['hero.jpg', 'dubai.jpg', 'abu_dhabi.jpg', 'sharjah.jpg', 'rak.jpg'] as $image) {
                if (file_exists(public_path('assets/images/'.$image))) {
                    $album->addMedia(public_path('assets/images/'.$image))
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
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

    private function seedPosts(): void
    {
        $category = BlogCategory::firstOrCreate(
            ['slug' => 'travel-guides'],
            ['name' => ['en' => 'Travel Guides', 'ar' => 'أدلة السفر', 'ru' => 'Путеводители']]
        );

        $user = User::first();

        // 1. Burj Khalifa Comparison Guide
        $post1 = Post::updateOrCreate(
            ['slug' => 'burj-khalifa-124-vs-148-floor-tickets-guide'],
            [
                'user_id' => $user?->id ?? 1,
                'blog_category_id' => $category->id,
                'title' => [
                    'en' => 'Burj Khalifa At The Top: 124th vs 125th vs 148th Sky Lounge Ticket Comparison Guide 2026',
                    'ar' => 'مقارنة تذاكر برج خليفة: الطابق 124 و125 مقابل الطابق 148 سكاي لاونج 2026',
                    'ru' => 'Бурдж Халифа: Сравнение Билетов на 124, 125 и 148 Этажи (SKY Lounge) 2026',
                ],
                'excerpt' => [
                    'en' => 'Comparing Burj Khalifa Level 124/125 At The Top vs Level 148 At The Top SKY. Discover ticket prices, view differences, sunset peak hours, and VIP skip-the-line privileges.',
                    'ar' => 'دليل شامل لمقارنة تذاكر صعود برج خليفة: الطابق 124 و125 مقابل طابق 148 سكاي. مقارنة الأسعار، أفضل أوقات الغروب، ومميزات الدخول السريع VIP.',
                    'ru' => 'Сравнение билетов на Бурдж Халифа: обычные 124–125 этажи или VIP уровень 148 SKY Lounge. Цены, очереди, закатные часы и лучшие виды.',
                ],
                'content' => [
                    'en' => "<h2>Choosing Your Burj Khalifa Observation Deck: 124th Floor vs 148th Floor</h2>\n<p>Standing at a staggering 828 metres (2,716.5 feet), the Burj Khalifa is the undisputed crown jewel of Dubai's skyline. When booking tickets, travelers encounter a common dilemma: <strong>Should you choose 'At The Top' (Levels 124 & 125) or invest in 'At The Top SKY' (Level 148)?</strong></p>\n<h3>1. At The Top: Levels 124 & 125</h3>\n<p>Located at 452 metres above ground, Levels 124 and 125 represent the most popular tier with outdoor open-air terrace access and high-powered digital telescopes.</p>\n<h3>2. At The Top SKY: Level 148</h3>\n<p>Positioned at 555 metres, Level 148 offers VIP luxury lounge reception, dedicated express elevators bypassing queues, and complimentary 5-star Arabic refreshments.</p>\n<p><a href='/en/packages/burj-khalifa-at-the-top'><strong>Book Burj Khalifa Tickets Online &rarr;</strong></a></p>",
                ],
                'meta_title' => 'Burj Khalifa 124 vs 148 Floor Tickets: Complete 2026 Comparison Guide',
                'meta_description' => 'Unsure which Burj Khalifa ticket to buy? Compare Level 124/125 At The Top vs Level 148 SKY. View ticket prices, elevator wait times, and VIP inclusions.',
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(2),
            ]
        );

        if (! $post1->hasMedia('featured') && file_exists(public_path('assets/images/tour_burj.jpg'))) {
            $post1->addMedia(public_path('assets/images/tour_burj.jpg'))->preservingOriginal()->toMediaCollection('featured');
        }

        // 2. Top 10 Best Dubai Tours Guide
        $post2 = Post::updateOrCreate(
            ['slug' => 'top-10-best-dubai-tours-experiences-ranked'],
            [
                'user_id' => $user?->id ?? 1,
                'blog_category_id' => $category->id,
                'title' => [
                    'en' => 'Top 10 Best Dubai Tours & Luxury UAE Experiences Ranked for 2026',
                    'ar' => 'أفضل 10 رحلات وبكجات سياحية في دبي والإمارات لعام 2026 مع الأسعار',
                    'ru' => 'Топ-10 Лучших Экскурсий и Туров в Дубае 2026: Рейтинг и Цены',
                ],
                'excerpt' => [
                    'en' => 'Discover the top 10 highest-rated Dubai tour packages, desert safaris, helicopter flights, and cultural experiences ranked by over 10,000 satisfied luxury travelers.',
                    'ar' => 'اكتشف أرقى 10 جولات وبكجات سياحية في دبي والإمارات: سفاري VIP، يخوت مارينا، برج خليفة، وجلسات تصوير الفستان الطائر بأسعار حصرية.',
                    'ru' => 'Рейтинг 10 лучших туров и экскурсий в Дубае: VIP сафари на джипах, аренда яхт, билеты на Бурдж Халифа и полеты на вертолете.',
                ],
                'content' => [
                    'en' => "<h2>Ranked: The 10 Most Spectacular Dubai Tour Experiences for 2026</h2>\n<p>Dubai is a world capital of superlatives — from the tallest architectural towers to endless golden sand dunes and mega-yacht marinas. Based on authentic verified guest reviews, here is the definitive ranking of Dubai's must-do tours.</p>\n<h3>1. Full Day Luxury Dubai City Tour & Landmarks</h3>\n<p>The ultimate introduction for first-time visitors and GCC families with private chauffeur, Burj Khalifa passes, Palm Jumeirah, and Abra boat ride across Dubai Creek.</p>\n<p><a href='/en/packages/dubai-city-tour-luxury-experience'><strong>&rarr; Book Full Day Dubai City Tour</strong></a></p>\n<h3>2. VIP Red Dune Desert Safari with Quad Biking</h3>\n<p>Thrilling red dune bashing in private 4x4 Land Cruisers, 60 minutes high-octane quad biking, and gourmet barbecue dining under desert stars.</p>\n<p><a href='/en/packages/vip-desert-safari-quad-biking'><strong>&rarr; Book VIP Desert Safari</strong></a></p>",
                ],
                'meta_title' => 'Top 10 Best Dubai Tours & Luxury Vacation Experiences 2026',
                'meta_description' => 'Planning your Dubai vacation? Explore the top 10 best Dubai tour packages including VIP desert safaris, Burj Khalifa tickets, and Dubai Marina luxury yacht cruises.',
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(1),
            ]
        );

        if (! $post2->hasMedia('featured') && file_exists(public_path('assets/images/dubai.jpg'))) {
            $post2->addMedia(public_path('assets/images/dubai.jpg'))->preservingOriginal()->toMediaCollection('featured');
        }
    }
}
