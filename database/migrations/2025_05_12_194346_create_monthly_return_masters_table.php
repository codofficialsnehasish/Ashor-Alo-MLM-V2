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
        Schema::create('monthly_return_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('form_amount', 10, 2)->default(0.00);
            $table->decimal('to_amount', 10, 2)->default(0.00);
            $table->integer('percentage')->nullable();
            $table->integer('return_persentage')->default(0);
            $table->tinyInteger('is_visible')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            // Add index for better performance
            // $table->index(['category', 'product']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_return_masters');
    }
};
