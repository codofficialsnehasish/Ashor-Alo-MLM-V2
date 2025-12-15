<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\LocationCitie;
use Illuminate\Support\Facades\DB;

class LocationCitieSeeder extends Seeder
{
    protected $dataFiles = [
        'cities_data1.php',
        'cities_data2.php',
        'cities_data3.php',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data if needed
        // DB::table('location_cities')->truncate();

        foreach ($this->dataFiles as $file) {
            $this->command->info("Processing file: {$file}");
            $path = database_path('seeders/data/' . $file);
            
            if (!file_exists($path)) {
                $this->command->error("File not found: {$path}");
                continue;
            }

            $cities = require $path;
            
            // Process in chunks
            foreach (array_chunk($cities, 1000) as $chunk) {
                DB::table('location_cities')->insert($chunk);
                // $this->command->info("Inserted chunk of " . count($chunk) . " cities");
                
                // Free memory
                unset($chunk);
                gc_collect_cycles();
            }
            
            unset($cities);
        }
    }
}
