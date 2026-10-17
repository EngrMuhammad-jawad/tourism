<?php

namespace Tests\Feature;

use App\Enums\ContactStatus;
use App\Enums\ModerationStatus;
use App\Enums\PostStatus;
use App\Enums\TransportType;
use App\Models\AttractionTicket;
use App\Models\BlogCategory;
use App\Models\ContactMessage;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminModuleSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin user and assign Super Admin role to bypass gates
        $this->adminUser = User::factory()->create();
        Role::findOrCreate('Super Admin');
        $this->adminUser->assignRole('Super Admin');
    }

    public function test_destinations_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        // 1. Visit index page
        $this->actingAs($this->adminUser)
            ->get(route('admin.destinations.index'))
            ->assertOk()
            ->assertSee('Destinations')
            ->assertSee('Add new');

        // 2. Visit create page
        $this->actingAs($this->adminUser)
            ->get(route('admin.destinations.create'))
            ->assertOk()
            ->assertSee('Create Destinations')
            ->assertSee('Name');

        // 3. Store new destination
        $postData = [
            'slug' => 'test-destination',
            'name' => 'Test Destination',
            'country' => 'United Arab Emirates',
            'city' => 'Test City',
            'description' => 'A beautiful test destination.',
            'status' => true,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.destinations.store'), $postData);

        $response->assertRedirect(route('admin.destinations.index'));
        $response->assertSessionHas('success', 'Destinations record created.');

        $this->assertDatabaseHas('destinations', [
            'slug' => 'test-destination',
            'city' => 'Test City',
        ]);

        $destination = Destination::where('slug', 'test-destination')->first();

        // 4. Visit edit page
        $this->actingAs($this->adminUser)
            ->get(route('admin.destinations.edit', $destination))
            ->assertOk()
            ->assertSee('Edit Destinations')
            ->assertSee('Test Destination');

        // 5. Update destination
        $updateData = array_merge($postData, [
            'name' => 'Updated Destination Name',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.destinations.update', $destination), $updateData);

        $response->assertRedirect(route('admin.destinations.index'));
        $response->assertSessionHas('success', 'Destinations record updated.');

        // Verify the database has the updated translation or value
        $this->assertEquals('Updated Destination Name', $destination->refresh()->getTranslation('name', 'en'));

        // 6. Delete destination
        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.destinations.destroy', $destination));

        $response->assertRedirect(route('admin.destinations.index'));
        $response->assertSessionHas('success', 'Destinations record deleted.');

        $this->assertTrue($destination->refresh()->trashed());
    }

    public function test_packages_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $destination = Destination::factory()->create();

        // 1. Visit index page
        $this->actingAs($this->adminUser)
            ->get(route('admin.packages.index'))
            ->assertOk()
            ->assertSee('Tour Packages');

        // 2. Visit create page
        $this->actingAs($this->adminUser)
            ->get(route('admin.packages.create'))
            ->assertOk()
            ->assertSee('Create Tour Packages');

        // 3. Store new package
        $postData = [
            'destination_id' => $destination->id,
            'slug' => 'test-package',
            'name' => 'Test Tour Package',
            'summary' => 'A short summary of the test package.',
            'description' => 'A detailed description of the test package.',
            'price' => 250.50,
            'duration_days' => 3,
            'status' => true,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.packages.store'), $postData);

        $response->assertRedirect(route('admin.packages.index'));
        $response->assertSessionHas('success', 'Tour Packages record created.');

        $this->assertDatabaseHas('tour_packages', [
            'destination_id' => $destination->id,
            'slug' => 'test-package',
            'price' => 250.50,
        ]);

        $package = TourPackage::where('slug', 'test-package')->first();

        // 4. Visit edit page
        $this->actingAs($this->adminUser)
            ->get(route('admin.packages.edit', $package))
            ->assertOk()
            ->assertSee('Edit Tour Packages')
            ->assertSee('Test Tour Package');

        // 5. Update package
        $updateData = array_merge($postData, [
            'name' => 'Updated Package Name',
            'price' => 299.99,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.packages.update', $package), $updateData);

        $response->assertRedirect(route('admin.packages.index'));
        $response->assertSessionHas('success', 'Tour Packages record updated.');

        $this->assertEquals('Updated Package Name', $package->refresh()->getTranslation('name', 'en'));
        $this->assertEquals(299.99, $package->price);

        // 6. Delete package
        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.packages.destroy', $package));

        $response->assertRedirect(route('admin.packages.index'));
        $response->assertSessionHas('success', 'Tour Packages record deleted.');

        $this->assertTrue($package->refresh()->trashed());
    }

    public function test_tickets_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser)
            ->get(route('admin.tickets.index'))
            ->assertOk()
            ->assertSee('Attraction Tickets');

        $this->actingAs($this->adminUser)
            ->get(route('admin.tickets.create'))
            ->assertOk()
            ->assertSee('Create Attraction Tickets');

        $postData = [
            'slug' => 'test-ticket',
            'title' => 'Test Attraction Ticket',
            'city' => 'Dubai',
            'counter_price' => 199.00,
            'our_price' => 149.00,
            'status' => true,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.tickets.store'), $postData);

        $response->assertRedirect(route('admin.tickets.index'));
        $this->assertDatabaseHas('attraction_tickets', [
            'slug' => 'test-ticket',
            'our_price' => 149.00,
        ]);

        $ticket = AttractionTicket::where('slug', 'test-ticket')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.tickets.edit', $ticket))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.tickets.update', $ticket), array_merge($postData, [
                'our_price' => 129.00,
            ]));

        $response->assertRedirect(route('admin.tickets.index'));
        $this->assertEquals(129.00, $ticket->refresh()->our_price);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.tickets.destroy', $ticket));

        $response->assertRedirect(route('admin.tickets.index'));
        $this->assertTrue($ticket->refresh()->trashed());
    }

    public function test_hotels_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $destination = Destination::factory()->create();

        $this->actingAs($this->adminUser)
            ->get(route('admin.hotels.index'))
            ->assertOk()
            ->assertSee('Hotels');

        $this->actingAs($this->adminUser)
            ->get(route('admin.hotels.create'))
            ->assertOk();

        $postData = [
            'destination_id' => $destination->id,
            'slug' => 'test-hotel',
            'name' => 'Burj Al Arab Test',
            'star_rating' => 5,
            'address' => 'Jumeirah Beach Road',
            'status' => true,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.hotels.store'), $postData);

        $response->assertRedirect(route('admin.hotels.index'));
        $this->assertDatabaseHas('hotels', [
            'slug' => 'test-hotel',
            'star_rating' => 5,
        ]);

        $hotel = Hotel::where('slug', 'test-hotel')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.hotels.edit', $hotel))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.hotels.update', $hotel), array_merge($postData, [
                'name' => 'Updated Hotel Name',
            ]));

        $response->assertRedirect(route('admin.hotels.index'));
        $this->assertEquals('Updated Hotel Name', $hotel->refresh()->getTranslation('name', 'en'));

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.hotels.destroy', $hotel));

        $response->assertRedirect(route('admin.hotels.index'));
        $this->assertTrue($hotel->refresh()->trashed());
    }

    public function test_transports_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser)
            ->get(route('admin.transports.index'))
            ->assertOk()
            ->assertSee('Transport');

        $this->actingAs($this->adminUser)
            ->get(route('admin.transports.create'))
            ->assertOk();

        $postData = [
            'type' => TransportType::Car->value,
            'slug' => 'test-car',
            'name' => 'VIP Rolls Royce',
            'price' => 500.00,
            'capacity' => 4,
            'status' => true,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.transports.store'), $postData);

        $response->assertRedirect(route('admin.transports.index'));
        $this->assertDatabaseHas('transports', [
            'slug' => 'test-car',
            'price' => 500.00,
        ]);

        $transport = Transport::where('slug', 'test-car')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.transports.edit', $transport))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.transports.update', $transport), array_merge($postData, [
                'price' => 550.00,
            ]));

        $response->assertRedirect(route('admin.transports.index'));
        $this->assertEquals(550.00, $transport->refresh()->price);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.transports.destroy', $transport));

        $response->assertRedirect(route('admin.transports.index'));
        $this->assertTrue($transport->refresh()->trashed());
    }

    public function test_posts_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $category = BlogCategory::create([
            'slug' => 'travel-tips',
            'name' => 'Travel Tips',
            'status' => true,
        ]);

        $this->actingAs($this->adminUser)
            ->get(route('admin.posts.index'))
            ->assertOk()
            ->assertSee('Blog Posts');

        $this->actingAs($this->adminUser)
            ->get(route('admin.posts.create'))
            ->assertOk();

        $postData = [
            'user_id' => $this->adminUser->id,
            'blog_category_id' => $category->id,
            'slug' => 'test-blog-post',
            'title' => 'Top 10 Things to Do in Dubai',
            'content' => 'Comprehensive travel guide content.',
            'status' => PostStatus::Published->value,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.posts.store'), $postData);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'slug' => 'test-blog-post',
            'status' => PostStatus::Published->value,
        ]);

        $post = Post::where('slug', 'test-blog-post')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.posts.edit', $post))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.posts.update', $post), array_merge($postData, [
                'title' => 'Updated Top 10 Things',
            ]));

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertEquals('Updated Top 10 Things', $post->refresh()->getTranslation('title', 'en'));

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.posts.destroy', $post));

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertTrue($post->refresh()->trashed());
    }

    public function test_testimonials_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser)
            ->get(route('admin.testimonials.index'))
            ->assertOk()
            ->assertSee('Testimonials');

        $postData = [
            'name' => 'John Doe',
            'country' => 'United Kingdom',
            'rating' => 5,
            'content' => 'Exceptional service and unforgettable safari!',
            'status' => ModerationStatus::Approved->value,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.testimonials.store'), $postData);

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', [
            'name' => 'John Doe',
            'rating' => 5,
            'status' => ModerationStatus::Approved->value,
        ]);

        $testimonial = Testimonial::where('name', 'John Doe')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.testimonials.edit', $testimonial))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.testimonials.update', $testimonial), array_merge($postData, [
                'country' => 'Canada',
            ]));

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertEquals('Canada', $testimonial->refresh()->country);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.testimonials.destroy', $testimonial));

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertTrue($testimonial->refresh()->trashed());
    }

    public function test_faqs_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser)
            ->get(route('admin.faqs.index'))
            ->assertOk();

        $postData = [
            'question' => 'How can I book a private safari?',
            'answer' => 'You can book directly on our website or contact our concierge via WhatsApp.',
            'status' => true,
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.faqs.store'), $postData);

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', [
            'sort_order' => 1,
            'status' => true,
        ]);

        $faq = Faq::where('sort_order', 1)->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.faqs.edit', $faq))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.faqs.update', $faq), array_merge($postData, [
                'answer' => 'Updated answer text.',
            ]));

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertEquals('Updated answer text.', $faq->refresh()->getTranslation('answer', 'en'));

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.faqs.destroy', $faq));

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertTrue($faq->refresh()->trashed());
    }

    public function test_contact_messages_crud_workflow(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser)
            ->get(route('admin.contact-messages.index'))
            ->assertOk();

        $postData = [
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'phone' => '+971501112233',
            'subject' => 'Corporate Yacht Event',
            'message' => 'Looking for a private yacht charter for 30 guests.',
            'status' => ContactStatus::New->value,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.contact-messages.store'), $postData);

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'sarah@example.com',
            'status' => ContactStatus::New->value,
        ]);

        $msg = ContactMessage::where('email', 'sarah@example.com')->first();

        $this->actingAs($this->adminUser)
            ->get(route('admin.contact-messages.edit', $msg))
            ->assertOk();

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.contact-messages.update', $msg), array_merge($postData, [
                'status' => ContactStatus::Replied->value,
                'reply_message' => 'Our team has sent you the brochure.',
            ]));

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertEquals(ContactStatus::Replied, $msg->refresh()->status);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.contact-messages.destroy', $msg));

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertTrue($msg->refresh()->trashed());
    }
}
