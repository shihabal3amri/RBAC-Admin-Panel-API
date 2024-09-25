<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class ModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Retrieve the existing 'manage-users' permission
        $manageUsersPermission = Permission::where('name', 'manage-users')->first();

        if (!$manageUsersPermission) {
            $this->command->error('The manage-users permission does not exist. Please run the AdminSeeder first.');
            return;
        }

        // Step 2: Create the Moderator Role if it doesn't exist
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);

        // Step 3: Assign the 'manage-users' permission to the Moderator role
        $moderatorRole->permissions()->syncWithoutDetaching([$manageUsersPermission->id]);

        // Step 4: Create a Moderator User if it doesn't exist
        $moderatorUser = User::firstOrCreate([
            'email' => 'moderator@example.com',
        ], [
            'name' => 'Moderator User',
            'password' => Hash::make('password123'), // Change to a secure password
        ]);

        // Step 5: Assign the Moderator role to the user
        $moderatorUser->roles()->syncWithoutDetaching([$moderatorRole->id]);

        // Optionally, log a message that the moderator user was created
        $this->command->info('Moderator account created with email: moderator@example.com');
    }
}
