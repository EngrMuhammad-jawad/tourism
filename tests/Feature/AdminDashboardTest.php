<?php

namespace Tests\Feature;

use App\Models\AdminMenu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_with_dashboard_permission_can_view_the_admin_dashboard(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('dashboard.view'));

        AdminMenu::create([
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'home',
            'permission_name' => 'dashboard.view',
            'sort_order' => 1,
            'status' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Dashboard');
    }

    public function test_a_customer_without_dashboard_permission_is_forbidden_from_admin(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
