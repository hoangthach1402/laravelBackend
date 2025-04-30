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
        Schema::create('habit_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade'); // Foreign key to habits table
            $table->date('date');
            $table->string('status')->default('checked'); // e.g., checked, skipped
            $table->timestamps();

            $table->unique(['habit_id', 'date']); // Ensure only one entry per habit per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_progress');
    }
};
