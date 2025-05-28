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
        Schema::create('nominees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->date('nominee_dob')->nullable();
            $table->text('nominee_address')->nullable();
            $table->unsignedBigInteger('nominee_state_id')->nullable();
            $table->unsignedBigInteger('nominee_city_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominees');
    }
};
