<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SalaryBonus;

class SalaryBonusSeeder extends Seeder
{
    protected $salary_bonus = [
        array('id' => '1','user_id' => '10','remuneration_benefit_id' => '2','start_date' => '2024-10-04','amount' => '4000.00','month_count' => '13','created_at' => '2024-10-04 20:29:26','updated_at' => '2025-10-16 00:12:06'),
  array('id' => '2','user_id' => '14','remuneration_benefit_id' => '6','start_date' => '2025-09-16','amount' => '75000.00','month_count' => '2','created_at' => '2024-10-04 20:29:26','updated_at' => '2025-10-16 00:15:24'),
  array('id' => '3','user_id' => '15','remuneration_benefit_id' => '2','start_date' => '2024-12-06','amount' => '4000.00','month_count' => '11','created_at' => '2024-12-06 23:55:24','updated_at' => '2025-10-16 00:17:13'),
  array('id' => '4','user_id' => '21','remuneration_benefit_id' => '6','start_date' => '2025-08-17','amount' => '75000.00','month_count' => '3','created_at' => '2024-12-06 23:55:28','updated_at' => '2025-10-16 00:25:47'),
  array('id' => '5','user_id' => '278','remuneration_benefit_id' => '2','start_date' => '2025-01-04','amount' => '4000.00','month_count' => '10','created_at' => '2024-12-06 23:55:37','updated_at' => '2025-10-16 00:46:19'),
  array('id' => '12','user_id' => '35','remuneration_benefit_id' => '5','start_date' => '2025-10-16','amount' => '30000.00','month_count' => '1','created_at' => '2025-01-04 20:11:37','updated_at' => '2025-10-16 00:34:44'),
  array('id' => '13','user_id' => '458','remuneration_benefit_id' => '3','start_date' => '2025-04-05','amount' => '8000.00','month_count' => '7','created_at' => '2025-01-04 20:12:02','updated_at' => '2025-10-16 00:52:38'),
  array('id' => '14','user_id' => '649','remuneration_benefit_id' => '5','start_date' => '2025-10-16','amount' => '30000.00','month_count' => '1','created_at' => '2025-01-04 20:12:06','updated_at' => '2025-10-16 00:54:40'),
  array('id' => '15','user_id' => '9','remuneration_benefit_id' => '1','start_date' => '2025-02-07','amount' => '2000.00','month_count' => '11','created_at' => '2025-02-07 23:55:58','updated_at' => '2025-10-16 00:10:12'),
  array('id' => '16','user_id' => '30','remuneration_benefit_id' => '1','start_date' => '2025-02-07','amount' => '2000.00','month_count' => '9','created_at' => '2025-02-07 23:57:28','updated_at' => '2025-10-16 00:31:09'),
  array('id' => '17','user_id' => '160','remuneration_benefit_id' => '2','start_date' => '2025-06-16','amount' => '4000.00','month_count' => '5','created_at' => '2025-02-07 23:57:47','updated_at' => '2025-10-16 00:41:35'),
  array('id' => '18','user_id' => '185','remuneration_benefit_id' => '4','start_date' => '2025-07-16','amount' => '15000.00','month_count' => '4','created_at' => '2025-02-07 23:57:50','updated_at' => '2025-10-16 00:44:59'),
  array('id' => '19','user_id' => '279','remuneration_benefit_id' => '4','start_date' => '2025-10-16','amount' => '15000.00','month_count' => '1','created_at' => '2025-02-07 23:57:58','updated_at' => '2025-10-16 00:46:42'),
  array('id' => '20','user_id' => '676','remuneration_benefit_id' => '2','start_date' => '2025-05-15','amount' => '4000.00','month_count' => '6','created_at' => '2025-02-07 23:58:16','updated_at' => '2025-10-16 00:54:46'),
  array('id' => '21','user_id' => '371','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '8','created_at' => '2025-03-07 23:58:40','updated_at' => '2025-10-16 00:51:04'),
  array('id' => '22','user_id' => '469','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '8','created_at' => '2025-03-07 23:58:46','updated_at' => '2025-10-16 00:52:49'),
  array('id' => '23','user_id' => '570','remuneration_benefit_id' => '2','start_date' => '2025-04-05','amount' => '4000.00','month_count' => '7','created_at' => '2025-03-07 23:58:51','updated_at' => '2025-10-16 00:53:56'),
  array('id' => '24','user_id' => '684','remuneration_benefit_id' => '2','start_date' => '2025-03-07','amount' => '4000.00','month_count' => '8','created_at' => '2025-03-07 23:58:56','updated_at' => '2025-10-16 00:55:09'),
  array('id' => '26','user_id' => '1721','remuneration_benefit_id' => '1','start_date' => '2025-03-07','amount' => '2000.00','month_count' => '8','created_at' => '2025-03-07 23:59:30','updated_at' => '2025-10-16 01:04:21'),
  array('id' => '33','user_id' => '164','remuneration_benefit_id' => '5','start_date' => '2025-07-16','amount' => '30000.00','month_count' => '4','created_at' => '2025-04-15 23:56:07','updated_at' => '2025-10-16 00:42:50'),
  array('id' => '34','user_id' => '361','remuneration_benefit_id' => '4','start_date' => '2025-09-16','amount' => '15000.00','month_count' => '2','created_at' => '2025-04-15 23:56:48','updated_at' => '2025-10-16 00:50:07'),
  array('id' => '35','user_id' => '374','remuneration_benefit_id' => '2','start_date' => '2025-06-16','amount' => '4000.00','month_count' => '5','created_at' => '2025-04-15 23:56:51','updated_at' => '2025-10-16 00:51:20'),
  array('id' => '36','user_id' => '477','remuneration_benefit_id' => '3','start_date' => '2025-05-15','amount' => '8000.00','month_count' => '6','created_at' => '2025-04-15 23:57:06','updated_at' => '2025-10-16 00:53:12'),
  array('id' => '37','user_id' => '583','remuneration_benefit_id' => '3','start_date' => '2025-05-15','amount' => '8000.00','month_count' => '6','created_at' => '2025-04-15 23:57:16','updated_at' => '2025-10-16 00:54:20'),
  array('id' => '38','user_id' => '596','remuneration_benefit_id' => '2','start_date' => '2025-04-15','amount' => '4000.00','month_count' => '7','created_at' => '2025-04-15 23:57:16','updated_at' => '2025-10-16 00:54:23'),
  array('id' => '39','user_id' => '773','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-04-15 23:57:36','updated_at' => '2025-10-16 00:56:54'),
  array('id' => '40','user_id' => '1984','remuneration_benefit_id' => '1','start_date' => '2025-04-15','amount' => '2000.00','month_count' => '7','created_at' => '2025-04-15 23:59:11','updated_at' => '2025-10-16 01:11:26'),
  array('id' => '41','user_id' => '285','remuneration_benefit_id' => '2','start_date' => '2025-07-01','amount' => '4000.00','month_count' => '4','created_at' => '2025-05-15 23:58:19','updated_at' => '2025-10-16 00:47:05'),
  array('id' => '42','user_id' => '677','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-05-15 23:59:17','updated_at' => '2025-10-16 00:54:47'),
  array('id' => '43','user_id' => '776','remuneration_benefit_id' => '4','start_date' => '2025-07-01','amount' => '15000.00','month_count' => '4','created_at' => '2025-05-15 23:59:40','updated_at' => '2025-10-16 00:57:19'),
  array('id' => '44','user_id' => '897','remuneration_benefit_id' => '2','start_date' => '2025-07-01','amount' => '4000.00','month_count' => '4','created_at' => '2025-05-15 23:59:56','updated_at' => '2025-10-16 00:58:42'),
  array('id' => '45','user_id' => '1223','remuneration_benefit_id' => '1','start_date' => '2025-05-16','amount' => '2000.00','month_count' => '6','created_at' => '2025-05-16 00:00:16','updated_at' => '2025-10-16 01:00:44'),
  array('id' => '46','user_id' => '1768','remuneration_benefit_id' => '4','start_date' => '2025-08-16','amount' => '15000.00','month_count' => '3','created_at' => '2025-05-16 00:01:00','updated_at' => '2025-10-16 01:07:41'),
  array('id' => '47','user_id' => '38','remuneration_benefit_id' => '1','start_date' => '2025-06-16','amount' => '2000.00','month_count' => '5','created_at' => '2025-06-16 00:01:29','updated_at' => '2025-10-16 00:36:26'),
  array('id' => '48','user_id' => '328','remuneration_benefit_id' => '1','start_date' => '2025-06-16','amount' => '2000.00','month_count' => '5','created_at' => '2025-06-16 00:03:57','updated_at' => '2025-10-16 00:47:17'),
  array('id' => '49','user_id' => '678','remuneration_benefit_id' => '1','start_date' => '2025-06-16','amount' => '2000.00','month_count' => '5','created_at' => '2025-06-16 00:05:31','updated_at' => '2025-10-16 00:54:47'),
  array('id' => '50','user_id' => '960','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-06-16 00:06:43','updated_at' => '2025-10-16 00:59:31'),
  array('id' => '51','user_id' => '1048','remuneration_benefit_id' => '1','start_date' => '2025-06-16','amount' => '2000.00','month_count' => '5','created_at' => '2025-06-16 00:06:52','updated_at' => '2025-10-16 01:00:00'),
  array('id' => '52','user_id' => '1315','remuneration_benefit_id' => '2','start_date' => '2025-06-16','amount' => '4000.00','month_count' => '5','created_at' => '2025-06-16 00:07:15','updated_at' => '2025-10-16 01:01:38'),
  array('id' => '53','user_id' => '2010','remuneration_benefit_id' => '2','start_date' => '2025-06-16','amount' => '4000.00','month_count' => '5','created_at' => '2025-06-16 00:08:37','updated_at' => '2025-10-16 01:12:00'),
  array('id' => '103','user_id' => '7','remuneration_benefit_id' => '5','start_date' => '2025-07-16','amount' => '30000.00','month_count' => '4','created_at' => '2025-07-16 20:28:49','updated_at' => '2025-10-16 00:05:30'),
  array('id' => '104','user_id' => '286','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:46:42','updated_at' => '2025-10-16 00:47:08'),
  array('id' => '105','user_id' => '698','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:49:28','updated_at' => '2025-10-16 00:55:37'),
  array('id' => '106','user_id' => '775','remuneration_benefit_id' => '5','start_date' => '2025-10-16','amount' => '30000.00','month_count' => '1','created_at' => '2025-07-16 20:50:01','updated_at' => '2025-10-16 00:57:17'),
  array('id' => '107','user_id' => '844','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:50:19','updated_at' => '2025-10-16 00:57:56'),
  array('id' => '108','user_id' => '846','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:50:23','updated_at' => '2025-10-16 00:58:09'),
  array('id' => '109','user_id' => '892','remuneration_benefit_id' => '3','start_date' => '2025-07-16','amount' => '8000.00','month_count' => '4','created_at' => '2025-07-16 20:50:26','updated_at' => '2025-10-16 00:58:17'),
  array('id' => '110','user_id' => '1468','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:51:45','updated_at' => '2025-10-16 01:02:23'),
  array('id' => '111','user_id' => '1557','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:51:57','updated_at' => '2025-10-16 01:03:25'),
  array('id' => '112','user_id' => '1613','remuneration_benefit_id' => '3','start_date' => '2025-07-16','amount' => '8000.00','month_count' => '4','created_at' => '2025-07-16 20:52:04','updated_at' => '2025-10-16 01:03:49'),
  array('id' => '113','user_id' => '1663','remuneration_benefit_id' => '4','start_date' => '2025-09-16','amount' => '15000.00','month_count' => '2','created_at' => '2025-07-16 20:52:10','updated_at' => '2025-10-16 01:04:05'),
  array('id' => '114','user_id' => '1715','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:52:15','updated_at' => '2025-10-16 01:04:20'),
  array('id' => '115','user_id' => '1752','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:52:16','updated_at' => '2025-10-16 01:04:24'),
  array('id' => '116','user_id' => '1766','remuneration_benefit_id' => '4','start_date' => '2025-08-16','amount' => '15000.00','month_count' => '3','created_at' => '2025-07-16 20:53:08','updated_at' => '2025-10-16 01:07:13'),
  array('id' => '117','user_id' => '1797','remuneration_benefit_id' => '3','start_date' => '2025-08-16','amount' => '8000.00','month_count' => '3','created_at' => '2025-07-16 20:53:20','updated_at' => '2025-10-16 01:07:53'),
  array('id' => '118','user_id' => '1954','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:53:43','updated_at' => '2025-10-16 01:10:45'),
  array('id' => '119','user_id' => '2007','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:53:56','updated_at' => '2025-10-16 01:11:47'),
  array('id' => '120','user_id' => '2009','remuneration_benefit_id' => '3','start_date' => '2025-08-16','amount' => '8000.00','month_count' => '3','created_at' => '2025-07-16 20:53:59','updated_at' => '2025-10-16 01:11:58'),
  array('id' => '121','user_id' => '2189','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-07-16 20:54:08','updated_at' => '2025-10-16 01:12:35'),
  array('id' => '122','user_id' => '2200','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-07-16 20:54:09','updated_at' => '2025-10-16 01:12:38'),
  array('id' => '123','user_id' => '2372','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-07-16 20:54:24','updated_at' => '2025-08-16 00:45:46'),
  array('id' => '124','user_id' => '3023','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:54:47','updated_at' => '2025-10-16 01:15:44'),
  array('id' => '125','user_id' => '3101','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:54:50','updated_at' => '2025-10-16 01:16:00'),
  array('id' => '126','user_id' => '3103','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:54:50','updated_at' => '2025-10-16 01:16:01'),
  array('id' => '127','user_id' => '3130','remuneration_benefit_id' => '3','start_date' => '2025-09-16','amount' => '8000.00','month_count' => '2','created_at' => '2025-07-16 20:54:51','updated_at' => '2025-10-16 01:16:04'),
  array('id' => '128','user_id' => '3188','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:54:54','updated_at' => '2025-10-16 01:16:19'),
  array('id' => '129','user_id' => '3319','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-07-16 20:54:57','updated_at' => '2025-10-16 01:16:32'),
  array('id' => '130','user_id' => '3369','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-07-16 20:55:02','updated_at' => '2025-10-16 01:16:46'),
  array('id' => '131','user_id' => '3393','remuneration_benefit_id' => '3','start_date' => '2025-09-16','amount' => '8000.00','month_count' => '2','created_at' => '2025-07-16 20:55:05','updated_at' => '2025-10-16 01:17:07'),
  array('id' => '132','user_id' => '3442','remuneration_benefit_id' => '2','start_date' => '2025-07-16','amount' => '4000.00','month_count' => '4','created_at' => '2025-07-16 20:55:17','updated_at' => '2025-10-16 01:20:23'),
  array('id' => '133','user_id' => '4333','remuneration_benefit_id' => '1','start_date' => '2025-07-16','amount' => '2000.00','month_count' => '4','created_at' => '2025-07-16 20:55:50','updated_at' => '2025-10-16 01:23:30'),
  array('id' => '134','user_id' => '37','remuneration_benefit_id' => '4','start_date' => '2025-10-16','amount' => '15000.00','month_count' => '1','created_at' => '2025-08-16 00:15:32','updated_at' => '2025-10-16 00:35:14'),
  array('id' => '135','user_id' => '421','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-08-16 00:31:41','updated_at' => '2025-10-16 00:51:34'),
  array('id' => '136','user_id' => '462','remuneration_benefit_id' => '3','start_date' => '2025-08-16','amount' => '8000.00','month_count' => '3','created_at' => '2025-08-16 00:32:46','updated_at' => '2025-10-16 00:52:42'),
  array('id' => '137','user_id' => '499','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-08-16 00:33:23','updated_at' => '2025-10-16 00:53:23'),
  array('id' => '138','user_id' => '774','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-08-16 00:36:05','updated_at' => '2025-10-16 00:57:08'),
  array('id' => '139','user_id' => '843','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:36:41','updated_at' => '2025-10-16 00:57:51'),
  array('id' => '140','user_id' => '1209','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-08-16 00:38:15','updated_at' => '2025-10-16 01:00:40'),
  array('id' => '141','user_id' => '1812','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:42:34','updated_at' => '2025-10-16 01:08:01'),
  array('id' => '142','user_id' => '1862','remuneration_benefit_id' => '3','start_date' => '2025-09-16','amount' => '8000.00','month_count' => '2','created_at' => '2025-08-16 00:43:11','updated_at' => '2025-10-16 01:09:02'),
  array('id' => '143','user_id' => '1888','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:43:24','updated_at' => '2025-10-16 01:09:56'),
  array('id' => '144','user_id' => '2229','remuneration_benefit_id' => '3','start_date' => '2025-09-16','amount' => '8000.00','month_count' => '2','created_at' => '2025-08-16 00:45:09','updated_at' => '2025-10-16 01:13:11'),
  array('id' => '145','user_id' => '3187','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-08-16 00:46:57','updated_at' => '2025-10-16 01:16:19'),
  array('id' => '146','user_id' => '3401','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-08-16 00:47:22','updated_at' => '2025-10-16 01:17:11'),
  array('id' => '147','user_id' => '3726','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-08-16 00:49:23','updated_at' => '2025-10-16 01:21:52'),
  array('id' => '148','user_id' => '3751','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:49:45','updated_at' => '2025-10-16 01:22:19'),
  array('id' => '149','user_id' => '3935','remuneration_benefit_id' => '2','start_date' => '2025-08-16','amount' => '4000.00','month_count' => '3','created_at' => '2025-08-16 00:49:59','updated_at' => '2025-10-16 01:22:43'),
  array('id' => '150','user_id' => '3940','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:49:59','updated_at' => '2025-10-16 01:22:43'),
  array('id' => '151','user_id' => '4032','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:50:21','updated_at' => '2025-10-16 01:23:05'),
  array('id' => '152','user_id' => '4488','remuneration_benefit_id' => '1','start_date' => '2025-08-16','amount' => '2000.00','month_count' => '3','created_at' => '2025-08-16 00:50:50','updated_at' => '2025-10-16 01:23:37'),
  array('id' => '153','user_id' => '433','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:01:22','updated_at' => '2025-10-16 00:51:42'),
  array('id' => '154','user_id' => '1007','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-09-16 01:08:48','updated_at' => '2025-10-16 00:59:51'),
  array('id' => '155','user_id' => '1236','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:09:44','updated_at' => '2025-10-16 01:01:07'),
  array('id' => '156','user_id' => '1494','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:10:28','updated_at' => '2025-10-16 01:02:27'),
  array('id' => '157','user_id' => '1706','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:11:47','updated_at' => '2025-10-16 01:04:13'),
  array('id' => '158','user_id' => '1949','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-09-16 01:16:10','updated_at' => '2025-10-16 01:10:24'),
  array('id' => '159','user_id' => '2206','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:17:44','updated_at' => '2025-10-16 01:12:54'),
  array('id' => '160','user_id' => '2258','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:17:59','updated_at' => '2025-10-16 01:13:22'),
  array('id' => '161','user_id' => '2391','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:18:42','updated_at' => '2025-10-16 01:14:18'),
  array('id' => '162','user_id' => '2605','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:19:04','updated_at' => '2025-10-16 01:14:54'),
  array('id' => '163','user_id' => '3083','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:19:43','updated_at' => '2025-10-16 01:15:56'),
  array('id' => '164','user_id' => '3137','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:19:50','updated_at' => '2025-10-16 01:16:05'),
  array('id' => '165','user_id' => '3173','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:19:58','updated_at' => '2025-10-16 01:16:14'),
  array('id' => '166','user_id' => '3197','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:20:02','updated_at' => '2025-10-16 01:16:20'),
  array('id' => '167','user_id' => '3198','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:20:02','updated_at' => '2025-10-16 01:16:21'),
  array('id' => '168','user_id' => '3323','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:20:11','updated_at' => '2025-10-16 01:16:37'),
  array('id' => '169','user_id' => '3435','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:23:04','updated_at' => '2025-10-16 01:20:19'),
  array('id' => '170','user_id' => '3441','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-09-16 01:23:09','updated_at' => '2025-10-16 01:20:23'),
  array('id' => '171','user_id' => '3472','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:23:22','updated_at' => '2025-10-16 01:20:40'),
  array('id' => '172','user_id' => '3473','remuneration_benefit_id' => '3','start_date' => '2025-09-16','amount' => '8000.00','month_count' => '2','created_at' => '2025-09-16 01:23:26','updated_at' => '2025-10-16 01:20:46'),
  array('id' => '173','user_id' => '3546','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:23:39','updated_at' => '2025-10-16 01:21:02'),
  array('id' => '174','user_id' => '3828','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:24:54','updated_at' => '2025-10-16 01:22:33'),
  array('id' => '175','user_id' => '3892','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:24:58','updated_at' => '2025-10-16 01:22:37'),
  array('id' => '176','user_id' => '4349','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:25:52','updated_at' => '2025-10-16 01:23:30'),
  array('id' => '177','user_id' => '4487','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:26:01','updated_at' => '2025-10-16 01:23:36'),
  array('id' => '178','user_id' => '4608','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:26:19','updated_at' => '2025-10-16 01:23:55'),
  array('id' => '179','user_id' => '6804','remuneration_benefit_id' => '2','start_date' => '2025-09-16','amount' => '4000.00','month_count' => '2','created_at' => '2025-09-16 01:27:29','updated_at' => '2025-10-16 01:25:37'),
  array('id' => '180','user_id' => '6853','remuneration_benefit_id' => '1','start_date' => '2025-09-16','amount' => '2000.00','month_count' => '2','created_at' => '2025-09-16 01:27:31','updated_at' => '2025-10-16 01:25:40'),
  array('id' => '181','user_id' => '491','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 00:53:17','updated_at' => '2025-10-16 00:53:17'),
  array('id' => '182','user_id' => '501','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 00:53:24','updated_at' => '2025-10-16 00:53:24'),
  array('id' => '183','user_id' => '538','remuneration_benefit_id' => '3','start_date' => '2025-10-16','amount' => '8000.00','month_count' => '1','created_at' => '2025-10-16 00:53:37','updated_at' => '2025-10-16 00:53:37'),
  array('id' => '184','user_id' => '1000','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 00:59:47','updated_at' => '2025-10-16 00:59:47'),
  array('id' => '185','user_id' => '2018','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-10-16 01:12:13','updated_at' => '2025-10-16 01:12:13'),
  array('id' => '186','user_id' => '2627','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 01:15:12','updated_at' => '2025-10-16 01:15:12'),
  array('id' => '187','user_id' => '2672','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-10-16 01:15:19','updated_at' => '2025-10-16 01:15:19'),
  array('id' => '188','user_id' => '3080','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-10-16 01:15:51','updated_at' => '2025-10-16 01:15:51'),
  array('id' => '189','user_id' => '3406','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-10-16 01:17:16','updated_at' => '2025-10-16 01:17:16'),
  array('id' => '190','user_id' => '3501','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 01:20:57','updated_at' => '2025-10-16 01:20:57'),
  array('id' => '191','user_id' => '4679','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 01:24:01','updated_at' => '2025-10-16 01:24:01'),
  array('id' => '192','user_id' => '5183','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 01:24:24','updated_at' => '2025-10-16 01:24:24'),
  array('id' => '193','user_id' => '6208','remuneration_benefit_id' => '2','start_date' => '2025-10-16','amount' => '4000.00','month_count' => '1','created_at' => '2025-10-16 01:25:07','updated_at' => '2025-10-16 01:25:07'),
  array('id' => '194','user_id' => '7338','remuneration_benefit_id' => '1','start_date' => '2025-10-16','amount' => '2000.00','month_count' => '1','created_at' => '2025-10-16 01:25:50','updated_at' => '2025-10-16 01:25:50')
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
