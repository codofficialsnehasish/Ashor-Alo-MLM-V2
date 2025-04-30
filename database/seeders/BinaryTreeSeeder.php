<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Hash;

class BinaryTreeSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $users = [];

        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'phone' => $i.'999999999',
                'password' => Hash::make('password'),
                'decoded_password' => "password",
            ]);
            
            // Assign Leader role to the user
            $user->assignRole('Leader');
            
            $users[$i] = $user;
        }

        // Insert into Binary Tree
        foreach ($users as $i => $user) {
            $sponsorId = ($i === 1) ? null : $users[1]->id; // First user is root
            insertInBinaryTree($user->id, $sponsorId);
        }
    }
}

