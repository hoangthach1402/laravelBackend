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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('habit_id')->constrained()->onDelete('cascade'); // Foreign key to habits table
            $table->string('name'); // Name of the achievement (e.g., "Completed [Habit Name]")
            $table->date('start_date'); // Start date of the habit
            $table->date('completion_date'); // Date the habit was marked as completed
            $table->integer('target_days'); // Target days for the habit
            $table->integer('checked_days_count'); // Actual checked days when achieved
            $table->timestamps();

            $table->unique(['user_id', 'habit_id']); // Ensure only one achievement per user per habit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
