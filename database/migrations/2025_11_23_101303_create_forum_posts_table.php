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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            // Relasi ke Course (Forum ini milik course mana?)
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');

            // Relasi ke User (Siapa yang posting?)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Post lain (Untuk fitur Reply/Balasan)
            // Jika null = Pertanyaan Baru. Jika terisi = Balasan komentar.
            $table->foreignId('parent_id')->nullable()->constrained('forum_posts')->onDelete('cascade');

            $table->text('body'); // Isi percakapan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
