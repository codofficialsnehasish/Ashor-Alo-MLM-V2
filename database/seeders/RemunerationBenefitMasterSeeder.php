<?php

namespace Database\Seeders;

use App\Models\RemunerationBenefitMaster;
use Illuminate\Database\Seeder;

class RemunerationBenefitMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $benefits = [
            array('id' => '1','rank' => 'Star','target' => '200000.00','bonus' => '2000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:53:01','updated_at' => '2024-10-03 17:45:14'),
            array('id' => '2','rank' => 'Star 1','target' => '500000.00','bonus' => '4000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:53:38','updated_at' => '2024-10-03 17:45:39'),
            array('id' => '3','rank' => 'Star 2','target' => '1200000.00','bonus' => '8000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:54:16','updated_at' => '2024-10-03 17:46:06'),
            array('id' => '4','rank' => 'Star 3','target' => '3000000.00','bonus' => '15000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:55:10','updated_at' => '2024-10-03 17:46:59'),
            array('id' => '5','rank' => 'Star 4','target' => '7500000.00','bonus' => '30000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:55:59','updated_at' => '2024-10-03 17:48:41'),
            array('id' => '6','rank' => 'Star 5','target' => '20000000.00','bonus' => '75000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:57:04','updated_at' => '2024-10-03 17:49:25'),
            array('id' => '7','rank' => 'Star 6','target' => '50000000.00','bonus' => '200000','month_validity' => '12','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:57:31','updated_at' => '2024-10-03 17:49:57')
        ];

        foreach ($benefits as $benefit) {
            RemunerationBenefitMaster::create($benefit);
        }

        $this->command->info('Remuneration Benefit Master data seeded successfully!');
    }
}