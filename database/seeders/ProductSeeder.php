<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{

    protected $product = [
        ['id' => '4','title' => 'Hotel','slug' => 'hotel','sku' => '1','category_id' => '5','subcategory_id' => NULL,'price' => '3.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '3.00','gst_amount' => '0.00','total_price' => '3.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727533878_Hotel 2.jpg','created_at' => '2024-08-04 15:35:58','updated_at' => '2024-09-28 20:01:18'],
        ['id' => '5','title' => 'Restaurant','slug' => 'restaurant','sku' => '2','category_id' => '5','subcategory_id' => NULL,'price' => '5.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '5.00','gst_amount' => '0.00','total_price' => '5.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727534018_Hotel .jpg','created_at' => '2024-08-04 15:40:37','updated_at' => '2024-09-28 20:03:38'],
        ['id' => '6','title' => 'Hotel and restaurant','slug' => 'hotel-and-restaurant','sku' => '3','category_id' => '5','subcategory_id' => NULL,'price' => '0.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '0.00','gst_amount' => '0.00','total_price' => '0.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727534184_Hotel  1.jpg','created_at' => '2024-08-05 18:21:05','updated_at' => '2024-09-28 20:06:24'],
        ['id' => '8','title' => 'Sali Land','slug' => 'sali-land','sku' => '212','category_id' => '3','subcategory_id' => NULL,'price' => '300000.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '300000.00','gst_amount' => '0.00','total_price' => '300000.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727536148_Untitled.jpg','created_at' => '2024-09-28 20:39:08','updated_at' => '2024-09-28 20:39:08'],
        ['id' => '9','title' => 'ALL','slug' => 'all','sku' => 'Except Land','category_id' => '5','subcategory_id' => NULL,'price' => '3000.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '3000.00','gst_amount' => '0.00','total_price' => '3000.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '0','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727536293_images.jfif','created_at' => '2024-09-28 20:41:33','updated_at' => '2025-01-03 19:27:42'],
        ['id' => '10','title' => 'Activation','slug' => 'activation','sku' => '0','category_id' => '9','subcategory_id' => NULL,'price' => '1.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '1.00','gst_amount' => '0.00','total_price' => '1.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '0','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => 'https://ashoralo.in/public/web_directory/product_images/1727536571_360_F_864858762_0HihXjosuXmRXMoqR1sCY1gNDZ51bamD.jpg','created_at' => '2024-09-28 20:46:11','updated_at' => '2024-09-30 20:38:35'],
        ['id' => '11','title' => 'Add On','slug' => 'add-on-1','sku' => '5','category_id' => '10','subcategory_id' => NULL,'price' => '300.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '300.00','gst_amount' => '0.00','total_price' => '300.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '0','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '0','is_addon' => '1','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => NULL,'created_at' => '2024-11-04 19:47:45','updated_at' => '2025-01-07 16:06:50'],
        ['id' => '13','title' => 'Grocery','slug' => 'grocery-1','sku' => '4','category_id' => '11','subcategory_id' => NULL,'price' => '5000.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '5000.00','gst_amount' => '0.00','total_price' => '5000.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => NULL,'created_at' => '2025-02-04 17:48:42','updated_at' => '2025-04-26 18:01:06'],
        ['id' => '14','title' => 'xfthrth','slug' => 'xfthrth-1','sku' => 'thtrh','category_id' => '10','subcategory_id' => NULL,'price' => '6.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '6.00','gst_amount' => '0.00','total_price' => '6.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '1','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '0','is_special_product' => '0','weight' => NULL,'product_image' => NULL,'created_at' => '2025-04-01 20:02:41','updated_at' => '2025-04-01 20:02:58'],
        ['id' => '15','title' => 'Special','slug' => 'special','sku' => '9','category_id' => '5','subcategory_id' => NULL,'price' => '100000.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '100000.00','gst_amount' => '0.00','total_price' => '100000.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '0','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '0','is_addon' => '0','is_dilse' => '0','is_special_product' => '1','weight' => NULL,'product_image' => NULL,'created_at' => '2025-04-18 16:11:16','updated_at' => '2025-04-25 13:01:05'],
        ['id' => '16','title' => 'DIL SE','slug' => 'dil-se','sku' => '11','category_id' => '12','subcategory_id' => NULL,'price' => '50000.00','discount_rate' => NULL,'no_discount' => '0','gst_rate' => NULL,'discounted_price' => '50000.00','gst_amount' => '0.00','total_price' => '50000.00','short_desc' => NULL,'description' => NULL,'product_specification' => NULL,'is_visible' => '1','rating' => NULL,'shipping_time' => NULL,'shipping_cost' => NULL,'is_deleted' => '0','is_draft' => '0','is_featured' => '1','is_addon' => '0','is_dilse' => '1','is_special_product' => '0','weight' => NULL,'product_image' => NULL,'created_at' => '2025-04-29 17:21:04','updated_at' => '2025-04-29 17:21:04']
    ];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        if (empty($this->product)) {
            $this->command->error('No Category data provided in the array.');
            return;
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  
        $this->command->info('Starting Category migration from array...');
        $this->command->getOutput()->progressStart(count($this->product));

        foreach ($this->product as $acc) {
            try {
                \DB::beginTransaction();

                $this->command->info('Processing Category id : '.$acc['id']);

                // Create new User
                $category = new Product();
                $category->id = $acc['id'];
                $category->title = $acc['title'];
                $category->slug = $acc['slug'];
                $category->sku = $acc['sku'];
                $category->category_id = $acc['category_id'];
                $category->product_type = 'simple';
                $category->price = $acc['price'];
                $category->discount_rate = $acc['discount_rate'];
                $category->no_discount = $acc['no_discount'];
                $category->discounted_price = $acc['discounted_price'];
                $category->gst_rate = $acc['gst_rate'];
                $category->gst_amount = $acc['gst_amount'];
                $category->total_price = $acc['total_price'];
                $category->is_visible = $acc['is_visible'];
                $category->short_desc = $acc['short_desc'];
                $category->description = $acc['description'];
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
