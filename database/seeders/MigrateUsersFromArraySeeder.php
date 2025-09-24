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
    // protected $usersArray = array(

    // );

    protected $dataFiles = [
        'u1.php',
        'u2.php',
        'u3.php',
        'u4.php',
        'u5.php',
        'u6.php',
        'u7.php',
    ];


    protected string $baseUrl = 'https://ashoralo.in/public/';
    // protected string $baseUrl = 'https://old.ashoralo.in/';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->dataFiles as $file) {
            $this->command->info("Processing file: {$file}");
            $path = database_path('seeders/data/users/' . $file);
            
            if (!file_exists($path)) {
                $this->command->error("File not found: {$path}");
                continue;
            }
            // if (empty($this->usersArray)) {
            //     $this->command->error('No user data provided in the array.');
            //     return;
            // }

            $usersArray = require $path;

            $this->command->info('Starting user migration from array...');
            $this->command->getOutput()->progressStart(count($usersArray));

            foreach ($usersArray as $oldUser) {
                try {
                    \DB::beginTransaction();

                    // Skip if user is deleted in old system
                    // if (!empty($oldUser['is_deleted']) && $oldUser['is_deleted']) {
                    //     continue;
                    // }

                    $this->command->info('Processing user data name : '.$oldUser['name']);

                    // Create new User
                    $newUser = new User();
                    $newUser->id = $oldUser['id'];
                    $newUser->name = $oldUser['name'] ?? null;
                    $newUser->email = $oldUser['email'] ?? null;
                    $newUser->phone = $oldUser['phone'] ?? null;
                    $newUser->password = Hash::make($oldUser['decoded_password']);
                    $newUser->decoded_password = $oldUser['decoded_password'];
                    $newUser->is_block = $oldUser['block'];
                    $newUser->status = 1;
                    $newUser->is_hide = $oldUser['is_hide'];
                    $newUser->created_at = $oldUser['created_at'] ?? now();
                    $newUser->updated_at = $oldUser['updated_at'] ?? now();
                    $newUser->save();
                            
                    if (!empty($oldUser['user_image'])) {
                        // Step 1: Properly encode the URL (fixes spaces/special characters)
                        $imagePath = ltrim($oldUser['user_image'], '/');
                        $encodedPath = implode('/', array_map('rawurlencode', explode('/', $imagePath)));
                        $fullUrl = $this->baseUrl . $encodedPath;

                        $this->command->info("Attempting to fetch image from: {$fullUrl}");

                        try {
                            // Step 2: Use Guzzle as a fallback if addMediaFromUrl fails
                            try {
                                // First attempt: Standard Spatie Media Library method
                                $media = $newUser->addMediaFromUrl($fullUrl)
                                    ->withOptions(['verify' => false])  // Disable SSL verification if needed (dev only)
                                    ->toMediaCollection('profile-image');
                                
                                $this->command->info("Successfully added media from URL: {$fullUrl}");
                            } catch (\Exception $e) {
                                $this->command->warn("Standard method failed. Trying Guzzle fallback...");
                                
                                // Fallback: Manually fetch with Guzzle
                                $client = new \GuzzleHttp\Client();
                                $response = $client->get($fullUrl, [
                                    'headers' => ['User-Agent' => 'MyApp/1.0'],
                                    'verify' => false, // Disable SSL verification if needed
                                ]);
                                
                                $tempFile = tempnam(sys_get_temp_dir(), 'media_');
                                file_put_contents($tempFile, $response->getBody());
                                
                                $media = $newUser->addMedia($tempFile)->toMediaCollection('profile-image');
                                $this->command->info("Successfully added media via Guzzle fallback!");
                            }
                        } catch (\Exception $e) {
                            $this->command->error("ALL METHODS FAILED for URL {$fullUrl}: " . $e->getMessage());
                        }
                    }


                    if($oldUser['role'] === 'admin'){
                        if($oldUser['email'] === 'coddevelopers@gmail.com'){
                            $newUser->assignRole('Super Admin');
                        }else{
                            $newUser->assignRole('Admin');
                        }
                    }

                    if($oldUser['role'] === 'agent'){
                        $newUser->assignRole('Leader');

                        // Create UserProfile
                        UserProfile::create([
                            'user_id' => $newUser->id,
                            'father_or_husband_name' => $oldUser['father_or_husband_name'] ?? null,
                            'date_of_birth' => $oldUser['date_of_birth'] ?? null,
                            'gender' => $oldUser['gender'] ?? null,
                            'marital_status' => $this->check_marital_status($oldUser['marital_status']),
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
                            'country_id' => $oldUser['country'] != 0 ? $oldUser['country'] : null,
                            'address' => $oldUser['address'] ?? null,
                            'state_id' => $oldUser['state'] != 0 ? $oldUser['state'] : null,
                            'city_id' => $oldUser['city'] != 0 ? $oldUser['state'] : null,
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
                                'nominee_name' => $oldUser['nominee_name'] ?? null,
                                'nominee_relation' => $oldUser['nominee_relation'] ?? null,
                                'nominee_dob' => $oldUser['nominee_dob'] ?? null,
                                'nominee_address' => $oldUser['nominee_address'] ?? null,
                                'nominee_state_id' => $oldUser['nominee_state_id'] != 0 ? $oldUser['nominee_state_id'] : null,
                                'nominee_city_id' => $oldUser['nominee_city_id'] != 0 ? $oldUser['nominee_city_id'] : null,
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
                            'status' => $oldUser['status'],
                            'activated_at' => $oldUser['join_amount_put_date'] ?? null,
                            'join_by' => null,
                            'created_at' => $oldUser['created_at'] ?? now(),
                            'updated_at' => $oldUser['updated_at'] ?? now(),
                        ]);
                    }



                    \DB::commit();
                    $this->command->getOutput()->progressAdvance();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    $this->command->error("Failed to migrate user" . $e->getMessage());  
                }
            }

            $this->command->getOutput()->progressFinish();
        }
        $this->command->info('User migration from array completed.');
    }

    /**
     * Get sponsor ID from old agent_id
     */
    protected function getSponsorId($oldAgentId)
    {
        if (!$oldAgentId) return null;
        
        // Find the user with this old ID
        $sponsorUser = BinaryTree::where('member_number',$oldAgentId)->first();

        if (!$sponsorUser) return null;

        return $sponsorUser->id;
    }

    protected function check_marital_status($status){
        switch ($status) {
            case 'Married':
                return 'married';
                break;
            case 'Unmarried':
                return 'single';
                break;
            
            default:
                return 'single';
                break;
        }
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