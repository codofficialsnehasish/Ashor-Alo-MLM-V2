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
            // Drop existing 'join_by' string column first
            $table->dropColumn('join_by');
        });

        Schema::table('binary_trees', function (Blueprint $table) {
            // Add it back as a foreign key
            $table->unsignedBigInteger('join_by')->nullable()->after('joining_amount');
            $table->foreign('join_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('binary_trees', function (Blueprint $table) {
            // Rollback: drop foreign key and change it back to string
            $table->dropForeign(['join_by']);
            $table->dropColumn('join_by');
        });

        Schema::table('binary_trees', function (Blueprint $table) {
            $table->string('join_by')->nullable()->after('joining_amount');
        });
    }
};
