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
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('is_provide_direct')->default(0)->after('is_visible');
            $table->tinyInteger('is_provide_roi')->default(0)->after('is_provide_direct');
            $table->tinyInteger('is_provide_level')->default(0)->after('is_provide_roi');
            $table->tinyInteger('is_show_on_business')->default(0)->after('is_provide_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['is_provide_direct','is_provide_roi','is_provide_level']);
        });
    }
};
