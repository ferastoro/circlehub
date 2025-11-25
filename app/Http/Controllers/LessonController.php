<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Digunakan untuk type hint

class LessonController extends Controller
{
    /**
     * Menampilkan Lesson Page dan memastikan student terdaftar. (Layout Req 5)
     */
    public function showLesson(Course $course, CourseContent $content)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Cek Enrollment: Pastikan Student sudah terdaftar di course ini
        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();
        if (!$enrollment) {
            return redirect()->route('course.show', $course->slug)->with('error', 'Anda harus terdaftar di course ini untuk mengakses materi.');
        }
        $enrollment->touch();
        
        // 2. Ambil semua konten dalam urutan
        $allContents = $course->contents()->orderBy('order_sequence')->get();
        $currentIndex = $allContents->search(function ($item) use ($content) {
            return $item->id === $content->id;
        });

        // 3. Cek Progress Materi
        $isCompleted = LessonProgress::where('user_id', $user->id)
                                     ->where('course_content_id', $content->id)
                                     ->exists();
        
        // 4. Cari materi berikutnya (untuk tombol "Lanjutkan")
        $nextContent = $allContents->get($currentIndex + 1);

        // TODO: Logic "Sebelum bisa lanjut, harus selesai dulu" (Advanced Req 5)
        // Jika materi ini bukan yang pertama, cek apakah materi sebelumnya sudah selesai.
        if ($currentIndex > 0) {
            $prevContent = $allContents->get($currentIndex - 1);
            $prevCompleted = LessonProgress::where('user_id', $user->id)
                                           ->where('course_content_id', $prevContent->id)
                                           ->exists();
            if (!$prevCompleted && !$isCompleted) {
                 return redirect()->route('student.lesson.show', [$course, $prevContent])
                                  ->with('error', 'Anda harus menyelesaikan materi sebelumnya: ' . $prevContent->title);
            }
        }
        

        return view('student.lesson_page', compact('course', 'content', 'isCompleted', 'nextContent'));
    }

    /**
     * Menandai materi sebagai selesai. (Mark as Done - Layout Req 5)
     */
    public function markAsDone(Course $course, CourseContent $content)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Cek Enrollment
        $enrollment = $course->enrollments()->where('user_id', $user->id)->exists();
        if (!$enrollment) {
            abort(403);
        }
        
        // Simpan progress, jika belum ada
        LessonProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_content_id' => $content->id,
            ],
            [
                'completed_at' => now(),
            ]
        );
        
        // Jika ada materi berikutnya, redirect ke sana, jika tidak, kembali ke detail course
        $nextContent = $course->contents()
                              ->where('order_sequence', '>', $content->order_sequence)
                              ->orderBy('order_sequence')
                              ->first();

        if ($nextContent) {
            return redirect()->route('student.lesson.show', [$course, $nextContent])
                             ->with('success', 'Materi selesai! Melanjutkan ke materi berikutnya.');
        } else {
            // Course Selesai
            // TODO: Update status enrollment menjadi 'completed' dan buat sertifikat (Advanced Req 2)
            $course->enrollments()->where('user_id', $user->id)->update(['status' => 'completed']);
            
            return redirect()->route('course.show', $course->slug)
                             ->with('success', 'Selamat! Anda telah menyelesaikan semua materi di course ini!');
        }
    }
}