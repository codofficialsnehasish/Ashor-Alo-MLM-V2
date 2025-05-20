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
        Schema::table('monthly_return_masters', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['product_id']);

            // Then drop the column
            $table->dropColumn('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_return_masters', function (Blueprint $table) {
            // Add back the column
            $table->unsignedBigInteger('product_id')->after('category_id');

            // Re-add the foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
