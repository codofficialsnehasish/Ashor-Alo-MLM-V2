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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Variation attributes (e.g., size/color)
            $table->string('attribute'); // "weight", "volume", "color"
            $table->string('value');     // "500gm", "1kg", "Red"
            
            // Override base product pricing if needed
            $table->decimal('price_override', 12, 2)->nullable();
            $table->integer('stock')->default(0);
            
            // Unique SKU for variation (e.g., "FIGHTER-DET-500GM")
            $table->string('sku')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
