<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\ContactStatus;
use App\Enums\PaymentMethod;
use App\Enums\PostStatus;
use App\Enums\TransportType;
use App\Models\Album;
use App\Models\BlogCategory;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Room;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FrontendFunctionalTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected Destination $dubai;
    protected TourPackage $package;
    protected Hotel $hotel;
    protected Transport $transport;
    protected Post $post;
    protected Album $album;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);

        $this->customer = User::factory()->create();
        $this->customer->assignRole('Customer');

        $this->dubai = Destination::create([
            'slug' => 'dubai',
            'name' => 'Dubai',
            'country' => 'United Arab Emirates',
            'city' => 'Dubai',
            'description' => 'City of gold and wonders.',
            'status' => true,
        ]);

        $this->package = TourPackage::create([
            'destination_id' => $this->dubai->id,
            'slug' => 'burj-khalifa-vip-experience',
            'name' => 'Burj Khalifa VIP Experience',
            'summary' => 'Access levels 124, 125, and 148.',
            'description' => 'Fast track entry to the world tallest tower.',
            'price' => 399.00,
            'status' => true,
        ]);

        $this->hotel = Hotel::create([
            'destination_id' => $this->dubai->id,
            'slug' => 'atlantis-the-royal',
            'name' => 'Atlantis The Royal',
            'star_rating' => 5,
            'description' => 'Ultra-luxury resort on the Palm Jumeirah.',
            'address' => 'Palm Jumeirah, Dubai',
            'status' => true,
        ]);

        Room::create([
            'hotel_id' => $this->hotel->id,
            'name' => 'Sky Terrace Suite',
            'capacity' => 2,
            'price_per_night' => 1200.00,
            'status' => true,
        ]);

        $this->transport = Transport::create([
            'type' => TransportType::Car,
            'slug' => 'desert-safari-4x4-land-cruiser',
            'name' => 'Desert Safari 4x4 Land Cruiser',
            'description' => 'Private desert safari Land Cruiser with professional safari marshal.',
            'capacity' => 6,
            'price' => 450.00,
            'price_unit' => 'per_vehicle',
            'status' => true,
        ]);

        $category = BlogCategory::create([
            'slug' => 'travel-guides',
            'name' => 'Travel Guides',
            'status' => true,
        ]);

        $this->post = Post::create([
            'user_id' => $this->customer->id,
            'blog_category_id' => $category->id,
            'slug' => 'burj-khalifa-tickets-guide',
            'title' => 'Complete Guide to Burj Khalifa Tickets 2026',
            'content' => 'Full review of levels 124, 125, and the 148 VIP lounge.',
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
        ]);

        $this->album = Album::create([
            'slug' => 'dubai-skyline',
            'name' => 'Dubai Skyline & Architecture',
            'description' => 'Aerial views of Downtown Dubai and Marina.',
            'status' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_home_page_renders_in_all_locales(): void
    {
        foreach (['en', 'ar', 'ru'] as $locale) {
            $response = $this->get("/{$locale}");
            $response->assertOk();
            $response->assertSee('Dubai');
        }
    }

    public function test_commercial_landing_pages_render_successfully(): void
    {
        $landings = [
            'dubai-desert-safari',
            'dubai-city-tour',
            'burj-khalifa-tickets',
            'dubai-yacht-tour',
            'dubai-airport-transfer',
            'abu-dhabi-city-tour',
            'dubai-private-tours',
        ];

        foreach ($landings as $slug) {
            $response = $this->get("/en/{$slug}");
            $response->assertOk();
        }
    }

    public function test_destinations_catalog_pages_render(): void
    {
        $this->get('/en/destinations')
            ->assertOk()
            ->assertSee('Dubai');

        $this->get("/en/destinations/{$this->dubai->slug}")
            ->assertOk()
            ->assertSee('Burj Khalifa VIP Experience');
    }

    public function test_packages_catalog_pages_render(): void
    {
        $this->get('/en/packages')
            ->assertOk()
            ->assertSee('Burj Khalifa VIP Experience');

        $this->get("/en/packages/{$this->package->slug}")
            ->assertOk()
            ->assertSee('399');
    }

    public function test_hotels_catalog_and_detail_render_without_lazy_load_violations(): void
    {
        $this->get('/en/hotels')
            ->assertOk()
            ->assertSee('Atlantis The Royal');

        $this->get("/en/hotels/{$this->hotel->slug}")
            ->assertOk()
            ->assertSee('Sky Terrace Suite');
    }

    public function test_transports_catalog_and_detail_render_without_lazy_load_violations(): void
    {
        // 301 Redirect from /transports to /transport
        $this->get('/en/transports')->assertRedirect('/en/transport');

        $this->get('/en/transport')
            ->assertOk()
            ->assertSee('Desert Safari 4x4 Land Cruiser');

        $this->get("/en/transport/{$this->transport->slug}")
            ->assertOk()
            ->assertSee('450');
    }

    public function test_gallery_and_album_pages_render(): void
    {
        $this->get('/en/gallery')
            ->assertOk()
            ->assertSee('Dubai Skyline & Architecture');

        $this->get("/en/gallery/{$this->album->slug}")
            ->assertOk()
            ->assertSee('Dubai Skyline & Architecture');
    }

    public function test_gallery_media_upload_workflow(): void
    {
        $response = $this->post('/en/gallery/upload', [
            'media_type' => 'video',
            'title' => 'Dubai Marina Yacht Tour 4K',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gallery_videos', [
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);
    }

    public function test_faqs_page_renders(): void
    {
        Faq::create([
            'question' => 'Is pickup included for desert safaris?',
            'answer' => 'Yes, free 4x4 hotel pickup and drop-off are included.',
            'status' => true,
            'sort_order' => 1,
        ]);

        $this->get('/en/faqs')
            ->assertOk()
            ->assertSee('Is pickup included for desert safaris?');
    }

    public function test_blog_posts_and_detail_render(): void
    {
        // 301 Redirect from journal to blog
        $this->get('/en/journal')->assertRedirect('/en/blog');

        $this->get('/en/blog')
            ->assertOk()
            ->assertSee('Complete Guide to Burj Khalifa Tickets 2026');

        $this->get("/en/blog/{$this->post->slug}")
            ->assertOk()
            ->assertSee('Complete Guide to Burj Khalifa Tickets 2026');
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/en/contact', [
            'name' => 'Alexander Smith',
            'email' => 'alex@example.com',
            'phone' => '+971501234567',
            'subject' => 'Private Yacht Charter Inquiry',
            'message' => 'We are interested in booking a 60ft luxury yacht for 15 guests on Friday evening.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'alex@example.com',
            'status' => ContactStatus::New->value,
        ]);
    }

    public function test_newsletter_subscription(): void
    {
        $response = $this->post('/en/newsletter', [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'subscriber@example.com',
            'is_active' => true,
        ]);
    }

    public function test_vip_service_request_submission_form_and_ajax(): void
    {
        // 1. Regular Form Submit
        $response = $this->actingAs($this->customer)->post('/en/service-requests', [
            'service_type' => 'desert_safari',
            'name' => 'James Bond',
            'email' => '007@mi6.gov.uk',
            'phone' => '+447911123456',
            'service_date' => now()->addDays(3)->toDateString(),
            'guests_count' => 2,
            'notes' => 'Red dunes VIP private camp.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('service_requests', [
            'service_type' => 'desert_safari',
            'email' => '007@mi6.gov.uk',
            'status' => 'pending',
        ]);

        // 2. AJAX Submit (JSON response)
        $ajaxResponse = $this->postJson('/en/service-requests', [
            'service_type' => 'flights',
            'name' => 'Elena Rostova',
            'email' => 'elena@example.com',
            'phone' => '+971509876543',
            'service_date' => now()->addDays(7)->toDateString(),
            'guests_count' => 4,
            'notes' => 'First class Dubai to London.',
        ]);

        $ajaxResponse->assertOk()
            ->assertJson([
                'success' => true,
                'service_type' => 'flights',
            ]);
    }

    public function test_booking_create_form_and_store_workflow(): void
    {
        // Unauthenticated access to booking create redirects to login
        $this->get('/en/bookings/create?type=package&id=' . $this->package->id)
            ->assertRedirect('/en/login');

        // Authenticated access
        $this->actingAs($this->customer)
            ->get('/en/bookings/create?type=package&id=' . $this->package->id)
            ->assertOk()
            ->assertSee('Burj Khalifa VIP Experience');

        // Store booking
        $bookingData = [
            'type' => 'package',
            'id' => $this->package->id,
            'travel_date' => now()->addDays(5)->toDateString(),
            'adults' => 2,
            'children' => 1,
            'payment_method' => PaymentMethod::Online->value,
            'customer_note' => 'High floor observatory reservation.',
        ];

        $storeResponse = $this->actingAs($this->customer)
            ->post('/en/bookings', $bookingData);

        $storeResponse->assertRedirect('/en/dashboard');

        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->customer->id,
            'bookable_type' => TourPackage::class,
            'bookable_id' => $this->package->id,
            'unit_price' => 399.00,
            'total_price' => 1197.00, // 3 * 399
            'status' => BookingStatus::Pending->value,
        ]);

        // Dashboard renders booking
        $this->actingAs($this->customer)
            ->get('/en/dashboard')
            ->assertOk()
            ->assertSee('Burj Khalifa VIP Experience')
            ->assertSee('1,197 AED');

        $booking = Booking::where('user_id', $this->customer->id)->first();

        // Customer can cancel booking
        $cancelResponse = $this->actingAs($this->customer)
            ->post("/en/bookings/{$booking->id}/cancel");

        $cancelResponse->assertRedirect();
        $this->assertEquals(BookingStatus::Cancelled, $booking->refresh()->status);
    }

    public function test_sitemaps_and_ads_txt_render(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-pages.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-tours.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-destinations.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-blog.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-hotels.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->get('/sitemap-transports.xml')->assertOk()->assertHeader('Content-Type', 'text/xml; charset=UTF-8');

        $this->get('/ads.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function test_whatsapp_webhook_verification_and_message_handling(): void
    {
        // 1. GET Verification
        $verifyResponse = $this->get('/api/whatsapp/webhook?hub_mode=subscribe&hub_verify_token=dubai_tour_book_verify_token_2026&hub_challenge=test_challenge_code');
        $verifyResponse->assertOk()
            ->assertSee('test_challenge_code');

        // Invalid token returns 403
        $this->get('/api/whatsapp/webhook?hub_mode=subscribe&hub_verify_token=wrong_token&hub_challenge=test_challenge')
            ->assertForbidden();

        // 2. POST Message Handling
        $payload = [
            'entry' => [
                [
                    'changes' => [
                        [
                            'value' => [
                                'messages' => [
                                    [
                                        'from' => '971501234567',
                                        'type' => 'text',
                                        'text' => ['body' => 'I would like to book a flight'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $postResponse = $this->postJson('/api/whatsapp/webhook', $payload);
        $postResponse->assertOk()
            ->assertJson([
                'status' => 'success',
                'recipient' => '971501234567',
            ]);
    }
}
