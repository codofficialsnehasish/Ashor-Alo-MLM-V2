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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('sku')->nullable()->unique();

            // Category relationship (main category or subcategory using parent_id logic)
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');

            // Pricing
            $table->decimal('price', 12, 2)->default(0.00);
            $table->integer('discount_rate')->nullable(); // in percentage
            $table->boolean('no_discount')->default(false); // if true, ignore discount
            $table->decimal('discounted_price', 12, 2)->nullable();
            
            // Tax
            $table->integer('gst_rate')->nullable(); // in percentage
            $table->decimal('gst_amount', 12, 2)->nullable();

            $table->decimal('total_price',12,2)->default(0.00);

            // Stock and status
            $table->integer('stock')->default(0); // Inventory count
            $table->tinyInteger('is_visible')->default(1); // 1=visible, 0=hidden
            $table->tinyInteger('is_bestseller')->default(0);

            // Descriptions
            $table->text('short_desc')->nullable();
            $table->longText('description')->nullable();

            // SEO (optional but useful)
            $table->string('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();

            $table->tinyInteger('is_provide_direct')->default(0);
            $table->tinyInteger('is_provide_roi')->default(0);
            $table->tinyInteger('is_provide_level')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
