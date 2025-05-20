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
        Schema::create('mlm_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('minimum_purchase_amount', 10, 2)->default(0);
            $table->decimal('agent_direct_bonus', 5, 2)->default(0);
            $table->decimal('tds', 5, 2)->default(0);
            $table->decimal('repurchase', 5, 2)->default(0);
            $table->decimal('service_charge', 5, 2)->default(0);
            $table->decimal('add_on_percentage', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mlm_settings');
    }
};
