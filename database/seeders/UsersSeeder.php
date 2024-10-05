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
            'email' => 'admin@themembers.com.br',
            'password' => bcrypt('password'),
        ]);

        $writer = User::updateOrCreate([
            'name' => 'User',
            'email' => 'writer@themembers.com.br',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin')->markEmailAsVerified();
        $writer->assignRole('writer')->markEmailAsVerified();
    }
}
