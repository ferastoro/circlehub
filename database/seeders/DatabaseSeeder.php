<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseContent;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@circlehub.com',
            'password' => Hash::make('password'), // Passwordnya 'password'
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Buat Akun TEACHER
        $teacher = User::create([
            'name' => 'Mr. Budi Guru',
            'username' => 'teacher',
            'email' => 'teacher@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        // 3. Buat Akun STUDENT
        User::create([
            'name' => 'Siswa Teladan',
            'username' => 'student',
            'email' => 'student@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        // 4. Buat Kategori
        $catWeb = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development'
        ]);

        Category::create([
            'name' => 'Data Science',
            'slug' => 'data-science'
        ]);

        // 5. Buat Contoh Course (Oleh Teacher diatas)
        $course = Course::create([
            'title' => 'Belajar Laravel Dasar',
            'slug' => 'belajar-laravel-dasar',
            'description' => 'Panduan lengkap belajar framework PHP Laravel dari nol.',
            'teacher_id' => $teacher->id,
            'category_id' => $catWeb->id,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
        ]);

        // 6. Buat Materi untuk Course tersebut
        CourseContent::create([
            'course_id' => $course->id,
            'title' => 'Pengenalan Laravel',
            'body' => 'Laravel adalah framework PHP yang ekspresif dan elegan...',
            'order_sequence' => 1
        ]);

        CourseContent::create([
            'course_id' => $course->id,
            'title' => 'Instalasi dan Konfigurasi',
            'body' => 'Cara install laravel menggunakan composer adalah...',
            'order_sequence' => 2
        ]);
    }
}