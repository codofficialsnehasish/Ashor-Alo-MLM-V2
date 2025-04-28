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
            $users[$i] = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
            ]);
        }

        // Insert into Binary Tree
        foreach ($users as $i => $user) {
            $sponsorId = ($i === 1) ? null : $users[1]->id; // First user is root
            insertInBinaryTree($user->id, $sponsorId);
        }
    }
}

