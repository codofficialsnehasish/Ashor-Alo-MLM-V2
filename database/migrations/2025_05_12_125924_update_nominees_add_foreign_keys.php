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
        Schema::table('nominees', function (Blueprint $table) {
            // Modify column types if needed and make nullable for SET NULL
            $table->mediumInteger('nominee_state_id')->unsigned()->nullable()->change();
            $table->mediumInteger('nominee_city_id')->unsigned()->nullable()->change();

            // Add foreign key constraints
            $table->foreign('nominee_state_id')
                ->references('id')
                ->on('location_states')
                ->onDelete('set null');

            $table->foreign('nominee_city_id')
                ->references('id')
                ->on('location_cities')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominees', function (Blueprint $table) {
            $table->dropForeign(['nominee_state_id']);
            $table->dropForeign(['nominee_city_id']);
        });
    }
};
