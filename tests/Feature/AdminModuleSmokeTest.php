<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\TourPackage;
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
}
