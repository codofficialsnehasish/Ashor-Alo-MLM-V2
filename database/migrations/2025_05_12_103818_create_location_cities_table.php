<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('location_cities', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 200);
            $table->smallInteger('country_id');
            $table->mediumInteger('state_id');
            $table->tinyInteger('is_visible')->default(1);
            
            // Add indexes for better performance
            $table->index('country_id', 'idx_country_id');
            $table->index('state_id', 'idx_state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_cities');
    }
};
