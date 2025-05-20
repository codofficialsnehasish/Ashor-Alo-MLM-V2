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
        Schema::table('users', function (Blueprint $table) {
            // Remove the is_deleted column
            $table->dropColumn('is_deleted');

            // Add the new status column
            $table->tinyInteger('status')->default(1)->after('is_hide');

            // Add soft deletes
            $table->softDeletes(); // Adds a nullable 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback changes
            $table->dropColumn('status');
            $table->dropSoftDeletes();

            // Restore the is_deleted column
            $table->tinyInteger('is_deleted')->default(0)->after('is_hide');
        });
    }
};
