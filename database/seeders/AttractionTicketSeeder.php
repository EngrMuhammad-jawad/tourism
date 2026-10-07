<?php

namespace Database\Seeders;

use App\Models\AttractionTicket;
use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class AttractionTicketSeeder extends Seeder
{
    public function run(): void
    {
        $dubai = Destination::firstOrCreate(['slug' => 'dubai'], [
            'name' => ['en' => 'Dubai', 'ar' => 'دبي', 'ru' => 'Дубай'],
            'country' => 'United Arab Emirates',
            'city' => 'Dubai',
            'status' => true,
        ]);

        $abuDhabi = Destination::firstOrCreate(['slug' => 'abu-dhabi'], [
            'name' => ['en' => 'Abu Dhabi', 'ar' => 'أبوظبي', 'ru' => 'Абу-Даби'],
            'country' => 'United Arab Emirates',
            'city' => 'Abu Dhabi',
            'status' => true,
        ]);

        $ticketsData = [
            [
                'slug' => 'burj-khalifa-at-the-top',
                'package_slug' => 'burj-khalifa-at-the-top',
                'destination_id' => $dubai->id,
                'city' => 'Dubai',
                'category' => 'observation-decks',
                'counter_price' => 189.00,
                'our_price' => 180.00,
                'currency' => 'AED',
                'sort_order' => 1,
                'is_featured' => true,
                'image' => 'tour_burj.jpg',
                'title' => [
                    'en' => 'Burj Khalifa Observation Deck (Levels 124 & 125)',
                    'ar' => 'تذاكر برج خليفة قمة البرج (الطابق 124 و 125)',
                    'ru' => 'Билеты на Бурдж Халифа (Этажи 124 и 125)',
                ],
                'attraction_name' => [
                    'en' => 'Burj Khalifa',
                    'ar' => 'برج خليفة',
                    'ru' => 'Бурдж Халифа',
                ],
                'badge' => [
                    'en' => 'Save 9 AED · Instant Mobile Barcode',
                    'ar' => 'وفر 9 دراهم · باركود فوري للجوال',
                    'ru' => 'Скидка 9 AED · Мгновенный билет',
                ],
                'summary' => [
                    'en' => 'Experience the world\'s tallest tower with access to Levels 124 and 125. Enjoy 360-degree views, high-speed elevator, and open-air terrace.',
                    'ar' => 'عش تجربة أطول برج في العالم مع الدخول إلى الطابقين 124 و 125. استمتع بإطلالات بانورامية 360 درجة وتراس في الهواء الطلق.',
                    'ru' => 'Поднимитесь на самое высокое здание мира на 124 и 125 этажи со скоростным лифтом и открытой смотровой площадкой.',
                ],
                'description' => [
                    'en' => "Visit the iconic Burj Khalifa observation decks at Levels 124 and 125. Ascend in the world's fastest double-deck elevator traveling at 10 meters per second. Enjoy unmatched 360-degree vistas across Dubai's skyline, Arabian Gulf, and desert.",
                    'ar' => "زر قمة برج خليفة الشهيرة في الطابقين 124 و 125. اصعد بأسرع مصعد ذي طابقين في العالم بسرعة 10 أمتار بالثانية واستمتع بإطلالة ساحرة على دبي.",
                    'ru' => 'Посетите культовую смотровую площадку Бурдж Халифа на 124 и 125 этажах с захватывающими дух панорамными видами на Дубай.',
                ],
                'inclusions' => [
                    'Direct entry barcode ticket (Levels 124 & 125)',
                    'High-speed double-deck elevator ride (10 m/s)',
                    'Access to open-air terrace and high-powered telescopes',
                    'Free Wi-Fi across the observation decks',
                ],
                'validity' => [
                    'en' => 'Valid for selected date & time slot · Instant WhatsApp & Email delivery',
                    'ar' => 'صالحة للتاريخ والوقت المحددين · تسليم فوري عبر واتساب والبريد',
                    'ru' => 'Действительно на выбранную дату и время · Мгновенная доставка',
                ],
            ],
            [
                'slug' => 'dubai-frame',
                'package_slug' => 'dubai-frame',
                'destination_id' => $dubai->id,
                'city' => 'Dubai',
                'category' => 'observation-decks',
                'counter_price' => 55.00,
                'our_price' => 50.00,
                'currency' => 'AED',
                'sort_order' => 2,
                'is_featured' => true,
                'image' => 'tour_frame.jpg',
                'title' => [
                    'en' => 'Dubai Frame Ticket & Sky Deck Glass Bridge',
                    'ar' => 'تذاكر برواز دبي والممشى الزجاجي المعلق',
                    'ru' => 'Билеты на Дубайскую Рамку (Dubai Frame)',
                ],
                'attraction_name' => [
                    'en' => 'Dubai Frame',
                    'ar' => 'برواز دبي',
                    'ru' => 'Дубайская Рамка',
                ],
                'badge' => [
                    'en' => 'Save 5 AED · Skip Ticket Booth',
                    'ar' => 'وفر 5 دراهم · بدون طوابير الشباك',
                    'ru' => 'Скидка 5 AED · Без очередей',
                ],
                'summary' => [
                    'en' => 'Walk across the 150-meter-high luminous glass bridge linking Old and Modern Dubai in Zabeel Park.',
                    'ar' => 'امشِ على الجسر الزجاجي المضيء بارتفاع 150 متراً الذي يربط بين دبي القديمة ودبي الحديثة في حديقة زعبيل.',
                    'ru' => 'Прогуляйтесь по стеклянному мосту на высоте 150 метров, соединяющему старый и современный Дубай.',
                ],
                'description' => [
                    'en' => "Dubai Frame is an architectural marvel standing 150m tall in Zabeel Park. Experience the interactive past gallery, step out onto the 50-meter clear glass walkway at the summit, and witness the immersive Future Dubai projection exhibit.",
                    'ar' => "برواز دبي تحفة معمارية بارتفاع 150 متراً في حديقة زعبيل. امشِ على الجسر الزجاجي الشفاف واستكشف معرض ماضي دبي ومستقبلها.",
                    'ru' => 'Дубайская рамка высотой 150 метров предлагает уникальный вид на исторический и современный Дубай с прозрачного стеклянного моста.',
                ],
                'inclusions' => [
                    'Admission pass to Dubai Frame and Sky Bridge',
                    'Walk on the 50-meter transparent luminous glass skywalk',
                    'Access to Old Dubai Past Museum and Future Dubai immersive zone',
                    'Free parking at Zabeel Park Gate 4',
                ],
                'validity' => [
                    'en' => 'Valid all day on booked date · Instant mobile scan entry',
                    'ar' => 'صالحة طوال اليوم بالتاريخ المحجوز · مسح فوري من الهاتف',
                    'ru' => 'Действительно весь день · Вход по QR-коду со смартфона',
                ],
            ],
            [
                'slug' => 'qasr-al-watan-palace-tickets',
                'package_slug' => 'qasr-al-watan-palace-tickets',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'cultural',
                'counter_price' => 70.00,
                'our_price' => 60.00,
                'currency' => 'AED',
                'sort_order' => 3,
                'is_featured' => true,
                'image' => 'abu_dhabi.jpg',
                'title' => [
                    'en' => 'Qasr Al Watan Presidential Palace Abu Dhabi Admission',
                    'ar' => 'تذاكر قصر الوطن الرئاسي بأبوظبي والحدائق الملكية',
                    'ru' => 'Входные билеты в Президентский Дворец Каср Аль Ватан',
                ],
                'attraction_name' => [
                    'en' => 'Qasr Al Watan',
                    'ar' => 'قصر الوطن',
                    'ru' => 'Каср Аль Ватан',
                ],
                'badge' => [
                    'en' => 'Save 10 AED · Official Palace Entry',
                    'ar' => 'وفر 10 دراهم · تذكرة القصر الرسمية',
                    'ru' => 'Скидка 10 AED · Официальный билет',
                ],
                'summary' => [
                    'en' => 'Step inside the working UAE Presidential Palace. Explore the Great Hall, Presidential Banquet, and House of Knowledge.',
                    'ar' => 'ادخل إلى قصر الرئاسة الإماراتي الفاخر. استكشف القاعة الكبرى، قاعة المآدب الرئاسية، ومجلس البرزة وبيت المعرفة.',
                    'ru' => 'Посетите действующий Президентский дворец ОАЭ с великолепным Большим залом и историческими реликвиями.',
                ],
                'description' => [
                    'en' => "Qasr Al Watan is an inspiring tribute to Arabian heritage, governance, and architectural grandeur. Walk through the ornate Great Hall under a 37-meter dome, see official diplomatic gifts, and stroll through the royal gardens.",
                    'ar' => "قصر الوطن صرح معماري مهيب يحتفي بالتراث الإماراتي والحكم الرشيد. تجول في القاعة الكبرى المزينة بالذهب والرخام واستكشف الهدايا الدبلوماسية والحدائق الملكية.",
                    'ru' => 'Каср Аль Ватан — шедевр восточной архитектуры. Оцените роскошные залы, библиотеку редких манускриптов и вечернее световое шоу.',
                ],
                'inclusions' => [
                    'General admission to Qasr Al Watan Palace & Royal Gardens',
                    'Access to The Great Hall, Spirit of Collaboration, and Presidential Banquet',
                    'Entry to House of Knowledge and Palace Library',
                    'Complimentary Palace in Motion evening light & sound show (subject to schedule)',
                ],
                'validity' => [
                    'en' => 'Valid for full day on selected date · Instant barcode entry',
                    'ar' => 'صالحة ليوم كامل بالتاريخ المحدد · دخول فوري بالباركود',
                    'ru' => 'Действительно на целый день · Вход по электронному билету',
                ],
            ],
            [
                'slug' => 'ferrari-world-abu-dhabi-tickets',
                'package_slug' => 'ferrari-world-abu-dhabi-tickets',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'theme-parks',
                'counter_price' => 345.00,
                'our_price' => 330.00,
                'currency' => 'AED',
                'sort_order' => 4,
                'is_featured' => true,
                'image' => 'ferrari_world.jpg',
                'title' => [
                    'en' => 'Ferrari World Abu Dhabi Theme Park Full Day Pass',
                    'ar' => 'تذاكر عالم فيراري أبوظبي ليوم كامل (جزيرة ياس)',
                    'ru' => 'Билеты в парк Ferrari World Abu Dhabi на целый день',
                ],
                'attraction_name' => [
                    'en' => 'Ferrari World Abu Dhabi',
                    'ar' => 'عالم فيراري أبوظبي',
                    'ru' => 'Феррари Ворлд Абу-Даби',
                ],
                'badge' => [
                    'en' => 'Save 15 AED · Formula Rossa Access',
                    'ar' => 'وفر 15 درهم · أسرع أفعوانية بالعالم',
                    'ru' => 'Скидка 15 AED · Самая быстрая горка',
                ],
                'summary' => [
                    'en' => 'Ride Formula Rossa, the world\'s fastest rollercoaster (240 km/h in 4.9s), Flying Aces, and 40+ Ferrari-themed rides and racing simulators.',
                    'ar' => 'جرّب قطار فورمولا روسا أسرع قطار ملاهي في العالم (240 كم/س خلال 4.9 ثانية)، وأكثر من 40 لعبة سباقات ومحاكاة فيراري.',
                    'ru' => 'Прокатитесь на самой быстрой американской горке в мире Formula Rossa со скоростью 240 км/ч и 40 других аттракционах.',
                ],
                'description' => [
                    'en' => "Ferrari World Yas Island features over 44 thrilling rides and family-friendly experiences. Home to Formula Rossa (0 to 240 km/h in 4.9 seconds), Flying Aces, Bell'Italia miniature driving, and cutting-edge racing simulators.",
                    'ar' => "عالم فيراري جزيرة ياس يقدم تجارب سرعة وحماس غير مسبوقة لجميع أفراد العائلة، مع أسرع قطارات الملاهي ومحاكيات الفورمولا 1 الحقيقية.",
                    'ru' => 'Ferrari World на острове Яс — первый в мире тематический парк под брендом Ferrari с мировыми рекордами скорости.',
                ],
                'inclusions' => [
                    'Unlimited full-day access to 40+ rides and attractions',
                    'Access to Formula Rossa, Flying Aces, Turbo Track & Fiorano GT',
                    'Interactive racing simulators and family driving schools',
                    'Free parking at Yas Mall / Ferrari World',
                ],
                'validity' => [
                    'en' => 'Valid for 1 full day · Turnstile mobile barcode scan entry',
                    'ar' => 'صالح لدخول يوم كامل · مسح الباركود مباشرة من الهاتف على بوابات الدخول',
                    'ru' => 'Действительно на 1 полный день · Проход через турникет по QR-коду',
                ],
            ],
            [
                'slug' => 'warner-bros-world-abu-dhabi-tickets',
                'package_slug' => 'warner-bros-world-abu-dhabi-tickets',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'theme-parks',
                'counter_price' => 345.00,
                'our_price' => 330.00,
                'currency' => 'AED',
                'sort_order' => 5,
                'is_featured' => true,
                'image' => 'warner_bros.jpg',
                'title' => [
                    'en' => 'Warner Bros. World Abu Dhabi 1-Day Ticket',
                    'ar' => 'تذاكر عالم وارنر براذرز أبوظبي ليوم كامل (جزيرة ياس)',
                    'ru' => 'Билеты в парк Warner Bros. World Abu Dhabi на 1 день',
                ],
                'attraction_name' => [
                    'en' => 'Warner Bros. World Abu Dhabi',
                    'ar' => 'وارنر براذرز أبوظبي',
                    'ru' => 'Варнер Бразерс Абу-Даби',
                ],
                'badge' => [
                    'en' => 'Save 15 AED · Fully Air-Conditioned',
                    'ar' => 'وفر 15 درهم · منتزه مكيف بالكامل',
                    'ru' => 'Скидка 15 AED · Крытый парк',
                ],
                'summary' => [
                    'en' => 'Explore the world\'s largest indoor theme park with 29 state-of-the-art rides across Metropolis, Gotham City, Bedrock, and Cartoon Junction.',
                    'ar' => 'استكشف أكبر منتزه ترفيهي داخلي مغطى ومكيف في العالم مع 29 لعبة ممتعة في جوثام سيتي، متروبوليس، وكارتون جانكشن.',
                    'ru' => 'Крупнейший в мире крытый тематический парк с Бэтменом, Суперменом, Багзом Банни и 29 ультрасовременными аттракционами.',
                ],
                'description' => [
                    'en' => "Warner Bros. World Abu Dhabi brings legendary DC superheroes and Looney Tunes characters to life under one fully air-conditioned roof. Ride Batman: Knight Flight, Justice League 5D, Scooby-Doo Mystery Museum, and meet your favorite heroes.",
                    'ar' => "عالم وارنر براذرز أبوظبي يجمع شخصيات دي سي كوميكس الخارقة ولوني تيونز تحت سقف واحد مكيف، مع عروض حية وألعاب تفاعلية خيالية.",
                    'ru' => 'Погрузитесь в атмосферу любимых фильмов и комиксов: Готэм-сити Бэтмена, Метрополис Супермена и мир мультфильмов Looney Tunes.',
                ],
                'inclusions' => [
                    'Full-day general admission to Warner Bros. World Yas Island',
                    'Unlimited access to all 29 rides, 4D/5D dark rides, and family attractions',
                    'Character meet & greets with Batman, Superman, Wonder Woman, Bugs Bunny',
                    'Fully air-conditioned indoor comfort year-round',
                ],
                'validity' => [
                    'en' => 'Valid for 1 full day · Instant turnstile mobile scan',
                    'ar' => 'صالح ليوم كامل · دخول فوري عبر مسح الهاتف عند البوابة',
                    'ru' => 'Действительно на весь день · Прямой проход по электронному билету',
                ],
            ],
            [
                'slug' => 'seaworld-abu-dhabi-tickets',
                'package_slug' => 'seaworld-abu-dhabi-tickets',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'theme-parks',
                'counter_price' => 375.00,
                'our_price' => 350.00,
                'currency' => 'AED',
                'sort_order' => 6,
                'is_featured' => true,
                'image' => 'seaworld.jpg',
                'title' => [
                    'en' => 'SeaWorld Abu Dhabi Next-Gen Marine Theme Park Ticket',
                    'ar' => 'تذاكر سي وورلد أبوظبي منتزه الحياة البحرية التفاعلي',
                    'ru' => 'Билеты в морской тематический парк SeaWorld Abu Dhabi',
                ],
                'attraction_name' => [
                    'en' => 'SeaWorld Abu Dhabi',
                    'ar' => 'سي وورلد أبوظبي',
                    'ru' => 'СиВорлд Абу-Даби',
                ],
                'badge' => [
                    'en' => 'Save 25 AED · World\'s Largest Marine Aquarium',
                    'ar' => 'وفر 25 درهم · أكبر حوض مائي بالعالم',
                    'ru' => 'Скидка 25 AED · Океанариум рекордсмен',
                ],
                'summary' => [
                    'en' => 'Journey across 8 immersive ocean realms with 68,000+ marine animals, Manta rollercoaster, and the world\'s largest multi-species aquarium.',
                    'ar' => 'انطلق عبر 8 عوالم بحرية غامرة تضم أكثر من 68 ألف كائن بحري، وأفعوانية مانتا، وأكبر أكواريوم بحري متعدد الأنواع في العالم.',
                    'ru' => 'Откройте 8 океанических миров с более чем 68 000 морских обитателей, американской горкой Manta и колоссальным аквариумом.',
                ],
                'description' => [
                    'en' => "SeaWorld Yas Island is the region's first marine life theme park, featuring the 'One Ocean' narrative across 8 captivating realms: Endless Ocean, Arctic, Antarctica, Tropical Ocean, and Rocky Point. Ride the thrilling Manta roller coaster and witness interactive animal care presentations.",
                    'ar' => "سي وورلد جزيرة ياس أول منتزه للحياة البحرية في المنطقة يقدم حكاية محيط واحد عبر 8 عوالم خيالية، مع ألعاب مائية ومغامرات تعليمية لا تنسى.",
                    'ru' => 'SeaWorld Abu Dhabi предлагает уникальное сочетание захватывающих аттракционов и передового центра изучения и спасения морских животных.',
                ],
                'inclusions' => [
                    'Full-day admission to all 8 immersive SeaWorld realms',
                    'Access to Manta Coaster, Hypersphere 360, and family rides',
                    'Interactive viewing of dolphins, walruses, sea otters, penguins & rays',
                    'Free Yas Express shuttle access around Yas Island',
                ],
                'validity' => [
                    'en' => 'Valid for 1 full day · Instant turnstile mobile scan',
                    'ar' => 'صالح ليوم كامل · مسح فوري من الهاتف عند البوابة',
                    'ru' => 'Действительно на весь день · Вход по электронному QR-коду',
                ],
            ],
            [
                'slug' => 'yas-island-2-parks-pass',
                'package_slug' => 'yas-island-2-parks-pass',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'yas-combos',
                'counter_price' => 435.00,
                'our_price' => 400.00,
                'currency' => 'AED',
                'sort_order' => 7,
                'is_featured' => true,
                'image' => 'ferrari_world.jpg',
                'title' => [
                    'en' => '2 Yas Parks Combo Pass (Pick Any 2 Parks)',
                    'ar' => 'تذكرة كومبو حديقتين في جزيرة ياس (اختر أي حديقتين)',
                    'ru' => 'Комбо-билет на 2 парка острова Яс (Любые 2 парка)',
                ],
                'attraction_name' => [
                    'en' => 'Yas Island 2-Park Pass',
                    'ar' => 'كومبو حديقتين جزيرة ياس',
                    'ru' => '2 парка острова Яс',
                ],
                'badge' => [
                    'en' => 'Save 35 AED · Valid 14 Days',
                    'ar' => 'وفر 35 درهم · صالحة لمدة 14 يوماً',
                    'ru' => 'Скидка 35 AED · Действует 14 дней',
                ],
                'summary' => [
                    'en' => 'Choose any 2 Yas theme parks: Ferrari World, Warner Bros. World, or Yas Waterworld. Visit both on the same day or across 14 days.',
                    'ar' => 'اختر أي حديقتين من حدائق ياس: عالم فيراري، وارنر براذرز، أو ياس ووتروورلد. يمكنك زيارتهما بنفس اليوم أو خلال 14 يوماً.',
                    'ru' => 'Выберите любые 2 парка на выбор (Феррари Ворлд, Варнер Бразерс или аквапарк Яс Ватерворлд) с действием 14 дней.',
                ],
                'description' => [
                    'en' => "Maximize your Yas Island fun with the official 2-Park Combo ticket. Enjoy flexibility to visit Ferrari World, Warner Bros. World, or Yas Waterworld within 14 days from the first park entry.",
                    'ar' => "ضاعف متعتك في جزيرة ياس مع تذكرة الكومبو لحديقتين. تمتع بمرونة زيارة الحديقتين خلال 14 يوماً من أول استخدام.",
                    'ru' => 'Экономьте с комбо-билетом на 2 парка. Посещайте парки в один день или разделите визиты на 14 дней.',
                ],
                'inclusions' => [
                    'Access to any 2 chosen Yas parks (Ferrari World, Warner Bros, Yas Waterworld)',
                    '14 days validity between park visits after first entry',
                    'Unlimited ride access in both selected parks',
                    'Complimentary Yas Express shuttle between parks',
                ],
                'validity' => [
                    'en' => 'Valid for 14 days from first park entry · Instant mobile barcode scan',
                    'ar' => 'صالحة لمدة 14 يوماً من أول دخول · دخول فوري بالباركود من الجوال',
                    'ru' => 'Действительно 14 дней с первого входа · Проход по QR-коду',
                ],
            ],
            [
                'slug' => 'yas-island-2-parks-seaworld-pass',
                'package_slug' => 'yas-island-2-parks-seaworld-pass',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'yas-combos',
                'counter_price' => 475.00,
                'our_price' => 450.00,
                'currency' => 'AED',
                'sort_order' => 8,
                'is_featured' => false,
                'image' => 'seaworld.jpg',
                'title' => [
                    'en' => '2 Yas Parks Combo Pass with SeaWorld',
                    'ar' => 'تذكرة كومبو حديقتين في جزيرة ياس تشمل سي وورلد',
                    'ru' => 'Комбо-билет на 2 парка острова Яс (Включая SeaWorld)',
                ],
                'attraction_name' => [
                    'en' => 'Yas Island 2-Park (SeaWorld Included)',
                    'ar' => 'كومبو حديقتين مع سي وورلد',
                    'ru' => '2 парка с СиВорлд',
                ],
                'badge' => [
                    'en' => 'Save 25 AED · SeaWorld + 1 Park',
                    'ar' => 'وفر 25 درهم · سي وورلد + حديقة إضافية',
                    'ru' => 'Скидка 25 AED · SeaWorld + 1 парк',
                ],
                'summary' => [
                    'en' => 'Includes SeaWorld Abu Dhabi admission PLUS 1 additional park of your choice (Ferrari World, Warner Bros. World, or Yas Waterworld).',
                    'ar' => 'تشمل دخول سي وورلد أبوظبي بالإضافة إلى حديقة إضافية من اختيارك (عالم فيراري أو وارنر براذرز أو ياس ووتروورلد).',
                    'ru' => 'Включает посещение SeaWorld Abu Dhabi плюс еще один парк на выбор с действием 14 дней.',
                ],
                'description' => [
                    'en' => "Experience SeaWorld Abu Dhabi and pair it with your choice of Ferrari World, Warner Bros. World, or Yas Waterworld. Enjoy two premier theme park adventures at exceptional discounted value.",
                    'ar' => "عش سحر سي وورلد أبوظبي واجمعها مع حديقتك المفضلة الأخرى في جزيرة ياس بخصم استثنائي ومرونة كاملة.",
                    'ru' => 'Идеальный комбо для тех, кто хочет увидеть новый SeaWorld и совместить его с захватывающими горками Ferrari World или Warner Bros.',
                ],
                'inclusions' => [
                    'Admission to SeaWorld Abu Dhabi',
                    'Admission to 1 additional Yas park (Ferrari World, Warner Bros, or Yas Waterworld)',
                    '14 days window to use second park entry',
                    'Full unlimited ride access in both parks',
                ],
                'validity' => [
                    'en' => 'Valid for 14 days from first park entry · Mobile ticket scan',
                    'ar' => 'صالحة لمدة 14 يوماً من أول زيارة · مسح فوري من الهاتف',
                    'ru' => 'Действительно 14 дней с момента активации · Проход по смартфону',
                ],
            ],
            [
                'slug' => 'yas-island-3-parks-pass',
                'package_slug' => 'yas-island-3-parks-pass',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'yas-combos',
                'counter_price' => 575.00,
                'our_price' => 540.00,
                'currency' => 'AED',
                'sort_order' => 9,
                'is_featured' => true,
                'image' => 'warner_bros.jpg',
                'title' => [
                    'en' => '3 Yas Parks Combo Pass (Pick Any 3 Parks)',
                    'ar' => 'تذكرة كومبو 3 حدائق في جزيرة ياس (اختر أي 3 حدائق)',
                    'ru' => 'Комбо-билет на 3 парка острова Яс (Любые 3 парка)',
                ],
                'attraction_name' => [
                    'en' => 'Yas Island 3-Park Pass',
                    'ar' => 'كومبو 3 حدائق جزيرة ياس',
                    'ru' => '3 парка острова Яс',
                ],
                'badge' => [
                    'en' => 'Save 35 AED · Best Value Trio',
                    'ar' => 'وفر 35 درهم · أفضل قيمة للثلاثية',
                    'ru' => 'Скидка 35 AED · Выгодное комбо 3 парков',
                ],
                'summary' => [
                    'en' => 'Visit any 3 Yas Island theme parks of your choice: Ferrari World, Warner Bros. World, SeaWorld Abu Dhabi, or Yas Waterworld over 14 days.',
                    'ar' => 'زر أي 3 حدائق من حدائق جزيرة ياس العالمية: عالم فيراري، وارنر براذرز، سي وورلد، أو ياس ووتروورلد على مدار 14 يوماً.',
                    'ru' => 'Выберите любые 3 парка на острове Яс из 4 доступных с действием 14 дней для незабываемого семейного отдыха.',
                ],
                'description' => [
                    'en' => "The 3-Park Pass grants you complete freedom to explore three world-class attractions on Yas Island. You have 14 days from first park activation to visit all three parks at your own comfortable pace.",
                    'ar' => "تذكرة 3 حدائق تمنحك الحرية الكاملة لاستكشاف ثلاث وجهات ترفيهية رائدة على جزيرة ياس خلال 14 يوماً براحة تامة.",
                    'ru' => 'Три парка мирового уровня по одной выгодной цене. Посещайте парки без спешки в течение 14 дней.',
                ],
                'inclusions' => [
                    'Access to any 3 Yas Island parks (Ferrari World, Warner Bros, SeaWorld, Yas Waterworld)',
                    '14 days validity between park entries',
                    'Unlimited ride and show access across all 3 selected parks',
                    'Free Yas Express transportation connecting all parks',
                ],
                'validity' => [
                    'en' => 'Valid for 14 days from first park entry · Mobile ticket scan',
                    'ar' => 'صالحة لمدة 14 يوماً من أول زيارة · مسح فوري من الهاتف',
                    'ru' => 'Действительно 14 дней после первого посещения',
                ],
            ],
            [
                'slug' => 'yas-island-4-parks-ultimate-pass',
                'package_slug' => 'yas-island-4-parks-pass',
                'destination_id' => $abuDhabi->id,
                'city' => 'Abu Dhabi',
                'category' => 'yas-combos',
                'counter_price' => 675.00,
                'our_price' => 600.00,
                'currency' => 'AED',
                'sort_order' => 10,
                'is_featured' => true,
                'image' => 'ferrari_world.jpg',
                'title' => [
                    'en' => '4 Yas Parks Ultimate Combo Pass (All 4 Parks)',
                    'ar' => 'تذكرة كومبو الـ 4 حدائق الشاملة في جزيرة ياس (جميع الحدائق الـ 4)',
                    'ru' => 'Супер Комбо-билет на ВСЕ 4 парка острова Яс',
                ],
                'attraction_name' => [
                    'en' => 'Yas Island 4-Park Ultimate Pass',
                    'ar' => 'كومبو الـ 4 حدائق الشاملة جزيرة ياس',
                    'ru' => 'Все 4 парка острова Яс',
                ],
                'badge' => [
                    'en' => 'Save 75 AED · Maximum Savings Deal',
                    'ar' => 'وفر 75 درهم · أعلى توفير لجميع الحدائق',
                    'ru' => 'Скидка 75 AED · Все 4 парка включены',
                ],
                'summary' => [
                    'en' => 'The ultimate UAE theme park adventure! Full access to ALL 4 Yas parks: Ferrari World, Warner Bros. World, SeaWorld, and Yas Waterworld within 14 days.',
                    'ar' => 'المغامرة الترفيهية الكبرى في الإمارات! دخول كامل لجميع حدائق ياس الـ 4: عالم فيراري، وارنر براذرز، سي وورلد، وياس ووتروورلد خلال 14 يوماً.',
                    'ru' => 'Абсолютный хит! Вход во ВСЕ 4 парка острова Яс: Ferrari World, Warner Bros., SeaWorld и Yas Waterworld в течение 14 дней.',
                ],
                'description' => [
                    'en' => "Experience everything Yas Island has to offer with the Ultimate 4-Park Pass. Over 100+ record-breaking rollercoasters, water slides, marine encounters, and superhero dark rides. Save 75 AED off gate prices with 14 full days to experience every park.",
                    'ar' => "استمتع بكل ما تقدمه جزيرة ياس مع تذكرة الـ 4 حدائق الشاملة. أكثر من 100 لعبة وأفعوانية وزلاقة مائية وتجربة بحرية مع توفير 75 درهماً عن شباك التذاكر ومهلة 14 يوماً.",
                    'ru' => 'Все 4 грандиозных парка острова Яс по максимальной скидке. Более 100 аттракционов мирового уровня с 14 днями действия билета.',
                ],
                'inclusions' => [
                    'Full general admission to Ferrari World Abu Dhabi',
                    'Full general admission to Warner Bros. World Abu Dhabi',
                    'Full general admission to SeaWorld Abu Dhabi',
                    'Full general admission to Yas Waterworld Abu Dhabi',
                    '14 days window to complete all 4 park visits',
                    'Complimentary Yas Express shuttle between all parks',
                ],
                'validity' => [
                    'en' => 'Valid for 14 days from first park entry · Mobile ticket scan',
                    'ar' => 'صالحة لمدة 14 يوماً من أول زيارة · مسح فوري من الهاتف عند البوابات',
                    'ru' => 'Действительно 14 дней с момента активации · Проход по QR-коду',
                ],
            ],
        ];

        foreach ($ticketsData as $item) {
            // 1. Create or update TourPackage in catalog for direct booking
            $tourPackage = TourPackage::updateOrCreate(
                ['slug' => $item['package_slug']],
                [
                    'destination_id' => $item['destination_id'],
                    'name' => $item['title'],
                    'summary' => $item['summary'],
                    'description' => $item['description'],
                    'price' => $item['counter_price'],
                    'sale_price' => $item['our_price'],
                    'duration_days' => 1,
                    'duration_nights' => 0,
                    'included_services' => $item['inclusions'],
                    'is_featured' => $item['is_featured'],
                    'status' => true,
                ]
            );

            // 2. Create or update AttractionTicket in attraction_tickets table
            AttractionTicket::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'tour_package_id' => $tourPackage->id,
                    'city' => $item['city'],
                    'category' => $item['category'],
                    'counter_price' => $item['counter_price'],
                    'our_price' => $item['our_price'],
                    'currency' => $item['currency'],
                    'sort_order' => $item['sort_order'],
                    'is_featured' => $item['is_featured'],
                    'status' => true,
                    'image' => $item['image'],
                    'title' => $item['title'],
                    'attraction_name' => $item['attraction_name'],
                    'badge' => $item['badge'],
                    'summary' => $item['summary'],
                    'description' => $item['description'],
                    'inclusions' => $item['inclusions'],
                    'validity' => $item['validity'],
                ]
            );
        }
    }
}
