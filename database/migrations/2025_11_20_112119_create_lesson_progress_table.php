<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            // Siapa yang menyelesaikan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            // Materi mana yang diselesaikan
            $table->foreignId('course_content_id')->constrained('course_contents')->onDelete('cascade'); 
            // Pastikan tidak ada duplikasi
            $table->unique(['user_id', 'course_content_id']); 
            
            $table->timestamp('completed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
    }
};