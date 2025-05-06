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
        Schema::create('level_bonus_masters', function (Blueprint $table) {
            $table->id();
            $table->string('level_name')->nullable();
            $table->integer('level_number');
            $table->decimal('level_percentage', 8, 2)->default(0.00);
            $table->tinyInteger('is_visible')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_bonus_masters');
    }
};
