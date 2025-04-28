<?php

namespace Database\Seeders;


use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure roles and permissions are seeded before assigning roles to users
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // Create a default Super Admin user
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'), // Make sure the password is hashed
        ]);

        // Assign the "Super Admin" role to the created user
        $user->assignRole('Super Admin');
    }

}
