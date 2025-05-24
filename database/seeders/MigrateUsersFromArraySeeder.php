<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Address;
use App\Models\BankDetail;
use App\Models\BinaryTree;
use App\Models\Nominee;
use Illuminate\Support\Facades\Hash;

class MigrateUsersFromArraySeeder extends Seeder
{
    /**
     * The array containing all user data
     * 
     * @var array
     */
    protected $usersArray = [
        // Your PHP array of user data here
        // Example:
        /*
        [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            // ... all other fields from your old table
        ],
        */
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (empty($this->usersArray)) {
            $this->command->error('No user data provided in the array.');
            return;
        }

        $this->command->info('Starting user migration from array...');
        $this->command->getOutput()->progressStart(count($this->usersArray));

        foreach ($this->usersArray as $oldUser) {
            try {
                \DB::beginTransaction();

                // Skip if user is deleted in old system
                if (!empty($oldUser['is_deleted']) && $oldUser['is_deleted']) {
                    continue;
                }

                // Create new User
                $newUser = User::create([
                    'name' => $oldUser['name'] ?? null,
                    'email' => $oldUser['email'] ?? null,
                    'phone' => $oldUser['phone'] ?? null,
                    'password' => $oldUser['password'] ?? Hash::make('password'), // fallback
                    'decoded_password' => $oldUser['decoded_password'] ?? null,
                    'status' => ($oldUser['status'] ?? '0') == '1' ? 'active' : 'inactive',
                    'email_verified_at' => (!empty($oldUser['is_email_verified']) && $oldUser['is_email_verified']) 
                        ? ($oldUser['email_verified_at'] ?? now()) 
                        : null,
                    'created_at' => $oldUser['created_at'] ?? now(),
                    'updated_at' => $oldUser['updated_at'] ?? now(),
                ]);

                // Create UserProfile
                UserProfile::create([
                    'user_id' => $newUser->id,
                    'father_or_husband_name' => $oldUser['father_or_husband_name'] ?? null,
                    'date_of_birth' => $oldUser['date_of_birth'] ?? null,
                    'gender' => $oldUser['gender'] ?? null,
                    'marital_status' => $oldUser['marital_status'] ?? null,
                    'qualification' => $oldUser['qualification'] ?? null,
                    'occupation' => $oldUser['occupation'] ?? null,
                    'pan_number' => $oldUser['pan_number'] ?? null,
                    'aadhar_number' => $oldUser['aadhar_number'] ?? null,
                    'created_at' => $oldUser['created_at'] ?? now(),
                    'updated_at' => $oldUser['updated_at'] ?? now(),
                ]);

                // Create Address
                Address::create([
                    'user_id' => $newUser->id,
                    'shipping_address' => $oldUser['shipping_address'] ?? null,
                    'country_id' => $oldUser['country'] ?? 0,
                    'address' => $oldUser['address'] ?? null,
                    'state_id' => $oldUser['state'] ?? 0,
                    'city_id' => $oldUser['city'] ?? 0,
                    'pin_code' => $oldUser['pin_code'] ?? null,
                    'created_at' => $oldUser['created_at'] ?? now(),
                    'updated_at' => $oldUser['updated_at'] ?? now(),
                ]);

                // Create BankDetail if bank info exists
                if (!empty($oldUser['bank_name']) || !empty($oldUser['account_number']) || !empty($oldUser['upi_number'])) {
                    BankDetail::create([
                        'user_id' => $newUser->id,
                        'bank_name' => $oldUser['bank_name'] ?? null,
                        'account_name' => $oldUser['account_name'] ?? null,
                        'ifsc_code' => $oldUser['ifsc_code'] ?? null,
                        'account_number' => $oldUser['account_number'] ?? null,
                        'account_type' => $oldUser['account_type'] ?? null,
                        'upi_name' => $oldUser['upi_name'] ?? null,
                        'upi_number' => $oldUser['upi_number'] ?? null,
                        'upi_type' => $oldUser['upi_type'] ?? null,
                        'created_at' => $oldUser['created_at'] ?? now(),
                        'updated_at' => $oldUser['updated_at'] ?? now(),
                    ]);
                }

                // Create Nominee if nominee info exists
                if (!empty($oldUser['nominee_name'])) {
                    Nominee::create([
                        'user_id' => $newUser->id,
                        'name' => $oldUser['nominee_name'] ?? null,
                        'relation' => $oldUser['nominee_relation'] ?? null,
                        'date_of_birth' => $oldUser['nominee_dob'] ?? null,
                        'address' => $oldUser['nominee_address'] ?? null,
                        'state_id' => $oldUser['nominee_state_id'] ?? 0,
                        'city_id' => $oldUser['nominee_city_id'] ?? 0,
                        'created_at' => $oldUser['created_at'] ?? now(),
                        'updated_at' => $oldUser['updated_at'] ?? now(),
                    ]);
                }

                // Create BinaryTree entry
                $binaryTree = BinaryTree::create([
                    'user_id' => $newUser->id,
                    'member_number' => $oldUser['user_id'] ?? null, // Assuming user_id in old table is member number
                    'sponsor_id' => $this->getSponsorId($oldUser['agent_id'] ?? null),
                    'parent_id' => $this->getParentId($oldUser['parent_id'] ?? null),
                    'position' => $this->determinePosition($oldUser),
                    'status' => ($oldUser['status'] ?? '0') == '1' ? 'active' : 'inactive',
                    'activated_at' => ($oldUser['status'] ?? '0') == '1' ? now() : null,
                    'join_by' => $oldUser['join_by'] ?? null,
                    'created_at' => $oldUser['created_at'] ?? now(),
                    'updated_at' => $oldUser['updated_at'] ?? now(),
                ]);

                \DB::commit();
                $this->command->getOutput()->progressAdvance();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->command->error("Failed to migrate user {$oldUser['id'] ?? 'unknown'}: " . $e->getMessage());
            }
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('User migration from array completed.');
    }

    /**
     * Get sponsor ID from old agent_id
     */
    protected function getSponsorId($oldAgentId)
    {
        if (!$oldAgentId) return null;
        
        // Find the user with this old ID
        $sponsorUser = User::where('phone', function($query) use ($oldAgentId) {
            $query->select('phone')
                  ->from('users')
                  ->where('id', $oldAgentId);
        })->first();

        if (!$sponsorUser) return null;

        // Find the binary tree entry for the agent
        $sponsorBinary = BinaryTree::where('user_id', $sponsorUser->id)->first();
        return $sponsorBinary ? $sponsorBinary->id : null;
    }

    /**
     * Get parent ID from old parent_id
     */
    protected function getParentId($oldParentId)
    {
        if (!$oldParentId) return null;
        
        // Find the user with this old ID
        $parentUser = User::where('phone', function($query) use ($oldParentId) {
            $query->select('phone')
                  ->from('users')
                  ->where('id', $oldParentId);
        })->first();

        if (!$parentUser) return null;

        // Find the binary tree entry for the parent
        $parentBinary = BinaryTree::where('user_id', $parentUser->id)->first();
        return $parentBinary ? $parentBinary->id : null;
    }

    /**
     * Determine position based on old is_left/is_right flags
     */
    protected function determinePosition($oldUser)
    {
        if (!empty($oldUser['is_left']) && $oldUser['is_left']) return 'left';
        if (!empty($oldUser['is_right']) && $oldUser['is_right']) return 'right';
        return null; // root or not placed yet
    }
}