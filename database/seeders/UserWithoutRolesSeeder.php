<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserWithoutRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Create a User without roles
        $user = User::firstOrCreate([
            'email' => 'userwithoutroles@example.com',
        ], [
            'name' => 'User Without Roles',
            'password' => Hash::make('password123'), // Change to a secure password
        ]);

        // Optionally, log a message that the user was created
        $this->command->info('User without roles created with email: userwithoutroles@example.com');
    }
}
