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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Fremdschlüssel zu users
            $table->foreignId('subject_id')->constrained(); // Fremdschlüssel zu subjects
            $table->decimal('grade', 3, 1); // Note
            $table->string('description')->nullable(); // Beschreibung
            $table->integer('weight')->default(1); // Gewichtung
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
