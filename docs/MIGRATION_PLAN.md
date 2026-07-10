# UAE Tourism — HTML → Laravel Migration Plan

Decisions (confirmed 2026-07-10): Tailwind CSS 4 kept (no Bootstrap) · Laravel app at repo root `d:\tourism` · MySQL 8.4 (WAMP) · Full multilingual content EN/AR/RU with RTL · PHP 8.4.15 (`D:\server\wamp64\bin\php\php8.4.15\php.exe`) · spatie/laravel-permission (DB-driven sidebar menu) · spatie/laravel-medialibrary with media stored under `public/media` (no `storage:link`).

---

## 1. Existing HTML Project Inventory

### Pages
| Page | File | Status |
|---|---|---|
| Home (single-page site) | `index.html` | Convert to dynamic Blade |

Sections in `index.html`: fixed glass navbar with language switcher (EN/AR/RU) · full-screen hero · Featured Destinations grid (Dubai, Abu Dhabi, Sharjah, RAK) · Experiences (3 icon cards) · Trending Tours (Swiper carousel, 4 tours) · Testimonials (2 cards) · Footer (about / quick links / contact).

All other pages required by the brief (About, Destinations index/detail, Packages, Hotels, Transport, Gallery, Testimonials, FAQs, Blog, Contact, Booking, Auth, User Dashboard, Admin) **do not exist** and will be designed new in the same gold/deep-black/off-white Tailwind theme.

### Assets
- `assets/css/style.css` — Tailwind 4 `@theme` (gold `#D4AF37`, deepblack `#111111`, offwhite `#F9F9F9`, Inter + Cairo fonts), `.glass`, `.glass-dark`, `.text-shadow` utilities, gold scrollbar, RTL font switch.
- `assets/js/main.js` — AOS init, Swiper init (1/2/3 slides responsive), sticky navbar blur on scroll.
- `assets/js/i18n.js` — client-side JSON translation loader + `dir`/`lang` switching (will be replaced by server-side Laravel localization).
- `assets/images/` — 9 JPGs (hero, 4 destinations, 4 tours).
- `locales/en.json, ar.json, ru.json` — UI strings (will seed Laravel `lang/` files).

### Third-party dependencies
Google Fonts (Inter, Cairo) · AOS 2.3.1 · Swiper 11 · Tailwind CSS 4 via `@tailwindcss/vite` · Vite 8.

### Forms / JS features
No forms exist yet. JS features to preserve: AOS animations, Swiper carousel, sticky glass navbar, language/RTL switching.

---

## 2. Migration Plan (phases — pause for confirmation after each)

1. **Foundation** — Scaffold latest Laravel at repo root; Vite + Tailwind 4 with existing theme; move images to `public/assets/images`; `layouts/app.blade.php`, `partials/navbar`, `partials/footer`, Blade components; server-side localization (EN/AR/RU, RTL, locale-prefixed URLs); dynamic Home page.
2. **Database core + Auth** — All migrations, models, factories, seeders; auth (login, register, forgot password, email verification, profile, change password) styled to theme.
3. **Roles & Admin shell** — spatie/laravel-permission; roles: Super Admin, Admin, Tour Manager, Booking Manager, Customer; DB-driven sidebar menu (`admin_menus` table filtered by permission); `layouts/admin.blade.php` + dashboard with stats & charts.
4. **Destinations module** — CRUD, medialibrary (featured + gallery in `public/media`), map location, frontend index/detail.
5. **Tour Packages** — CRUD, itinerary builder, included/excluded services, availability; frontend listing with filters + detail.
6. **Hotels** — CRUD, rooms, amenities (many-to-many), star rating; frontend listing/detail.
7. **Transport** — cars/vans/buses/flights/pickups CRUD + frontend.
8. **Bookings** — customer booking flow (date, guests, pay later/online), booking number, status lifecycle (pending/approved/rejected/cancelled/completed), PDF download (dompdf), cancel; admin approval + reports; user dashboard.
9. **Gallery & Testimonials** — albums, images, videos; testimonial submission + moderation.
10. **Blog** — categories, posts, tags, comments, SEO slugs.
11. **Contact, Newsletter, FAQs, Settings** — contact inbox with reply (mail), subscribers, FAQ CRUD, site settings (logo, favicon, contact info, socials, footer, SEO defaults).
12. **Search/Filters, SEO, Performance, Security** — global search + filters (destination, country, budget, duration, date, rating); meta/OG/canonical component, XML sitemap, robots.txt; eager loading, caching, pagination, `Model::preventLazyLoading`; policies, form requests everywhere, secure uploads.

---

## 3. Database Schema

### Auth & access
- **users** — name, email (unique), phone, password, email_verified_at, status, soft deletes
- **user_profiles** — user_id FK unique (**1:1**), address, city, country, passport_no, dob, avatar
- spatie tables: roles, permissions, model_has_roles, model_has_permissions, role_has_permissions
- **admin_menus** — parent_id (self FK), title, route, icon, permission_name, sort_order, status → sidebar rendered from DB filtered by the logged-in user's permissions

