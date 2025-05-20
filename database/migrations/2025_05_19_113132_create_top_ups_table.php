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
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            // User and order references
            $table->string('entry_by', 255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('add_on_against_order_id')->nullable();
            
            // Business type flags
            $table->boolean('is_provide_direct')->default(true);
            $table->boolean('is_provide_roi')->default(false);
            $table->boolean('is_provide_level')->default(false);
            
            // Date fields
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Amount fields
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('total_paying_amount', 10, 2)->default(0.00);
            $table->decimal('installment_amount_per_month', 10, 2)->default(0.00);
            $table->decimal('installment_amount_per_day', 10, 2)->default(0.00);
            $table->decimal('total_disbursed_amount', 10, 2)->default(0.00);
            
            // Percentage fields
            $table->unsignedInteger('percentage')->default(0);
            $table->unsignedInteger('return_percentage')->default(0);
            
            // Installment fields
            $table->unsignedInteger('total_installment_month')->default(0);
            $table->unsignedInteger('total_installment_days')->default(0)->comment('Calculated as total_installment_month * 30');
            $table->unsignedInteger('month_count')->default(0);
            $table->unsignedInteger('days_count')->default(0);
            
            // Completion flag
            $table->boolean('is_completed')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('add_on_against_order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_ups');
    }
};
