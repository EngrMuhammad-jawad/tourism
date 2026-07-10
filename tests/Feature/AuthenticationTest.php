<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_login_screen_renders_in_every_locale(): void
    {
        foreach (['en', 'ar', 'ru'] as $locale) {
            $this->get("/$locale/login")->assertOk();
        }
    }

    public function test_new_users_can_register_and_get_customer_role(): void
    {
        $response = $this->post('/en/register', [
            'name' => 'Test Traveller',
            'email' => 'traveller@example.com',
            'phone' => '+971501234567',
            'password' => 'SuperSecret1!',
            'password_confirmation' => 'SuperSecret1!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/en/verify-email');

        $user = User::where('email', 'traveller@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('Customer'));
        $this->assertNotNull($user->profile);
    }

    public function test_users_can_login_and_reach_account_page(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/en/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/en/account');

        $this->actingAs($user)->get('/en/account')->assertOk()->assertSee($user->name);
    }

    public function test_inactive_users_cannot_login(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->post('/en/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_unverified_users_are_redirected_to_verification_notice(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get('/en/account')
            ->assertRedirect('/en/verify-email');
    }

    public function test_users_can_update_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/en/account', [
            'name' => 'Updated Name',
            'email' => $user->email,
            'phone' => '+971509999999',
            'address' => 'Marina Walk',
            'city' => 'Dubai',
            'country' => 'UAE',
            'passport_no' => 'A1234567',
            'date_of_birth' => '1990-05-20',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect();

        $user->refresh()->load('profile');
        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('Dubai', $user->profile->city);
    }

    public function test_users_can_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/en/account/password', [
            'current_password' => 'password',
            'password' => 'NewSecret123!',
            'password_confirmation' => 'NewSecret123!',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/en/logout')->assertRedirect('/en');

        $this->assertGuest();
    }
}
