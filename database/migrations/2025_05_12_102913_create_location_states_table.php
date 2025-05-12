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
        Schema::create('location_states', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 200);
            $table->smallInteger('country_id');
            $table->boolean('is_visible')->default(false);
            
            $table->index('country_id', 'idx_country_id');
            
            // If you want to add foreign key constraint:
            // $table->foreign('country_id')->references('id')->on('location_countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_states');
    }
};
