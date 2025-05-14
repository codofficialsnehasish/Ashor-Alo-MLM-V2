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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('price_subtotal', 10, 2)->nullable();
            $table->decimal('price_gst', 10, 2)->nullable();
            $table->decimal('price_shipping', 10, 2)->nullable();
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->decimal('price_total', 10, 2)->nullable();
            $table->enum('payment_method', ['Online', 'Cash'])->default('Cash');
            $table->string('transaction_id')->unique()->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['Paid', 'Awaiting Payment', 'Under Checking'])->default('Awaiting Payment');
            $table->tinyInteger('status')->default(0);
            $table->enum('order_status', ['Order Placed', 'Order Procesing', 'Order Shipped', 'Order Completed'])->default('Order Placed');
            $table->timestamp('delivered_date')->nullable();
            $table->string('placed_by')->nullable();
            $table->string('delivered_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
