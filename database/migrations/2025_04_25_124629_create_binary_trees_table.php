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
        Schema::create('binary_trees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->notNullable(); // user id from the users table
            $table->bigInteger('parent_id')->unsigned()->nullable(); // parent user (parent node)
            $table->enum('position', ['left', 'right'])->nullable(); // Position in the tree (left or right)
            
            // Left and Right user ids - nullable for flexibility
            $table->bigInteger('left_user_id')->unsigned()->nullable(); 
            $table->bigInteger('right_user_id')->unsigned()->nullable();
            
            $table->timestamps(); // Laravel timestamps for created_at and updated_at
        
            // Foreign key constraints 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('binary_trees')->onDelete('set null');
            $table->foreign('left_user_id')->references('id')->on('binary_trees')->onDelete('set null');
            $table->foreign('right_user_id')->references('id')->on('binary_trees')->onDelete('set null');
        });
            
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binary_trees');
    }
};
