<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevelBonusMaster;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LevelBonusMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table first
        DB::table('level_bonus_masters')->truncate();

        $levels = [
            array('id' => '1','level_name' => '1st','level_number' => '1','level_percentage' => '2','is_visible' => '1','created_at' => '2024-06-29 11:49:40','updated_at' => '2024-07-05 19:18:31'),
            array('id' => '2','level_name' => '2nd','level_number' => '2','level_percentage' => '1','is_visible' => '1','created_at' => '2024-06-29 11:50:03','updated_at' => '2024-07-05 19:18:39'),
            array('id' => '3','level_name' => '3rd','level_number' => '3','level_percentage' => '.7','is_visible' => '1','created_at' => '2024-06-29 11:50:22','updated_at' => '2024-07-16 17:28:47'),
            array('id' => '4','level_name' => '4th','level_number' => '4','level_percentage' => '.5','is_visible' => '1','created_at' => '2024-07-05 18:23:20','updated_at' => '2024-07-16 17:28:55'),
            array('id' => '5','level_name' => '5th','level_number' => '5','level_percentage' => '.4','is_visible' => '1','created_at' => '2024-07-05 18:25:57','updated_at' => '2024-07-16 17:29:02'),
            array('id' => '6','level_name' => '6th','level_number' => '6','level_percentage' => '0.4','is_visible' => '1','created_at' => '2024-07-05 18:26:21','updated_at' => '2024-07-17 14:14:30'),
            array('id' => '7','level_name' => '7th','level_number' => '7','level_percentage' => '.3','is_visible' => '1','created_at' => '2024-07-05 18:26:45','updated_at' => '2024-07-16 17:29:17'),
            array('id' => '8','level_name' => '8th','level_number' => '8','level_percentage' => '.3','is_visible' => '1','created_at' => '2024-07-05 18:27:07','updated_at' => '2024-07-16 17:29:25'),
            array('id' => '9','level_name' => '9th','level_number' => '9','level_percentage' => '.3','is_visible' => '1','created_at' => '2024-07-05 18:27:24','updated_at' => '2024-07-16 17:29:32'),
            array('id' => '10','level_name' => '10th','level_number' => '10','level_percentage' => '.5','is_visible' => '1','created_at' => '2024-07-05 18:27:41','updated_at' => '2024-07-17 14:15:45'),
            array('id' => '11','level_name' => '11th','level_number' => '11','level_percentage' => '.4','is_visible' => '1','created_at' => '2024-07-05 18:27:59','updated_at' => '2024-07-17 14:17:00'),
            array('id' => '12','level_name' => '12th','level_number' => '12','level_percentage' => '.25','is_visible' => '1','created_at' => '2024-07-05 18:28:23','updated_at' => '2024-07-17 14:18:12'),
            array('id' => '13','level_name' => '13th','level_number' => '13','level_percentage' => '.25','is_visible' => '1','created_at' => '2024-07-05 18:28:41','updated_at' => '2024-07-17 14:18:56'),
            array('id' => '14','level_name' => '14th','level_number' => '14','level_percentage' => '.2','is_visible' => '1','created_at' => '2024-07-05 18:28:54','updated_at' => '2024-07-17 14:20:15'),
            array('id' => '15','level_name' => '15th','level_number' => '15','level_percentage' => '.2','is_visible' => '1','created_at' => '2024-07-05 18:29:12','updated_at' => '2024-07-17 14:21:12'),
            array('id' => '16','level_name' => '16th','level_number' => '16','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:29:28','updated_at' => '2024-07-17 14:21:59'),
            array('id' => '17','level_name' => '17th','level_number' => '17','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:29:58','updated_at' => '2024-07-17 14:22:45'),
            array('id' => '18','level_name' => '18th','level_number' => '18','level_percentage' => '.3','is_visible' => '1','created_at' => '2024-07-05 18:30:14','updated_at' => '2024-07-17 14:23:13'),
            array('id' => '19','level_name' => '19th','level_number' => '19','level_percentage' => '.3','is_visible' => '1','created_at' => '2024-07-05 18:31:24','updated_at' => '2024-07-17 14:23:46'),
            array('id' => '20','level_name' => '20th','level_number' => '20','level_percentage' => '.2','is_visible' => '1','created_at' => '2024-07-05 18:31:43','updated_at' => '2024-07-17 14:24:14'),
            array('id' => '21','level_name' => '21st','level_number' => '21','level_percentage' => '.2','is_visible' => '1','created_at' => '2024-07-05 18:32:28','updated_at' => '2024-07-17 14:24:49'),
            array('id' => '22','level_name' => '22st','level_number' => '22','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:32:47','updated_at' => '2024-07-17 14:25:22'),
            array('id' => '23','level_name' => '23rd','level_number' => '23','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:33:11','updated_at' => '2024-07-17 14:26:56'),
            array('id' => '24','level_name' => '24th','level_number' => '24','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:33:53','updated_at' => '2024-07-17 14:27:29'),
            array('id' => '25','level_name' => '25th','level_number' => '25','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:34:07','updated_at' => '2024-07-17 14:28:00'),
            array('id' => '26','level_name' => '26th','level_number' => '26','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:34:30','updated_at' => '2024-07-17 14:28:33'),
            array('id' => '27','level_name' => '27th','level_number' => '27','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:34:50','updated_at' => '2024-07-17 14:29:12'),
            array('id' => '28','level_name' => '28th','level_number' => '28','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:35:24','updated_at' => '2024-07-17 14:30:10'),
            array('id' => '29','level_name' => '29th','level_number' => '29','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:35:49','updated_at' => '2024-07-17 14:30:34'),
            array('id' => '30','level_name' => '30th','level_number' => '30','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:36:06','updated_at' => '2024-07-17 14:31:29'),
            array('id' => '31','level_name' => '31st','level_number' => '31','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:36:28','updated_at' => '2024-07-17 14:32:11'),
            array('id' => '32','level_name' => '32nd','level_number' => '32','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:36:50','updated_at' => '2024-07-17 14:32:34'),
            array('id' => '33','level_name' => '33rd','level_number' => '33','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:37:31','updated_at' => '2024-07-17 14:32:58'),
            array('id' => '34','level_name' => '34th','level_number' => '34','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:37:47','updated_at' => '2024-07-17 14:33:20'),
            array('id' => '35','level_name' => '35th','level_number' => '35','level_percentage' => '.1','is_visible' => '1','created_at' => '2024-07-05 18:38:08','updated_at' => '2024-07-17 14:33:42'),
            array('id' => '36','level_name' => '36th','level_number' => '36','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:38:36','updated_at' => '2024-07-17 14:34:06'),
            array('id' => '37','level_name' => '37th','level_number' => '37','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:38:54','updated_at' => '2024-07-17 14:34:46'),
            array('id' => '38','level_name' => '38th','level_number' => '38','level_percentage' => '.15','is_visible' => '1','created_at' => '2024-07-05 18:39:18','updated_at' => '2024-07-17 14:35:16'),
            array('id' => '39','level_name' => '39th','level_number' => '39','level_percentage' => '.2','is_visible' => '1','created_at' => '2024-07-05 18:39:41','updated_at' => '2024-07-17 14:35:39'),
            array('id' => '40','level_name' => '40th','level_number' => '40','level_percentage' => '.25','is_visible' => '1','created_at' => '2024-07-05 18:39:58','updated_at' => '2024-07-17 14:36:10')
        ];

        foreach ($levels as $level) {
            LevelBonusMaster::create($level);
        }

        $this->command->info('LevelBonusMaster table seeded with 40 levels!');
    }
}