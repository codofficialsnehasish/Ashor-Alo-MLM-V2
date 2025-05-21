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
            ['id' => '1','level_name' => '1st','level_number' => '1','level_percentage' => '2','is_visible' => '1'],
            ['id' => '2','level_name' => '2nd','level_number' => '2','level_percentage' => '1','is_visible' => '1'],
            ['id' => '3','level_name' => '3rd','level_number' => '3','level_percentage' => '.7','is_visible' => '1'],
            ['id' => '4','level_name' => '4th','level_number' => '4','level_percentage' => '.5','is_visible' => '1'],
            ['id' => '5','level_name' => '5th','level_number' => '5','level_percentage' => '.4','is_visible' => '1'],
            ['id' => '6','level_name' => '6th','level_number' => '6','level_percentage' => '0.4','is_visible' => '1'],
            ['id' => '7','level_name' => '7th','level_number' => '7','level_percentage' => '.3','is_visible' => '1'],
            ['id' => '8','level_name' => '8th','level_number' => '8','level_percentage' => '.3','is_visible' => '1'],
            ['id' => '9','level_name' => '9th','level_number' => '9','level_percentage' => '.3','is_visible' => '1'],
            ['id' => '10','level_name' => '10th','level_number' => '10','level_percentage' => '.5','is_visible' => '1'],
            ['id' => '11','level_name' => '11th','level_number' => '11','level_percentage' => '.4','is_visible' => '1'],
            ['id' => '12','level_name' => '12th','level_number' => '12','level_percentage' => '.25','is_visible' => '1'],
            ['id' => '13','level_name' => '13th','level_number' => '13','level_percentage' => '.25','is_visible' => '1'],
            ['id' => '14','level_name' => '14th','level_number' => '14','level_percentage' => '.2','is_visible' => '1'],
            ['id' => '15','level_name' => '15th','level_number' => '15','level_percentage' => '.2','is_visible' => '1'],
            ['id' => '16','level_name' => '16th','level_number' => '16','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '17','level_name' => '17th','level_number' => '17','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '18','level_name' => '18th','level_number' => '18','level_percentage' => '.3','is_visible' => '1'],
            ['id' => '19','level_name' => '19th','level_number' => '19','level_percentage' => '.3','is_visible' => '1'],
            ['id' => '20','level_name' => '20th','level_number' => '20','level_percentage' => '.2','is_visible' => '1'],
            ['id' => '21','level_name' => '21st','level_number' => '21','level_percentage' => '.2','is_visible' => '1'],
            ['id' => '22','level_name' => '22st','level_number' => '22','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '23','level_name' => '23rd','level_number' => '23','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '24','level_name' => '24th','level_number' => '24','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '25','level_name' => '25th','level_number' => '25','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '26','level_name' => '26th','level_number' => '26','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '27','level_name' => '27th','level_number' => '27','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '28','level_name' => '28th','level_number' => '28','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '29','level_name' => '29th','level_number' => '29','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '30','level_name' => '30th','level_number' => '30','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '31','level_name' => '31st','level_number' => '31','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '32','level_name' => '32nd','level_number' => '32','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '33','level_name' => '33rd','level_number' => '33','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '34','level_name' => '34th','level_number' => '34','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '35','level_name' => '35th','level_number' => '35','level_percentage' => '.1','is_visible' => '1'],
            ['id' => '36','level_name' => '36th','level_number' => '36','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '37','level_name' => '37th','level_number' => '37','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '38','level_name' => '38th','level_number' => '38','level_percentage' => '.15','is_visible' => '1'],
            ['id' => '39','level_name' => '39th','level_number' => '39','level_percentage' => '.2','is_visible' => '1'],
            ['id' => '40','level_name' => '40th','level_number' => '40','level_percentage' => '.25','is_visible' => '1']
        ];

        foreach ($levels as $level) {
            LevelBonusMaster::create($level);
        }

        $this->command->info('LevelBonusMaster table seeded with 40 levels!');
    }
}