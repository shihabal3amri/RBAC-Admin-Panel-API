<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Call the AdminSeeder
        $this->call(AdminSeeder::class);
        $this->call(ModeratorSeeder::class);
        $this->call(UserWithoutRolesSeeder::class);
    }
}
