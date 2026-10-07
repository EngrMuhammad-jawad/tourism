<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Setting;
use App\Models\TourPackage;
use App\Models\Transport;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * Get site name from settings or default.
     */
    public static function siteName(): string
    {
        return (string) Setting::get('general.site_name', 'Dubai Tour Book');
    }

    /**
     * Get primary site logo or fallback.
     */
    public static function defaultImage(): string
    {
        return asset('assets/images/hero.jpg');
    }

    /**
     * Configure common base metadata across OpenGraph, Twitter, and canonical.
     */
    public static function setMeta(
        string $title,
        string $description,
        ?string $image = null,
        array $keywords = [],
        string $type = 'website'
    ): void {
        $siteName = static::siteName();
        $currentUrl = url()->current();
        $imageUrl = $image ?: static::defaultImage();
        $locale = app()->getLocale();

        // Standard Meta
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::setCanonical($currentUrl);
        if (!empty($keywords)) {
            SEOMeta::setKeywords($keywords);
        }
        SEOMeta::addMeta('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1');

        // OpenGraph
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::opengraph()->setUrl($currentUrl);
        SEOTools::opengraph()->setSiteName($siteName);
        SEOTools::opengraph()->setType($type);
        SEOTools::opengraph()->addImage($imageUrl);

        $ogLocale = $locale === 'ar' ? 'ar_AE' : ($locale === 'ru' ? 'ru_RU' : 'en_US');
        SEOTools::opengraph()->addProperty('locale', $ogLocale);
        SEOTools::opengraph()->addProperty('locale:alternate', ['ar_AE', 'ar_SA', 'ar_KW', 'ar_QA', 'en_US', 'ru_RU']);

        // Twitter Card
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setDescription($description);
        SEOTools::twitter()->setImage($imageUrl);
        SEOTools::twitter()->setSite('@dubaitourbook');

        // JSON-LD
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);
        SEOTools::jsonLd()->setUrl($currentUrl);
        SEOTools::jsonLd()->setType($type === 'article' ? 'Article' : 'WebPage');
        SEOTools::jsonLd()->addImage($imageUrl);
    }

    /**
     * Homepage SEO.
     */
    public static function setHome(): void
    {
        $locale = app()->getLocale();

        $titles = [
            'ar' => 'دبي تور بوك | رحلات دبي الفاخرة، سفاري VIP وبكجات عائلية لدول الخليج',
            'ru' => 'Dubai Tour Book | Экскурсии и Туры в Дубае 2026: Сафари, Яхты, Отели',
            'en' => Setting::get('seo.meta_title', 'Dubai Tour Book | Luxury Tours, Desert Safaris & VIP Experiences'),
        ];

        $descriptions = [
            'ar' => 'احجز أرقى رحلات دبي وبكجات السياحة العائلية لزوار السعودية والكويت وقطر والإمارات. استمتع بسفاري صحراوي VIP، جولات يخوت مارينا الخاصة، وتذاكر برج خليفة مع خدمة عملاء راقية على مدار الساعة.',
            'ru' => 'Премиальные экскурсии и индивидуальные туры в Дубае с русскими гидами: VIP сафари, аренда яхт в Дубай Марина, билеты на Бурдж Халифа без очередей.',
            'en' => Setting::get('seo.meta_description', 'Discover Dubai & the UAE - Experience luxury desert safaris, Burj Khalifa VIP tours, yacht rentals, and 7-star Arabian hospitality at dubaitourbook.com.'),
        ];

        $keywords = [
            'ar' => ['رحلات دبي', 'سياحة دبي للعوائل', 'بكجات دبي من الرياض', 'رحلات دبي من الكويت', 'سفاري دبي VIP', 'حجز فنادق دبي', 'تأجير يخوت دبي مارينا', 'تذاكر برج خليفة', 'عروض سياحة دبي 2026'],
            'ru' => ['экскурсии в дубае', 'туры в дубай 2026', 'сафари в дубае', 'русский гид дубай', 'аренда яхты дубай', 'билеты бурдж халифа'],
            'en' => ['Dubai tour book', 'Dubai tours', 'luxury Dubai travel', 'desert safari Dubai', 'Burj Khalifa tickets', 'Dubai yacht rental', 'UAE holiday packages', 'GCC family holidays'],
        ];

        $title = $titles[$locale] ?? $titles['en'];
        $desc = $descriptions[$locale] ?? $descriptions['en'];
        $kw = $keywords[$locale] ?? $keywords['en'];

        static::setMeta($title, $desc, asset('assets/images/hero.jpg'), $kw, 'website');
    }

    /**
     * Tour Packages catalog index SEO.
     */
    public static function setPackagesIndex(?string $searchTerm = null): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        if ($searchTerm) {
            $title = $locale === 'ar'
                ? "نتائج البحث عن: {$searchTerm} | بكجات دبي السياحية - {$siteName}"
                : ($locale === 'ru'
                    ? "Результаты поиска: {$searchTerm} | Туры в Дубае - {$siteName}"
                    : "Search results for: {$searchTerm} | Tour Packages - {$siteName}");
            $desc = $locale === 'ar'
                ? "تصفح باقات وجولات سياحية متطابقة مع {$searchTerm} بأفضل الأسعار وأعلى مستويات الخدمة."
                : ($locale === 'ru'
                    ? "Лучшие экскурсии и пакеты в Дубае по запросу: {$searchTerm}."
                    : "Browse verified tour packages matching {$searchTerm} in Dubai and UAE.");
        } else {
            $title = $locale === 'ar'
                ? "بكجات دبي السياحية الفاخرة 2026 | عروض رحلات وسفاري العوائل الخليجية - {$siteName}"
                : ($locale === 'ru'
                    ? "Туры и Экскурсионные Пакеты в Дубае 2026: Цены и Бронирование - {$siteName}"
                    : "Dubai Luxury Tour Packages 2026 | Desert Safaris, Yachts & VIP Passes - {$siteName}");
            $desc = $locale === 'ar'
                ? 'استكشف أفضل بكجات دبي السياحية المصممة للعوائل من السعودية والكويت وقطر والخليج. عروض سفاري صحراوي VIP، يخوت مارينا، وبرج خليفة بأسعار حصرية وحجز فوري.'
                : ($locale === 'ru'
                    ? 'Лучшие экскурсионные пакеты и туры в Дубае 2026: сафари в пустыне, аренда яхт, билеты на Бурдж Халифа, индивидуальные русскоязычные гиды.'
                    : 'Explore curated Dubai tour packages, VIP desert safaris, private yacht charters, and luxury UAE holiday experiences. Instant confirmation & 24/7 concierge.');
        }

        $keywords = $locale === 'ar'
            ? ['بكجات دبي', 'عروض رحلات دبي للعوائل', 'بكجات دبي من الرياض', 'رحلات سفاري دبي VIP', 'اسعار جولات دبي 2026', 'حجز بكجات الامارات']
            : ($locale === 'ru'
                ? ['туры в дубай 2026', 'экскурсии дубай цены', 'сафари в дубае', 'пакетные туры оаэ', 'русский гид']
                : ['Dubai tour packages', 'luxury Dubai tours', 'desert safari Dubai', 'Burj Khalifa VIP', 'Dubai yacht charter', 'GCC family holiday deals']);

        static::setMeta($title, $desc, asset('assets/images/tour_burj.jpg'), $keywords);
    }

    /**
     * Single Tour Package SEO.
     */
    public static function setTourPackage(TourPackage $package): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();
        $destName = $package->destination?->name ?? ($locale === 'ar' ? 'دبي' : 'Dubai');
        $name = (string) $package->name;
        $price = (float) $package->effectivePrice();
        $featuredImage = $package->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg');

        $title = $locale === 'ar'
            ? "حجز {$name} | رحلات {$destName} الفاخرة وسفاري VIP - {$siteName}"
            : ($locale === 'ru'
                ? "Экскурсия {$name} в Дубае | Бронирование и Цены 2026 - {$siteName}"
                : "{$name} | {$destName} Luxury Tours & Safaris - {$siteName}");

        $desc = $locale === 'ar'
            ? "احجز {$name} في {$destName}. جولة مميزة تشمل التوصيل الفاخر من الفندق، مرشد سياحي معتمد، وضيافة عربية متميزة للعوائل الخليجية. السعر يبدأ من {$price} AED."
            : ($locale === 'ru'
                ? "Забронируйте {$name} в {$destName}: трансфер из отеля, русский гид, входные билеты и VIP сервис. От {$price} AED."
                : "Book {$name} in {$destName} - Enjoy VIP hotel pickup, certified guide, entry passes, and Arabian hospitality. Starting from \${$price} / person.");

        $keywords = $locale === 'ar'
            ? [$name, "رحلات {$destName}", 'سفاري دبي VIP للعوائل', 'حجز رحلات دبي من السعودية', 'سياحة دبي']
            : ($locale === 'ru'
                ? [$name, 'экскурсии в дубае', 'сафари дубай', 'туры в оаэ 2026']
                : [$name, "{$destName} tours", 'Dubai desert safari', 'Dubai luxury travel', 'UAE tour packages']);

        static::setMeta($title, $desc, $featuredImage, $keywords, 'product');

        // Product & Tour Schema in JSON-LD
        SEOTools::jsonLd()->addValue('offers', [
            '@type'         => 'Offer',
            'price'         => $price,
            'priceCurrency' => 'AED',
            'availability'  => 'https://schema.org/InStock',
            'url'           => url()->current(),
            'validFrom'     => now()->toIso8601String(),
        ]);
        if ($package->duration_days || $package->duration_hours) {
            $durationStr = $package->duration_days ? "P{$package->duration_days}D" : "PT{$package->duration_hours}H";
            SEOTools::jsonLd()->addValue('duration', $durationStr);
        }
    }

    /**
     * Destinations catalog index SEO.
     */
    public static function setDestinationsIndex(): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "وجهات الإمارات السياحية الفاخرة | دبي، أبوظبي، الشارقة، رأس الخيمة - {$siteName}"
            : ($locale === 'ru'
                ? "Направления в ОАЭ: Дубай, Абу-Даби, Шарджа, Рас-эль-Хайма - {$siteName}"
                : "Luxury UAE Travel Destinations | Dubai, Abu Dhabi, Sharjah & More - {$siteName}");

        $desc = $locale === 'ar'
            ? 'دليل استكشاف أهم الوجهات السياحية في دولة الإمارات العربية المتحدة. معالم دبي الأيقونية، قصور ومتاحف أبوظبي، ثقافة الشارقة ومغامرات رأس الخيمة.'
            : ($locale === 'ru'
                ? 'Путеводитель по лучшим туристическим направлениям ОАЭ: достопримечательности Дубая, музеи Абу-Даби, природа Рас-эль-Хаймы.'
                : 'Explore iconic travel destinations across the UAE. From Downtown Dubai luxury to Abu Dhabi cultural landmarks and Ras Al Khaimah mountain adventures.');

        $keywords = ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ras Al Khaimah', 'UAE destinations', 'Dubai sightseeing', 'UAE tourism'];

        static::setMeta($title, $desc, asset('assets/images/dubai.jpg'), $keywords);
    }

    /**
     * Single Destination SEO.
     */
    public static function setDestination(Destination $destination): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();
        $name = (string) $destination->name;
        $featuredImage = $destination->getFirstMediaUrl('featured') ?: asset('assets/images/dubai.jpg');
        $summary = $destination->description ? Str::limit(strip_tags((string) $destination->description), 160) : '';

        $title = $locale === 'ar'
            ? "دليل سياحة {$name} 2026 | أهم الأماكن السياحية والرحلات الفاخرة - {$siteName}"
            : ($locale === 'ru'
                ? "Туризм и Достопримечательности {$name} 2026: Гид и Экскурсии - {$siteName}"
                : "{$name} Tourism & Travel Guide 2026 | Top Attractions & Luxury Tours - {$siteName}");

        $desc = $summary ?: ($locale === 'ar'
            ? "اكتشف روعة السياحة في {$name}. أفضل الجولات، الفنادق الفاخرة، والتجارب الترفيهية الحصرية مع خدمة حجز ممتازة."
            : ($locale === 'ru'
                ? "Гид по лучшим местам и индивидуальным экскурсиям в {$name}. Бронируйте туры и отели по выгодным ценам."
                : "Discover {$name} with our curated travel guide. Top sights, luxury hotels, private safaris, and unforgettable experiences."));

        $keywords = [$name, "سياحة {$name}", "{$name} travel guide", "{$name} attractions", 'Dubai luxury travel'];

        static::setMeta($title, $desc, $featuredImage, $keywords);

        SEOTools::jsonLd()->setType('TouristDestination');
        SEOTools::jsonLd()->addValue('touristType', ['Families', 'Couples', 'Luxury Travelers']);
    }

    /**
     * Hotels catalog index SEO.
     */
    public static function setHotelsIndex(): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "أفضل فنادق ومنتجعات دبي والإمارات 5 نجوم | عروض الحجز الفاخر - {$siteName}"
            : ($locale === 'ru'
                ? "Лучшие 5-звездочные Отели и Курорты Дубая 2026: Цены и Бронь - {$siteName}"
                : "Luxury 5-Star Hotels & Beach Resorts in Dubai 2026 - {$siteName}");

        $desc = $locale === 'ar'
            ? 'احجز أفخم فنادق دبي، مارينا، نخلة جميرا، وداون تاون بأفضل الأسعار. استمتع بأعلى معايير الضيافة وخدمات VIP الحصرية.'
            : ($locale === 'ru'
                ? 'Бронирование премиум отелей в Дубае: Palm Jumeirah, Dubai Marina, Downtown. Лучшие тарифы и VIP сервис.'
                : 'Browse and book world-class 5-star luxury hotels and beachfront resorts in Dubai, Palm Jumeirah, and Downtown Dubai with exclusive privileges.');

        static::setMeta($title, $desc, asset('assets/images/hotel_atlantis.jpg'), ['Dubai hotels', 'luxury resorts Dubai', 'Palm Jumeirah hotels', 'Burj Al Arab']);
    }

    /**
     * Single Hotel SEO.
     */
    public static function setHotel(Hotel $hotel): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();
        $name = (string) $hotel->name;
        $destName = $hotel->destination?->name ?? 'Dubai';
        $featuredImage = $hotel->getFirstMediaUrl('featured') ?: asset('assets/images/hotel_atlantis.jpg');
        $stars = $hotel->star_rating ? "{$hotel->star_rating}-Star" : 'Luxury';

        $title = $locale === 'ar'
            ? "حجز فندق {$name} في {$destName} ({$stars}) | عروض حصرية - {$siteName}"
            : ($locale === 'ru'
                ? "Отель {$name} {$destName} ({$stars}): Цены и Бронирование - {$siteName}"
                : "{$name} Hotel in {$destName} ({$stars}) | Luxury Accommodation - {$siteName}");

        $desc = $locale === 'ar'
            ? "استمتع بإقامة استثنائية في {$name} ({$destName}). غرف وأجنحة راقية، إطلالات خلابة وخدمات 5 نجوم للعوائل ورجال الأعمال."
            : ($locale === 'ru'
                ? "Бронирование номеров в отеле {$name}, {$destName}. Высокий уровень сервиса, пляжи и первоклассный отдых."
                : "Experience luxury living at {$name} in {$destName}. World-class amenities, prime location, and unforgettable hospitality.");

        static::setMeta($title, $desc, $featuredImage, [$name, "فندق {$name}", "hotels in {$destName}", 'luxury Dubai suites']);

        SEOTools::jsonLd()->setType('Hotel');
        if ($hotel->star_rating) {
            SEOTools::jsonLd()->addValue('starRating', [
                '@type'       => 'Rating',
                'ratingValue' => (string) $hotel->star_rating,
            ]);
        }
        if ($hotel->address) {
            SEOTools::jsonLd()->addValue('address', [
                '@type'           => 'PostalAddress',
                'streetAddress'   => (string) $hotel->address,
                'addressLocality' => $destName,
                'addressCountry'  => 'AE',
            ]);
        }
    }

    /**
     * Transports catalog index SEO.
     */
    public static function setTransportsIndex(): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "خدمات التوصيل الفاخر وسيارات VIP في دبي | ليموزين وسائق خاص - {$siteName}"
            : ($locale === 'ru'
                ? "VIP Трансфер и Аренда Авто с Водителем в Дубае 2026 - {$siteName}"
                : "VIP Chauffeur & Luxury Transport Services in Dubai - {$siteName}");

        $desc = $locale === 'ar'
            ? 'خدمات تأجير سيارات فارهة مع سائق خاص وتوصيل المطار في دبي والإمارات. أسطول حديث من مرسيدس، رولز رويس وفانات عائلية فاخرة.'
            : ($locale === 'ru'
                ? 'Премиум трансферы из аэропорта Дубая, аренда представительских авто с водителем 24/7.'
                : 'Premium airport transfers, private chauffeur services, and luxury vehicle hire across Dubai and the UAE with prompt 24/7 service.');

        static::setMeta($title, $desc, asset('assets/images/hero.jpg'), ['Dubai chauffeur', 'airport transfer Dubai', 'luxury car rental Dubai', 'VIP transfer UAE']);
    }

    /**
     * Single Transport SEO.
     */
    public static function setTransport(Transport $transport): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();
        $name = (string) $transport->name;
        $featuredImage = $transport->getFirstMediaUrl('featured') ?: asset('assets/images/hero.jpg');

        $title = $locale === 'ar'
            ? "حجز {$name} | خدمة سائق وتوصيل فاخر في دبي - {$siteName}"
            : ($locale === 'ru'
                ? "Аренда {$name} в Дубае | VIP Трансфер и Сервис - {$siteName}"
                : "{$name} | Luxury Chauffeur & Transfer Dubai - {$siteName}");

        $desc = $locale === 'ar'
            ? "احجز {$name} مع سائق محترف في دبي والإمارات. راحة فائقة، مواعيد دقيقة، وخدمة VIP على مدار الساعة."
            : ($locale === 'ru'
                ? "Бронирование {$name} с водителем в Дубае: комфорт, безопасность, фиксированные цены."
                : "Book {$name} private chauffeur transfer in Dubai. Maximum comfort, punctuality, and executive travel.");

        static::setMeta($title, $desc, $featuredImage, [$name, 'Dubai luxury transport', 'chauffeur Dubai']);
    }

    /**
     * Blog Posts catalog index SEO.
     */
    public static function setPostsIndex(?string $query = null): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        if ($query) {
            $title = $locale === 'ar'
                ? "مقالات سياحة دبي عن: {$query} - {$siteName}"
                : ($locale === 'ru'
                    ? "Статьи о Дубае по запросу: {$query} - {$siteName}"
                    : "Dubai Travel Articles for: {$query} - {$siteName}");
            $desc = "Articles and travel guides matching {$query} in Dubai and the UAE.";
        } else {
            $title = $locale === 'ar'
                ? "مدونة سياحة دبي | نصائح السفر، دليلك لأفضل الأماكن والفعاليات - {$siteName}"
                : ($locale === 'ru'
                    ? "Блог о Дубае 2026: Советы Туристам, Места, Гиды и Новости - {$siteName}"
                    : "Dubai Travel Blog & Insider Guides 2026 | Tips, Sights & Itineraries - {$siteName}");
            $desc = $locale === 'ar'
                ? 'دليلك الشامل ونصائح خبراء السياحة في دبي. تعرف على أفضل أوقات الزيارة، الفعاليات الحصرية، ومطاعم وأماكن الترفيه في الإمارات.'
                : ($locale === 'ru'
                    ? 'Полезные советы и статьи об отдыхе в Дубае: лучшие пляжи, шопинг, правила, визы и секретные локации.'
                    : 'Insider tips, travel itineraries, and comprehensive guides for visiting Dubai and the UAE from local luxury travel experts.');
        }

        static::setMeta($title, $desc, asset('assets/images/tour_burj.jpg'), ['Dubai blog', 'Dubai travel guide', 'visit Dubai tips', 'Dubai travel news']);
    }

    /**
     * Single Blog Post SEO.
     */
    public static function setPost(Post $post): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();
        $titleText = (string) $post->title;
        $featuredImage = $post->getFirstMediaUrl('featured') ?: asset('assets/images/tour_burj.jpg');
        $summary = $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags((string) $post->content), 160));
        $metaTitle = $post->meta_title ?: "{$titleText} | {$siteName}";

        $keywords = [];
        if ($post->relationLoaded('tags') && $post->tags) {
            $keywords = $post->tags->pluck('name')->toArray();
        }

        static::setMeta($metaTitle, (string) $summary, $featuredImage, $keywords, 'article');

        // OpenGraph Article properties
        if ($post->published_at) {
            SEOTools::opengraph()->addProperty('article:published_time', $post->published_at->toIso8601String());
        }
        if ($post->author?->name) {
            SEOTools::opengraph()->addProperty('article:author', $post->author->name);
        }

        // JSON-LD BlogPosting
        SEOTools::jsonLd()->setType('BlogPosting');
        SEOTools::jsonLd()->addValue('headline', $titleText);
        if ($post->published_at) {
            SEOTools::jsonLd()->addValue('datePublished', $post->published_at->toIso8601String());
            SEOTools::jsonLd()->addValue('dateModified', ($post->updated_at ?? $post->published_at)->toIso8601String());
        }
        if ($post->author?->name) {
            SEOTools::jsonLd()->addValue('author', [
                '@type' => 'Person',
                'name'  => $post->author->name,
            ]);
        }
        SEOTools::jsonLd()->addValue('publisher', [
            '@type' => 'Organization',
            'name'  => $siteName,
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => asset(Setting::get('general.logo', '/assets/images/logo.svg')),
            ],
        ]);
    }

    /**
     * Gallery & Album SEO.
     */
    public static function setGallery(?Album $album = null): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        if ($album) {
            $name = (string) $album->name;
            $title = $locale === 'ar'
                ? "ألبوم صور {$name} | معرض صور وفيديوهات دبي - {$siteName}"
                : ($locale === 'ru'
                    ? "Альбом {$name} | Фото и Видео Дубая - {$siteName}"
                    : "{$name} Photo & Video Album | Dubai Luxury Travel - {$siteName}");
            $desc = $album->description ? Str::limit(strip_tags((string) $album->description), 160) : "High-resolution photos and videos of {$name} in Dubai.";
            $image = $album->getFirstMediaUrl('images') ?: asset('assets/images/hero.jpg');
        } else {
            $title = $locale === 'ar'
                ? "معرض صور وفيديوهات سياحة دبي 4K | تجارب المسافرين - {$siteName}"
                : ($locale === 'ru'
                    ? "Фото и Видео Галерея Дубая 4K | Впечатления Туристов - {$siteName}"
                    : "Dubai Luxury Tourism Photo & Video Gallery 4K - {$siteName}");
            $desc = $locale === 'ar'
                ? 'شاهد أروع صور وفيديوهات معالم دبي السياحية، رحلات السفاري، الجولات البحرية وتجارب ضيوفنا السعداء بجودة عالية.'
                : ($locale === 'ru'
                    ? 'Смотрите великолепные кадры достопримечательностей Дубая, сафари и яхт от наших гостей.'
                    : 'Browse stunning high-resolution photography and 4K videos of Dubai landmarks, VIP desert safaris, and luxury yacht charters.');
            $image = asset('assets/images/hero.jpg');
        }

        static::setMeta($title, $desc, $image, ['Dubai photos', 'Dubai videos', 'Dubai gallery', 'desert safari photos']);
    }

    /**
     * Testimonials SEO.
     */
    public static function setTestimonials(): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "آراء وتقييمات العملاء والمسافرين | تجارب حقيقية في دبي - {$siteName}"
            : ($locale === 'ru'
                ? "Отзывы Наших Клиентов об Экскурсиях в Дубае - {$siteName}"
                : "Traveler Reviews & Testimonials | Verified Dubai Tours - {$siteName}");

        $desc = $locale === 'ar'
            ? 'اقرأ تجارب وتقييمات زوار دبي من السعودية ودول الخليج والعالم. تقييمات موثوقة لرحلات السفاري واليخوت والجولات الفاخرة.'
            : ($locale === 'ru'
                ? 'Реальные отзывы гостей о VIP сафари, яхтах и индивидуальных турах в ОАЭ.'
                : 'Read authentic traveler reviews and feedback from guests who experienced our VIP Dubai tours, desert safaris, and luxury vacations.');

        static::setMeta($title, $desc, asset('assets/images/hero.jpg'), ['Dubai tour reviews', 'Dubai tour book ratings', 'Dubai travel testimonials']);
    }

    /**
     * FAQs SEO with FAQPage Schema.
     */
    public static function setFaqs($faqs = null): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "الأسئلة الشائعة حول السفر والسياحة في دبي 2026 - {$siteName}"
            : ($locale === 'ru'
                ? "Часто Задаваемые Вопросы о Поездке в Дубай 2026: FAQ - {$siteName}"
                : "Frequently Asked Questions (FAQ) | Dubai Travel & Tours 2026 - {$siteName}");

        $desc = $locale === 'ar'
            ? 'إجابات على كافة استفسارات السفر إلى دبي: التأشيرات، أفضل أوقات الزيارة، حجز الجولات، وسائل النقل وطرق الدفع المعتمدة.'
            : ($locale === 'ru'
                ? 'Ответы на популярные вопросы о турах, бронировании, погоде, дресс-коде и трансферах в Дубае.'
                : 'Find all the answers to frequently asked questions about booking tours, desert safaris, hotel transfers, and travel tips for Dubai.');

        static::setMeta($title, $desc, asset('assets/images/hero.jpg'), ['Dubai FAQ', 'Dubai travel questions', 'Dubai safari tips', 'visa to Dubai']);

        // FAQPage Schema
        if ($faqs && count($faqs) > 0) {
            $mainEntity = [];
            foreach ($faqs as $faq) {
                $mainEntity[] = [
                    '@type'          => 'Question',
                    'name'           => (string) $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => strip_tags((string) $faq->answer),
                    ],
                ];
            }
            SEOTools::jsonLd()->setType('FAQPage');
            SEOTools::jsonLd()->addValue('mainEntity', $mainEntity);
        }
    }

    /**
     * Contact Page SEO.
     */
    public static function setContact(): void
    {
        $locale = app()->getLocale();
        $siteName = static::siteName();

        $title = $locale === 'ar'
            ? "تواصل معنا | خدمة عملاء وكونسيرج دبي على مدار الساعة - {$siteName}"
            : ($locale === 'ru'
                ? "Контакты | Круглосуточная Консьерж Служба в Дубае 24/7 - {$siteName}"
                : "Contact Us | 24/7 VIP Concierge & Customer Care Dubai - {$siteName}");

        $desc = $locale === 'ar'
            ? 'تواصل مع فريق خبراء دبي تور بوك عبر الواتساب أو الهاتف أو البريد الإلكتروني لتخطيط وتخصيص رحلتك الفاخرة.'
            : ($locale === 'ru'
                ? 'Свяжитесь с нами через WhatsApp, телефон или форму обратной связи для организации индивидуального тура в Дубае.'
                : 'Get in touch with our VIP travel specialists via WhatsApp, phone, or email to customize your bespoke Dubai itinerary.');

        static::setMeta($title, $desc, asset('assets/images/hero.jpg'), ['Contact Dubai Tour Book', 'Dubai concierge', 'Dubai travel agency phone', 'WhatsApp Dubai tours']);

        SEOTools::jsonLd()->setType('ContactPage');
    }

    /**
     * Set robots to noindex, nofollow for sensitive / private pages.
     */
    public static function setNoIndex(): void
    {
        SEOMeta::addMeta('robots', 'noindex, nofollow');
    }
}
