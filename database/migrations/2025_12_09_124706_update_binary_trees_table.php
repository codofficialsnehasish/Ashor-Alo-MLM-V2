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
        Schema::table('binary_trees', function (Blueprint $table) {
            $table->enum('payout_type', ['mid', 'last'])->after('activated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('binary_trees', function (Blueprint $table) {
            $table->dropColumn('payout_type');
        });
    }
};
