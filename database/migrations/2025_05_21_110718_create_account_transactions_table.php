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
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('which_for')->nullable();
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('generated_against_user_id')->nullable();
            $table->unsignedBigInteger('topup_id')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('generated_against_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('topup_id')->references('id')->on('top_ups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_transactions');
    }
};
