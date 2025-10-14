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
            array('id' => '1','lavel_name' => '1st','level_number' => '1','lavel_persentage' => '2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-06-29 11:49:40','updated_at' => '2024-07-05 19:18:31'),
            array('id' => '2','lavel_name' => '2nd','level_number' => '2','lavel_persentage' => '1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-06-29 11:50:03','updated_at' => '2024-07-05 19:18:39'),
            array('id' => '3','lavel_name' => '3rd','level_number' => '3','lavel_persentage' => '.7','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-06-29 11:50:22','updated_at' => '2024-07-16 17:28:47'),
            array('id' => '4','lavel_name' => '4th','level_number' => '4','lavel_persentage' => '.5','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:23:20','updated_at' => '2024-07-16 17:28:55'),
            array('id' => '5','lavel_name' => '5th','level_number' => '5','lavel_persentage' => '.4','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:25:57','updated_at' => '2024-07-16 17:29:02'),
            array('id' => '6','lavel_name' => '6th','level_number' => '6','lavel_persentage' => '0.4','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:26:21','updated_at' => '2024-07-17 14:14:30'),
            array('id' => '7','lavel_name' => '7th','level_number' => '7','lavel_persentage' => '.3','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:26:45','updated_at' => '2024-07-16 17:29:17'),
            array('id' => '8','lavel_name' => '8th','level_number' => '8','lavel_persentage' => '.3','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:27:07','updated_at' => '2024-07-16 17:29:25'),
            array('id' => '9','lavel_name' => '9th','level_number' => '9','lavel_persentage' => '.3','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:27:24','updated_at' => '2024-07-16 17:29:32'),
            array('id' => '10','lavel_name' => '10th','level_number' => '10','lavel_persentage' => '.5','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:27:41','updated_at' => '2024-07-17 14:15:45'),
            array('id' => '11','lavel_name' => '11th','level_number' => '11','lavel_persentage' => '.4','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:27:59','updated_at' => '2024-07-17 14:17:00'),
            array('id' => '12','lavel_name' => '12th','level_number' => '12','lavel_persentage' => '.25','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:28:23','updated_at' => '2024-07-17 14:18:12'),
            array('id' => '13','lavel_name' => '13th','level_number' => '13','lavel_persentage' => '.25','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:28:41','updated_at' => '2024-07-17 14:18:56'),
            array('id' => '14','lavel_name' => '14th','level_number' => '14','lavel_persentage' => '.2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:28:54','updated_at' => '2024-07-17 14:20:15'),
            array('id' => '15','lavel_name' => '15th','level_number' => '15','lavel_persentage' => '.2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:29:12','updated_at' => '2024-07-17 14:21:12'),
            array('id' => '16','lavel_name' => '16th','level_number' => '16','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:29:28','updated_at' => '2024-07-17 14:21:59'),
            array('id' => '17','lavel_name' => '17th','level_number' => '17','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:29:58','updated_at' => '2024-07-17 14:22:45'),
            array('id' => '18','lavel_name' => '18th','level_number' => '18','lavel_persentage' => '.3','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:30:14','updated_at' => '2024-07-17 14:23:13'),
            array('id' => '19','lavel_name' => '19th','level_number' => '19','lavel_persentage' => '.3','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:31:24','updated_at' => '2024-07-17 14:23:46'),
            array('id' => '20','lavel_name' => '20th','level_number' => '20','lavel_persentage' => '.2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:31:43','updated_at' => '2024-07-17 14:24:14'),
            array('id' => '21','lavel_name' => '21st','level_number' => '21','lavel_persentage' => '.2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:32:28','updated_at' => '2024-07-17 14:24:49'),
            array('id' => '22','lavel_name' => '22st','level_number' => '22','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:32:47','updated_at' => '2024-07-17 14:25:22'),
            array('id' => '23','lavel_name' => '23rd','level_number' => '23','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:33:11','updated_at' => '2024-07-17 14:26:56'),
            array('id' => '24','lavel_name' => '24th','level_number' => '24','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:33:53','updated_at' => '2024-07-17 14:27:29'),
            array('id' => '25','lavel_name' => '25th','level_number' => '25','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:34:07','updated_at' => '2024-07-17 14:28:00'),
            array('id' => '26','lavel_name' => '26th','level_number' => '26','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:34:30','updated_at' => '2024-07-17 14:28:33'),
            array('id' => '27','lavel_name' => '27th','level_number' => '27','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:34:50','updated_at' => '2024-07-17 14:29:12'),
            array('id' => '28','lavel_name' => '28th','level_number' => '28','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:35:24','updated_at' => '2024-07-17 14:30:10'),
            array('id' => '29','lavel_name' => '29th','level_number' => '29','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:35:49','updated_at' => '2024-07-17 14:30:34'),
            array('id' => '30','lavel_name' => '30th','level_number' => '30','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:36:06','updated_at' => '2024-07-17 14:31:29'),
            array('id' => '31','lavel_name' => '31st','level_number' => '31','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:36:28','updated_at' => '2024-07-17 14:32:11'),
            array('id' => '32','lavel_name' => '32nd','level_number' => '32','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:36:50','updated_at' => '2024-07-17 14:32:34'),
            array('id' => '33','lavel_name' => '33rd','level_number' => '33','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:37:31','updated_at' => '2024-07-17 14:32:58'),
            array('id' => '34','lavel_name' => '34th','level_number' => '34','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:37:47','updated_at' => '2024-07-17 14:33:20'),
            array('id' => '35','lavel_name' => '35th','level_number' => '35','lavel_persentage' => '.1','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:38:08','updated_at' => '2024-07-17 14:33:42'),
            array('id' => '36','lavel_name' => '36th','level_number' => '36','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:38:36','updated_at' => '2024-07-17 14:34:06'),
            array('id' => '37','lavel_name' => '37th','level_number' => '37','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:38:54','updated_at' => '2024-07-17 14:34:46'),
            array('id' => '38','lavel_name' => '38th','level_number' => '38','lavel_persentage' => '.15','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:39:18','updated_at' => '2024-07-17 14:35:16'),
            array('id' => '39','lavel_name' => '39th','level_number' => '39','lavel_persentage' => '.2','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:39:41','updated_at' => '2024-07-17 14:35:39'),
            array('id' => '40','lavel_name' => '40th','level_number' => '40','lavel_persentage' => '.25','is_visiable' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:39:58','updated_at' => '2024-07-17 14:36:10')
        ];

        foreach ($levels as $level) {
            LevelBonusMaster::create($level);
        }

        $this->command->info('LevelBonusMaster table seeded with 40 levels!');
    }
}