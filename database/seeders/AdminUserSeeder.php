<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * One account per role for local testing. Each account's password is
     * its own email address.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Super Admin',     'email' => 'superadmin@uaetourism.test', 'role' => 'Super Admin'],
            ['name' => 'Site Admin',      'email' => 'admin@uaetourism.test',      'role' => 'Admin'],
            ['name' => 'Tour Manager',    'email' => 'tours@uaetourism.test',      'role' => 'Tour Manager'],
            ['name' => 'Booking Manager', 'email' => 'bookings@uaetourism.test',   'role' => 'Booking Manager'],
            ['name' => 'Demo Customer',   'email' => 'customer@uaetourism.test',   'role' => 'Customer'],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['email']),
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles($data['role']);
            $user->profile()->firstOrCreate([]);
        }
    }
}
