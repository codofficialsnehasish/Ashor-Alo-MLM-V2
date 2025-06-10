<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SalaryBonus;

class SalaryBonusSeeder extends Seeder
{
    protected $salary_bonus = [
        ['id' => '1','user_id' => '10','remuneration_benefit_id' => '2','start_date' => '2024-10-04','amount' => '4000.00','month_count' => '8','created_at' => '2024-10-04 20:29:26','updated_at' => '2025-05-15 23:54:55'],
        ['id' => '2','user_id' => '14','remuneration_benefit_id' => '5','start_date' => '2025-05-15','amount' => '30000.00','month_count' => '1','created_at' => '2024-10-04 20:29:26','updated_at' => '2025-05-15 23:54:19'],
        ['id' => '3','user_id' => '15','remuneration_benefit_id' => '2','start_date' => '2024-12-06','amount' => '4000.00','month_count' => '6','created_at' => '2024-12-06 23:55:24','updated_at' => '2025-05-15 23:54:31'],
        ['id' => '4','user_id' => '21','remuneration_benefit_id' => '5','start_date' => '2025-05-15','amount' => '30000.00','month_count' => '1','created_at' => '2024-12-06 23:55:28','updated_at' => '2025-05-15 23:55:42'],
        ['id' => '5','user_id' => '278','remuneration_benefit_id' => '2','start_date' => '2025-01-04','amount' => '4000.00','month_count' => '5','created_at' => '2024-12-06 23:55:37','updated_at' => '2025-05-15 23:58:11'],
        ['id' => '12','user_id' => '35','remuneration_benefit_id' => '4','start_date' => '2025-04-04','amount' => '15000.00','month_count' => '2','created_at' => '2025-01-04 20:11:37','updated_at' => '2025-05-15 23:56:32'],
        ['id' => '13','user_id' => '458','remuneration_benefit_id' => '3','start_date' => '2025-04-05','amount' => '8000.00','month_count' => '2','created_at' => '2025-01-04 20:12:02','updated_at' => '2025-05-15 23:58:53'],
        ['id' => '14','user_id' => '649','remuneration_benefit_id' => '2','start_date' => '2025-01-04','amount' => '4000.00','month_count' => '5','created_at' => '2025-01-04 20:12:06','updated_at' => '2025-05-15 23:59:14'],
        ['id' => '15','user_id' => '9','remuneration_benefit_id' => '1','start_date' => '2025-02-07','amount' => '2000.00','month_count' => '4','created_at' => '2025-02-07 23:55:58','updated_at' => '2025-05-15 23:53:30'],
        ['id' => '16','user_id' => '30','remuneration_benefit_id' => '1','start_date' => '2025-02-07','amount' => '2000.00','month_count' => '4','created_at' => '2025-02-07 23:57:28','updated_at' => '2025-05-15 23:56:10'],
        ['id' => '17','user_id' => '160','remuneration_benefit_id' => '1','start_date' => '2025-02-07','amount' => '2000.00','month_count' => '4','created_at' => '2025-02-07 23:57:47','updated_at' => '2025-05-15 23:57:34'],
        ['id' => '18','user_id' => '185','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '3','created_at' => '2025-02-07 23:57:50','updated_at' => '2025-05-15 23:57:47'],
        ['id' => '19','user_id' => '279','remuneration_benefit_id' => '2','start_date' => '2025-05-15','amount' => '4000.00','month_count' => '1','created_at' => '2025-02-07 23:57:58','updated_at' => '2025-05-15 23:58:14'],
        ['id' => '20','user_id' => '676','remuneration_benefit_id' => '2','start_date' => '2025-05-15','amount' => '4000.00','month_count' => '1','created_at' => '2025-02-07 23:58:16','updated_at' => '2025-05-15 23:59:16'],
        ['id' => '21','user_id' => '371','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '3','created_at' => '2025-03-07 23:58:40','updated_at' => '2025-05-15 23:58:36'],
        ['id' => '22','user_id' => '469','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '3','created_at' => '2025-03-07 23:58:46','updated_at' => '2025-05-15 23:58:55'],
        ['id' => '23','user_id' => '570','remuneration_benefit_id' => '2','start_date' => '2025-04-05','amount' => '4000.00','month_count' => '2','created_at' => '2025-03-07 23:58:51','updated_at' => '2025-05-15 23:59:09'],
        ['id' => '24','user_id' => '684','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '3','created_at' => '2025-03-07 23:58:56','updated_at' => '2025-05-15 23:59:20'],
        ['id' => '25','user_id' => '775','remuneration_benefit_id' => '3','start_date' => '2025-03-07','amount' => '8000.00','month_count' => '3','created_at' => '2025-03-07 23:59:05','updated_at' => '2025-05-15 23:59:40'],
        ['id' => '26','user_id' => '1721','remuneration_benefit_id' => '1','start_date' => '2025-03-07','amount' => '2000.00','month_count' => '3','created_at' => '2025-03-07 23:59:30','updated_at' => '2025-05-16 00:00:43'],
        ['id' => '33','user_id' => '164','remuneration_benefit_id' => '4','start_date' => '2025-05-15','amount' => '15000.00','month_count' => '1','created_at' => '2025-04-15 23:56:07','updated_at' => '2025-05-15 23:57:42'],
        ['id' => '34','user_id' => '361','remuneration_benefit_id' => '1','start_date' => '2025-04-15','amount' => '2000.00','month_count' => '2','created_at' => '2025-04-15 23:56:48','updated_at' => '2025-05-15 23:58:33'],
        ['id' => '35','user_id' => '374','remuneration_benefit_id' => '1','start_date' => '2025-04-15','amount' => '2000.00','month_count' => '2','created_at' => '2025-04-15 23:56:51','updated_at' => '2025-05-15 23:58:38'],
        ['id' => '36','user_id' => '477','remuneration_benefit_id' => '3','start_date' => '2025-05-15','amount' => '8000.00','month_count' => '1','created_at' => '2025-04-15 23:57:06','updated_at' => '2025-05-15 23:58:59'],
        ['id' => '37','user_id' => '583','remuneration_benefit_id' => '3','start_date' => '2025-05-15','amount' => '8000.00','month_count' => '1','created_at' => '2025-04-15 23:57:16','updated_at' => '2025-05-15 23:59:11'],
        ['id' => '38','user_id' => '596','remuneration_benefit_id' => '2','start_date' => '2025-04-15','amount' => '4000.00','month_count' => '2','created_at' => '2025-04-15 23:57:16','updated_at' => '2025-05-15 23:59:12'],
        ['id' => '39','user_id' => '773','remuneration_benefit_id' => '1','start_date' => '2025-04-15','amount' => '2000.00','month_count' => '2','created_at' => '2025-04-15 23:57:36','updated_at' => '2025-05-15 23:59:37'],
        ['id' => '40','user_id' => '1984','remuneration_benefit_id' => '1','start_date' => '2025-04-15','amount' => '2000.00','month_count' => '2','created_at' => '2025-04-15 23:59:11','updated_at' => '2025-05-16 00:01:08'],
        ['id' => '41','user_id' => '285','remuneration_benefit_id' => '1','start_date' => '2025-05-15','amount' => '2000.00','month_count' => '1','created_at' => '2025-05-15 23:58:19','updated_at' => '2025-05-15 23:58:19'],
        ['id' => '42','user_id' => '677','remuneration_benefit_id' => '1','start_date' => '2025-05-15','amount' => '2000.00','month_count' => '1','created_at' => '2025-05-15 23:59:17','updated_at' => '2025-05-15 23:59:17'],
        ['id' => '43','user_id' => '776','remuneration_benefit_id' => '3','start_date' => '2025-05-15','amount' => '8000.00','month_count' => '1','created_at' => '2025-05-15 23:59:40','updated_at' => '2025-05-15 23:59:40'],
        ['id' => '44','user_id' => '897','remuneration_benefit_id' => '1','start_date' => '2025-05-15','amount' => '2000.00','month_count' => '1','created_at' => '2025-05-15 23:59:56','updated_at' => '2025-05-15 23:59:56'],
        ['id' => '45','user_id' => '1223','remuneration_benefit_id' => '1','start_date' => '2025-05-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-05-16 00:00:16','updated_at' => '2025-05-16 00:00:16'],
        ['id' => '46','user_id' => '1768','remuneration_benefit_id' => '2','start_date' => '2025-05-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-05-16 00:01:00','updated_at' => '2025-05-16 00:01:00']
    ];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        if (empty($this->salary_bonus)) {
            $this->command->error('No Salary Bonus data provided in the array.');
            return;
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  
        $this->command->info('Starting Salary Bonus migration from array...');
        $this->command->getOutput()->progressStart(count($this->salary_bonus));

        foreach ($this->salary_bonus as $acc) {
            try {
                \DB::beginTransaction();

                $this->command->info('Processing Salary Bonus id : '.$acc['id']);

                // Create new User
                $salary_bonus = new SalaryBonus();
                $salary_bonus->id = $acc['id'];
                $salary_bonus->user_id = $acc['user_id'];
                $salary_bonus->remuneration_benefit_id = $acc['remuneration_benefit_id'];
                $salary_bonus->start_date = $acc['start_date'];
                $salary_bonus->amount = $acc['amount'];
                $salary_bonus->month_count = $acc['month_count'];
                $salary_bonus->created_at = $acc['created_at'];
                $salary_bonus->updated_at = $acc['updated_at'];
                $salary_bonus->save();

                \DB::commit();
                $this->command->getOutput()->progressAdvance();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->command->error("Failed to migrate Salary Bonus" . $e->getMessage());  
            }
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->getOutput()->progressFinish();
        $this->command->info('Salary Bonus migration from array completed.');
    }
}
