<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@themembers.com',
            'password' => bcrypt('password'),
        ]);

        $writer = User::updateOrCreate([
            'name' => 'User',
            'email' => 'writer@themembers.com',
            'password' => bcrypt('password'),
        ]);

        $user = User::updateOrCreate([
            'name' => 'User',
            'email' => 'user@themembers.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole('admin');
        $writer->assignRole('writer');
        $user->assignRole('user');
    }
}