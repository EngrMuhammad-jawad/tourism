<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Module permissions follow "module.action". The Super Admin role is
     * not given explicit permissions — Gate::before() in AppServiceProvider
     * grants it everything.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'destinations.view', 'destinations.create', 'destinations.edit', 'destinations.delete',
            'packages.view', 'packages.create', 'packages.edit', 'packages.delete',
            'hotels.view', 'hotels.create', 'hotels.edit', 'hotels.delete',
            'transports.view', 'transports.create', 'transports.edit', 'transports.delete',
            'bookings.view', 'bookings.manage',
            'reports.view',
            'gallery.view', 'gallery.manage',
            'testimonials.view', 'testimonials.moderate',
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete',
            'comments.moderate',
            'contacts.view', 'contacts.reply', 'contacts.delete',
            'newsletter.view', 'newsletter.manage',
            'faqs.view', 'faqs.manage',
            'settings.manage',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.manage',
            'menus.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        Role::findOrCreate('Super Admin');

        Role::findOrCreate('Admin')->syncPermissions(
            collect($permissions)->reject(fn ($p) => in_array($p, ['roles.manage', 'menus.manage']))->all()
        );

        Role::findOrCreate('Tour Manager')->syncPermissions([
            'dashboard.view',
            'destinations.view', 'destinations.create', 'destinations.edit', 'destinations.delete',
            'packages.view', 'packages.create', 'packages.edit', 'packages.delete',
            'hotels.view', 'hotels.create', 'hotels.edit', 'hotels.delete',
            'transports.view', 'transports.create', 'transports.edit', 'transports.delete',
            'gallery.view', 'gallery.manage',
        ]);

        Role::findOrCreate('Booking Manager')->syncPermissions([
            'dashboard.view',
            'bookings.view', 'bookings.manage',
            'reports.view',
            'contacts.view', 'contacts.reply',
        ]);

        Role::findOrCreate('Customer');
    }
}
