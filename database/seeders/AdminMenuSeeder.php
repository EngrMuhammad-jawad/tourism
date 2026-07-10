<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Database-driven admin sidebar. "route" holds a route name that the
     * sidebar partial resolves with route(); items whose permission the
     * user lacks are hidden.
     */
    public function run(): void
    {
        AdminMenu::query()->forceDelete();

        $items = [
            ['title' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'home', 'permission_name' => 'dashboard.view'],
            ['title' => 'Destinations', 'route' => 'admin.destinations.index', 'icon' => 'map', 'permission_name' => 'destinations.view'],
            ['title' => 'Tour Packages', 'route' => 'admin.packages.index', 'icon' => 'ticket', 'permission_name' => 'packages.view'],
            ['title' => 'Hotels', 'route' => 'admin.hotels.index', 'icon' => 'building', 'permission_name' => 'hotels.view'],
            ['title' => 'Transport', 'route' => 'admin.transports.index', 'icon' => 'truck', 'permission_name' => 'transports.view'],
            ['title' => 'Bookings', 'route' => 'admin.bookings.index', 'icon' => 'calendar', 'permission_name' => 'bookings.view'],
            ['title' => 'Gallery', 'route' => 'admin.albums.index', 'icon' => 'photo', 'permission_name' => 'gallery.view'],
            ['title' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'star', 'permission_name' => 'testimonials.view'],
            ['title' => 'Blog', 'icon' => 'pencil', 'permission_name' => 'blog.view', 'children' => [
                ['title' => 'Categories', 'route' => 'admin.blog-categories.index', 'permission_name' => 'blog.view'],
                ['title' => 'Posts', 'route' => 'admin.posts.index', 'permission_name' => 'blog.view'],
                ['title' => 'Tags', 'route' => 'admin.tags.index', 'permission_name' => 'blog.view'],
                ['title' => 'Comments', 'route' => 'admin.comments.index', 'permission_name' => 'comments.moderate'],
            ]],
            ['title' => 'FAQs', 'route' => 'admin.faqs.index', 'icon' => 'question', 'permission_name' => 'faqs.view'],
            ['title' => 'Contact Messages', 'route' => 'admin.contact-messages.index', 'icon' => 'mail', 'permission_name' => 'contacts.view'],
            ['title' => 'Newsletter', 'route' => 'admin.newsletter.index', 'icon' => 'paper-airplane', 'permission_name' => 'newsletter.view'],
            ['title' => 'Reports', 'route' => 'admin.reports.index', 'icon' => 'chart', 'permission_name' => 'reports.view'],
            ['title' => 'Users', 'route' => 'admin.users.index', 'icon' => 'users', 'permission_name' => 'users.view'],
            ['title' => 'Roles & Permissions', 'route' => 'admin.roles.index', 'icon' => 'shield', 'permission_name' => 'roles.manage'],
            ['title' => 'Sidebar Menu', 'route' => 'admin.menus.index', 'icon' => 'bars', 'permission_name' => 'menus.manage'],
            ['title' => 'Settings', 'route' => 'admin.settings.index', 'icon' => 'cog', 'permission_name' => 'settings.manage'],
        ];

        foreach ($items as $order => $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);

            $parent = AdminMenu::create([...$item, 'sort_order' => $order]);

            foreach ($children as $childOrder => $child) {
                AdminMenu::create([...$child, 'parent_id' => $parent->id, 'sort_order' => $childOrder]);
            }
        }
    }
}
