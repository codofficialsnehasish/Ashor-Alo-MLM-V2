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
            ['id' => '1','rank_name' => 'Star','matching_target' => '200000.00','bonus' => '2000','month_validity' => '12','is_visible' => true],
            ['id' => '2','rank_name' => 'Star 1','matching_target' => '500000.00','bonus' => '4000','month_validity' => '12','is_visible' => true],
            ['id' => '3','rank_name' => 'Star 2','matching_target' => '1200000.00','bonus' => '8000','month_validity' => '12','is_visible' => true],
            ['id' => '4','rank_name' => 'Star 3','matching_target' => '3000000.00','bonus' => '15000','month_validity' => '12','is_visible' => true],
            ['id' => '5','rank_name' => 'Star 4','matching_target' => '7500000.00','bonus' => '30000','month_validity' => '12','is_visible' => true],
            ['id' => '6','rank_name' => 'Star 5','matching_target' => '20000000.00','bonus' => '75000','month_validity' => '12','is_visible' => true],
            ['id' => '7','rank_name' => 'Star 6','matching_target' => '50000000.00','bonus' => '200000','month_validity' => '12','is_visible' => true]
        ];

        foreach ($benefits as $benefit) {
            RemunerationBenefitMaster::create($benefit);
        }

        $this->command->info('Remuneration Benefit Master data seeded successfully!');
    }
}