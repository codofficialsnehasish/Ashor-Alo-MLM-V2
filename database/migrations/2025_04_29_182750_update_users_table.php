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
            $table->string('email')->nullable()->unique(false)->change();
            
            // Add new columns
            $table->string('phone')->unique()->after('email_verified_at');
            $table->string('decoded_password')->after('password');
            $table->tinyInteger('is_block')->default(0)->after('remember_token');
            $table->tinyInteger('is_hide')->default(0)->after('is_block');
            $table->tinyInteger('is_deleted')->default(0)->after('is_hide');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert email changes
            $table->string('email')->nullable(false)->unique()->change();
            
            // Remove added columns
            $table->dropColumn(['phone', 'decoded_password', 'is_block', 'is_hide', 'is_deleted']);
        });
    }
};
