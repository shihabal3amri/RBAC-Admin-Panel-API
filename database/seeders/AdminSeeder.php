<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Step 1: Create Permissions
        $permissions = [
            'view-admin-panel',
            'manage-users',
            'manage-roles',
            'manage-permissions',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Step 2: Create the Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign all permissions to the admin role
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        // Step 3: Create the Admin User
        $adminUser = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password123'), // You can change this to a secure password
        ]);

        // Step 4: Assign Admin Role to the Admin User
        $adminUser->roles()->sync([$adminRole->id]);

        // Optionally, log a message that the admin user was created
        $this->command->info('Admin account created with email: admin@example.com');
    }
}
