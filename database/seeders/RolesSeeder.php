<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
     {
         app()[PermissionRegistrar::class]->forgetCachedPermissions();

         $adminRole = Role::firstOrCreate(['name' => 'admin']);
         $adminRole->givePermissionTo(['manage topics', 'write topics', 'delete topics', 'edit topics']);

         $writerRole = Role::firstOrCreate(['name' => 'writer']);
         $writerRole->givePermissionTo(['write posts', 'manage own posts']);

         Role::firstOrCreate(['name' => 'user']);
     }
}
