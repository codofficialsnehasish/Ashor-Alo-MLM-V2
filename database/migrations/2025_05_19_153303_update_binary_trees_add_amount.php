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
        Schema::table('binary_trees', function (Blueprint $table) {
            $table->decimal('joining_amount',10,2)->default(0.00)->after('status');
            $table->string('join_by')->nullable()->after('joining_amount');
            $table->unsignedBigInteger('joining_order_id')->nullable()->after('join_by');
            $table->foreign('joining_order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('binary_trees', function (Blueprint $table) {
            $table->dropForeign(['joining_order_id']);
            $table->dropColumn(['joining_amount','join_by','joining_order_id']);
        });
    }
};
