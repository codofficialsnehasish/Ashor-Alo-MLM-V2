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
        Schema::create('advance_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advance_id');
            $table->unsignedBigInteger('payout_id');
            $table->decimal('deducted_amount', 10, 2);
            $table->timestamps();

            $table->foreign('advance_id')->references('id')->on('advances')->onDelete('cascade');
            $table->foreign('payout_id')->references('id')->on('payouts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_deductions');
    }
};