### Tourism core
- **destinations** — slug unique, name (JSON translatable), country, city, description (JSON), map_lat, map_lng, is_featured, status, sort_order. Media: `featured`, `gallery` collections
- **tour_packages** — destination_id FK indexed (**1:N**), slug unique, name (JSON), summary/description (JSON), price, sale_price, duration_days, duration_nights, included_services (JSON), excluded_services (JSON), max_guests, available_from, available_to, is_featured, status. Media: `featured`, `gallery`
- **package_itineraries** — tour_package_id FK, day_number, title (JSON), description (JSON)
- **hotels** — destination_id FK (**1:N**), slug, name (JSON), star_rating (1–5), description (JSON), address, status. Media: `gallery`
- **rooms** — hotel_id FK (**1:N**), name (JSON), price_per_night, capacity, quantity, status. Media: `images`
- **amenities** — name (JSON), icon
- **amenity_hotel** — pivot (**M:N**)
- **transports** — type enum(car, van, bus, flight, pickup), name (JSON), description (JSON), capacity, price, price_unit, status. Media: `images`

### Bookings & payments
- **bookings** — booking_number unique, user_id FK, bookable_type + bookable_id (morph: package/room/transport, indexed), travel_date, adults, children, unit_price, total_price, payment_method enum(pay_later, online), status enum(pending, approved, rejected, cancelled, completed), admin_note, cancelled_at
- **payments** — booking_id FK (**1:N**), amount, method, transaction_id, status, paid_at

### Content
- **albums** — name (JSON), slug, description (JSON), status. Media: `images`
- **gallery_videos** — album_id FK nullable, title (JSON), video_url, sort_order, status
- **testimonials** — user_id FK nullable, name, country, rating (1–5), content, status enum(pending, approved, rejected)
- **blog_categories** — name (JSON), slug, status
- **posts** — user_id FK, blog_category_id FK, title (JSON), slug unique, excerpt (JSON), content (JSON), meta_title, meta_description, status, published_at (indexed). Media: `featured`
- **tags** — name (JSON), slug; **post_tag** pivot (**M:N**)
- **comments** — post_id FK, user_id FK nullable, parent_id self FK, name, email, body, status
- **faqs** — question (JSON), answer (JSON), sort_order, status

### Site
- **contact_messages** — name, email, phone, subject, message, status enum(new, read, replied), reply_message, replied_at
- **newsletter_subscribers** — email unique, status, subscribed_at
- **settings** — group, key (unique with group), value (JSON) — logo, favicon, site name, email, phone, address, socials, footer, SEO defaults
- spatie **media** table — with custom `media` disk rooted at `public/media`, URLs `/media/...` (no symlink)

Relationships cover 1:1 (user↔profile), 1:N (destination→packages/hotels, hotel→rooms, booking→payments, post→comments), M:N (hotel↔amenity, post↔tag, user↔role), polymorphic (bookings, media).

---

## 4. Folder Structure (key parts)

```
app/
  Http/
    Controllers/
      Frontend/   HomeController, DestinationController, PackageController, HotelController,
                  TransportController, GalleryController, BlogController, ContactController,
                  BookingController, TestimonialController, NewsletterController, FaqController
      Admin/      DashboardController + one resource controller per module
      Auth/       (starter-kit controllers restyled)
    Requests/     Admin/... , Frontend/...  (all validation via Form Requests)
    Middleware/   SetLocale
  Models/
  Services/      BookingService, SettingService, ReportService
  Policies/
  Enums/         BookingStatus, PaymentMethod, TransportType, ContentStatus
resources/views/
  layouts/       app.blade.php, admin.blade.php, guest.blade.php
  partials/      navbar, footer, sidebar, admin-topbar
  components/    section-heading, destination-card, package-card, hotel-card, seo-meta,
                 alert, form inputs, pagination
  frontend/      home, about, destinations/, packages/, hotels/, transport/, gallery/,
                 blog/, testimonials/, faqs/, contact, booking/
  admin/         dashboard, <module>/index|create|edit ...
  dashboard/     user dashboard (bookings, profile)
lang/            en/, ar/, ru/  (+ JSON files) — seeded from old locales/*.json
public/
  assets/        css/js/images from the old site
  media/         spatie medialibrary root (custom disk, no storage:link)
routes/          web.php (frontend + auth), admin.php
database/        migrations, seeders (roles, menus, settings, demo content), factories
```

---

## 5. Notes
- "Laravel 13": scaffold with `composer create-project laravel/laravel` (latest stable) using PHP 8.4.15; PHP 8.5.0 is available if required.
- Old `index.html`, `assets/`, `locales/`, `dist/`, Vite config are removed after their content is ported (git history preserves them).
- The client-side i18n loader is replaced by server-side locale-prefixed routes (`/en`, `/ar`, `/ru`) + `dir="rtl"` for Arabic; translatable DB fields via spatie/laravel-translatable.
