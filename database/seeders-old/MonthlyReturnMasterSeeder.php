<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonthlyReturnMaster;

class MonthlyReturnMasterSeeder extends Seeder
{

    protected $monthly_returns = [
        array('id' => '3','category' => '5','product' => '9','form_amount' => '2000.00','to_amount' => '99999.00','percentage' => '8','return_persentage' => '200','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:45:39','updated_at' => '2025-01-03 15:54:26'),
        array('id' => '4','category' => '5','product' => '9','form_amount' => '100000.00','to_amount' => '299999.00','percentage' => '10','return_persentage' => '200','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:46:14','updated_at' => '2025-01-03 15:54:52'),
        array('id' => '5','category' => '5','product' => '9','form_amount' => '300000.00','to_amount' => '599999.00','percentage' => '12','return_persentage' => '200','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:46:56','updated_at' => '2025-01-03 15:55:08'),
        array('id' => '6','category' => '5','product' => '9','form_amount' => '600000.00','to_amount' => '10000000.00','percentage' => '14','return_persentage' => '200','visiblity' => '1','is_deleted' => '0','created_at' => '2024-07-05 18:50:13','updated_at' => '2025-01-03 15:55:23'),
        array('id' => '8','category' => '3','product' => '8','form_amount' => '300000.00','to_amount' => '60000000.00','percentage' => '5','return_persentage' => '100','visiblity' => '1','is_deleted' => '0','created_at' => '2024-08-04 15:37:23','updated_at' => '2025-01-03 15:56:09'),
        array('id' => '9','category' => '9','product' => '10','form_amount' => '0.00','to_amount' => '1.00','percentage' => '0','return_persentage' => '0','visiblity' => '0','is_deleted' => '0','created_at' => '2024-08-06 19:33:01','updated_at' => '2025-09-17 22:38:51'),
        array('id' => '10','category' => '5','product' => '9','form_amount' => '500.00','to_amount' => '10000.00','percentage' => '8','return_persentage' => '200','visiblity' => '0','is_deleted' => '0','created_at' => '2024-08-06 19:35:40','updated_at' => '2025-09-17 22:37:56'),
        array('id' => '11','category' => '10','product' => '11','form_amount' => '300.00','to_amount' => '1000000.00','percentage' => '8','return_persentage' => '100','visiblity' => '1','is_deleted' => '0','created_at' => '2024-11-04 19:50:05','updated_at' => '2025-05-07 16:54:02'),
        array('id' => '12','category' => '11','product' => '13','form_amount' => '5000.00','to_amount' => '1000000.00','percentage' => '5','return_persentage' => '100','visiblity' => '0','is_deleted' => '0','created_at' => '2025-02-04 18:23:35','updated_at' => '2025-09-17 22:35:08'),
        array('id' => '13','category' => '5','product' => '15','form_amount' => '100000.00','to_amount' => '5000000.00','percentage' => '0','return_persentage' => '0','visiblity' => '0','is_deleted' => '0','created_at' => '2025-04-18 23:53:53','updated_at' => '2025-04-25 13:05:49'),
        array('id' => '14','category' => '12','product' => '16','form_amount' => '50000.00','to_amount' => '100000.00','percentage' => '15','return_persentage' => '225','visiblity' => '1','is_deleted' => '0','created_at' => '2025-04-29 17:23:26','updated_at' => '2025-05-02 19:00:41')
    ];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        if (empty($this->monthly_returns)) {
            $this->command->error('No Monthly Return Master data provided in the array.');
            return;
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  
        $this->command->info('Starting Monthly Return Master migration from array...');
        $this->command->getOutput()->progressStart(count($this->monthly_returns));

        foreach ($this->monthly_returns as $acc) {
            try {
                \DB::beginTransaction();

                $this->command->info('Processing Monthly Return Master id : '.$acc['id']);

                // Create new User
                $month_return = new MonthlyReturnMaster();
                $month_return->id = $acc['id'];
                $month_return->category_id = $acc['category'];
                $month_return->form_amount = $acc['form_amount'];
                $month_return->to_amount = $acc['to_amount'];
                $month_return->percentage = $acc['percentage'];
                $month_return->return_persentage = $acc['return_persentage'];
                $month_return->is_visible = $acc['visiblity'];
                $month_return->created_at = $acc['created_at'];
                $month_return->updated_at = $acc['updated_at'];
                $month_return->save();

                \DB::commit();
                $this->command->getOutput()->progressAdvance();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->command->error("Failed to migrate Monthly Return Master" . $e->getMessage());  
            }
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->getOutput()->progressFinish();
        $this->command->info('Monthly Return Master migration from array completed.');
    }
}
