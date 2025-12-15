<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    protected $categories = [
        array('id' => '3','name' => 'Land','parent_id' => NULL,'slug' => 'land','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2024-08-04 15:27:59','updated_at' => '2025-04-17 18:24:07'),
        array('id' => '4','name' => 'Building Materials','parent_id' => NULL,'slug' => 'building-materials','image' => NULL,'visibility' => '0','is_deleted' => '0','created_at' => '2024-08-04 15:29:42','updated_at' => '2024-12-21 13:30:56'),
        array('id' => '5','name' => 'FMCG','parent_id' => NULL,'slug' => 'fmcg','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2024-08-04 15:30:19','updated_at' => '2025-02-04 17:50:20'),
        array('id' => '9','name' => 'Only Activation','parent_id' => NULL,'slug' => 'only-activation','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2024-08-05 18:19:34','updated_at' => '2025-07-02 20:31:48'),
        array('id' => '10','name' => 'Add On Products','parent_id' => NULL,'slug' => 'add-on-products','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2024-11-04 19:30:26','updated_at' => '2024-11-04 19:30:26'),
        array('id' => '11','name' => 'Grocery','parent_id' => NULL,'slug' => 'grocery','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2025-02-04 17:49:51','updated_at' => '2025-04-26 17:57:07'),
        array('id' => '12','name' => 'DIL SE','parent_id' => NULL,'slug' => 'dil-se','image' => NULL,'visibility' => '1','is_deleted' => '0','created_at' => '2025-04-29 17:19:23','updated_at' => '2025-04-29 17:19:23')
    ];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        if (empty($this->categories)) {
            $this->command->error('No Category data provided in the array.');
            return;
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  
        $this->command->info('Starting Category migration from array...');
        $this->command->getOutput()->progressStart(count($this->categories));

        foreach ($this->categories as $acc) {
            try {
                \DB::beginTransaction();

                $this->command->info('Processing Category id : '.$acc['id']);

                // Create new User
                $category = new Category();
                $category->id = $acc['id'];
                $category->name = $acc['name'];
                $category->slug = $acc['slug'];
                $category->description = null;
                $category->parent_id = $acc['parent_id'];
                $category->is_visible = $acc['visibility'];
                $category->created_at = $acc['created_at'];
                $category->updated_at = $acc['updated_at'];
                $category->save();

                \DB::commit();
                $this->command->getOutput()->progressAdvance();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->command->error("Failed to migrate Category" . $e->getMessage());  
            }
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->getOutput()->progressFinish();
        $this->command->info('Category migration from array completed.');
    }
}
