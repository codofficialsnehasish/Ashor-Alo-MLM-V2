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
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedSmallInteger('country_id')->nullable()->after('country');
            $table->unsignedMediumInteger('state_id')->nullable()->after('state');
            $table->unsignedMediumInteger('city_id')->nullable()->after('city');

            $table->foreign('country_id')
                ->references('id')
                ->on('location_countries')
                ->onDelete('set null');

            $table->foreign('state_id')
                ->references('id')
                ->on('location_states')
                ->onDelete('set null');

            $table->foreign('city_id')
                ->references('id')
                ->on('location_cities')
                ->onDelete('set null');
        });


        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['country', 'state', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Recreate the string columns
            $table->string('country')->after('country_id');
            $table->string('state')->after('state_id');
            $table->string('city')->after('city_id');
            
            // Drop the foreign keys first
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            
            // Then drop the ID columns
            $table->dropColumn(['country_id', 'state_id', 'city_id']);
        });
    }
};
