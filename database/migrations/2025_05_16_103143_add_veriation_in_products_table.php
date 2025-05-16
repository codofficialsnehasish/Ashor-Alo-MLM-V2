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
        Schema::table('products', function (Blueprint $table) {
            // Flag for product type
            $table->enum('product_type', ['simple', 'variable', 'combo'])->default('simple')->after('category_id');
            
            // For variable products (parent)
            $table->boolean('manages_variations')->default(false)->after('product_type');

            // For combo products
            $table->decimal('combo_price', 12, 2)->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_type','manages_variations']);
        });
    }
};
