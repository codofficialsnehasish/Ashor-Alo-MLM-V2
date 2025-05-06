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
        Schema::create('remuneration_benefit_masters', function (Blueprint $table) {
            $table->id();
            $table->string('rank_name')->nullable();
            $table->decimal('matching_target', 10, 2)->default(0.00);
            $table->decimal('bonus', 10, 2)->default(0.00);
            $table->integer('month_validity')->comment('Validity duration in months');
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
        Schema::dropIfExists('remuneration_benefit_masters');
    }
};
