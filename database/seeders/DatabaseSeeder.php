<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Enrollment;
use App\Models\LessonProgress;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // 1. USER SEEDING (Admin, Teacher, Student)
        // ---------------------------------------------------------
        echo "Creating Users...\n";

        // Admin
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Teacher 1 (Web & Mobile Expert)
        $teacher1 = User::create([
            'name' => 'Mr. Sandhika Galih',
            'username' => 'sandhika',
            'email' => 'teacher@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        // Teacher 2 (Data & Security Expert)
        $teacher2 = User::create([
            'name' => 'Mrs. Angela Yu',
            'username' => 'angela',
            'email' => 'angela@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        // Students
        $student1 = User::create([
            'name' => 'Jack Fox',
            'username' => 'jacky',
            'email' => 'student1@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $student2 = User::create([
            'name' => 'Serena Motolla ',
            'username' => 'SereNM',
            'email' => 'student2@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $student3 = User::create([
            'name' => 'Zack Nicholas',
            'username' => 'NichoZ',
            'email' => 'student3@circlehub.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        // ---------------------------------------------------------
        // 2. CATEGORY SEEDING (Ditambah Lebih Banyak)
        // ---------------------------------------------------------
        echo "Creating Categories...\n";
        $catWeb = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);
        $catMobile = Category::create(['name' => 'Mobile Development', 'slug' => 'mobile-development']);
        $catData = Category::create(['name' => 'Data Science', 'slug' => 'data-science']);
        $catSecurity = Category::create(['name' => 'Cyber Security', 'slug' => 'cyber-security']);
        $catDesign = Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']);
        $catCloud = Category::create(['name' => 'Cloud Computing', 'slug' => 'cloud-computing']);

        // Courses (DENGAN GAMBAR)
        echo "Creating Courses & Content...\n";

        // Course 1: Laravel
        $courseLaravel = Course::create([
            'title' => 'Mastering Laravel 11 untuk Pemula',
            'slug' => 'mastering-laravel-11',
            'description' => 'Panduan lengkap mempelajari framework PHP terpopuler dari nol hingga mahir.',
            'teacher_id' => $teacher1->id,
            'category_id' => $catWeb->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
            'status' => 'active',
            'image_path' => 'images/course1.jpg', // <--- Path Gambar Manual
        ]);
        $this->createContents($courseLaravel);

        // Course 2: Python
        $coursePython = Course::create([
            'title' => 'Python for Data Science Bootcamp',
            'slug' => 'python-data-science',
            'description' => 'Belajar analisis data menggunakan Python, Pandas, dan Matplotlib.',
            'teacher_id' => $teacher2->id,
            'category_id' => $catData->id,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addMonths(2),
            'status' => 'active',
            'image_path' => 'images/course2.jpg', // <--- Path Gambar Manual
        ]);
        $this->createContents($coursePython);

        // Course 3: Flutter
        $courseFlutter = Course::create([
            'title' => 'Bangun Aplikasi Android dengan Flutter',
            'slug' => 'android-flutter-dev',
            'description' => 'Pelajari cara membuat aplikasi mobile lintas platform dengan Flutter.',
            'teacher_id' => $teacher1->id,
            'category_id' => $catMobile->id,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addMonths(3),
            'status' => 'active',
            'image_path' => 'images/course3.jpg', // <--- Path Gambar Manual
        ]);
        $this->createContents($courseFlutter);

        // Course 4: Ethical Hacking
        $courseHacking = Course::create([
            'title' => 'Ethical Hacking: Zero to Hero',
            'slug' => 'ethical-hacking-101',
            'description' => 'Pelajari keamanan siber dan cara melindungi sistem dari serangan.',
            'teacher_id' => $teacher2->id,
            'category_id' => $catSecurity->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(4),
            'status' => 'active',
            'image_path' => 'images/course4.jpg', // <--- Path Gambar Manual
        ]);
        $this->createContents($courseHacking);

        // Course 5: AWS Cloud
        $courseAWS = Course::create([
            'title' => 'AWS Cloud Practitioner Essentials',
            'slug' => 'aws-cloud-practitioner',
            'description' => 'Persiapan sertifikasi AWS Cloud Practitioner.',
            'teacher_id' => $teacher1->id,
            'category_id' => $catCloud->id,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addMonths(1),
            'status' => 'active',
            'image_path' => 'images/course5.jpg', // <--- Path Gambar Manual
        ]);
        $this->createContents($courseAWS);

        // Course 6: UI/UX (Inactive)
        $courseUIUX = Course::create([
            'title' => 'Figma UI Design Masterclass',
            'slug' => 'figma-ui-design',
            'description' => 'Kursus ini sedang dalam tahap persiapan.',
            'teacher_id' => $teacher1->id,
            'category_id' => $catDesign->id,
            'start_date' => now()->addMonths(1),
            'end_date' => now()->addMonths(2),
            'status' => 'inactive',
            'image_path' => 'images/course6.jpg', // <--- Path Gambar Manual
        ]);

        // Enrollments
        echo "Creating Enrollments...\n";
        Enrollment::create(['user_id' => $student1->id, 'course_id' => $courseLaravel->id, 'status' => 'active']);
        Enrollment::create(['user_id' => $student1->id, 'course_id' => $coursePython->id, 'status' => 'active']);
        Enrollment::create(['user_id' => $student2->id, 'course_id' => $courseFlutter->id, 'status' => 'active']);
        Enrollment::create(['user_id' => $student3->id, 'course_id' => $courseLaravel->id, 'status' => 'completed', 'completed_at' => now()]);
        Enrollment::create(['user_id' => $student3->id, 'course_id' => $courseHacking->id, 'status' => 'active']);

        echo "Seeding Complete!\n";
    }

    // Helper untuk isi materi dummy
    private function createContents($course) {
        CourseContent::create(['course_id' => $course->id, 'title' => 'Pendahuluan', 'body' => 'Pengenalan materi...', 'order_sequence' => 1]);
        CourseContent::create(['course_id' => $course->id, 'title' => 'Instalasi Tools', 'body' => 'Cara install tools...', 'order_sequence' => 2]);
        CourseContent::create(['course_id' => $course->id, 'title' => 'Konsep Dasar', 'body' => 'Teori dasar...', 'order_sequence' => 3]);
    }
}