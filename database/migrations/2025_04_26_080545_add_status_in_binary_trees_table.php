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
            $table->string('member_number', 20)->unique()->after('user_id'); // Unique ID like 12365478
            $table->bigInteger('sponsor_id')->unsigned()->nullable()->after('member_number'); // Sponsor user ID
            $table->tinyInteger('status')->default(0)->after('right_user_id');
            $table->timestamp('activated_at')->nullable()->after('status');

            $table->foreign('sponsor_id')->references('id')->on('binary_trees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('binary_trees', function (Blueprint $table) {
            $table->dropForeign(['sponsor_id']);
            $table->dropColumn(['member_number','sponsor_id','status','activated_at']);
        });
    }
};
