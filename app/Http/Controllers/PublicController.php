<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Menampilkan Homepage (Layout Req 2)
     */
    public function homepage()
    {
        // Layout Req 2: Menampilkan 5 course terpopuler berdasarkan jumlah peserta (Enrollment)
        $popularCourses = Course::withCount('enrollments') // Menghitung peserta
                                ->orderByDesc('enrollments_count')
                                ->where('status', 'active')
                                ->take(5)
                                ->get();

        // Data tambahan untuk filtering
        $categories = Category::all();
        
        return view('public.homepage', compact('popularCourses', 'categories'));
    }

    /**
     * Menampilkan Course Catalog (Layout Req 3)
     */
    public function catalog(Request $request)
    {
        $categories = Category::all();
        $query = Course::with(['teacher', 'category'])
                       ->where('status', 'active');
        
        // Layout Req 2: Menyediakan kolom pencarian
        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        // Layout Req 2: Opsi filtering berdasarkan kategori
        if ($categorySlug = $request->get('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $courses = $query->paginate(10);

        return view('public.catalog', compact('courses', 'categories'));
    }

    /**
     * Menampilkan Detail Course (Layout Req 3)
     */
    public function showCourse(Course $course)
    {
        $course->load(['teacher', 'category', 'contents']);
        // Ambil materi pertama (diurutkan)
        $firstLesson = $course->contents()->orderBy('order_sequence')->first();

        // Cek apakah user sudah enrollment atau belum (untuk tombol Enroll/Lanjutkan)
        $isEnrolled = false;
        $progress = null;
        if (Auth::check()) {
            $enrollment = $course->enrollments()->where('user_id', Auth::id())->first();
            if ($enrollment) {
                $isEnrolled = true;
                // Kita akan hitung progress di langkah berikutnya
            }
        
            return view('public.course_detail', compact('course', 'isEnrolled', 'firstLesson')); // Tambahkan firstLesson
        }

        return view('public.course_detail', compact('course', 'isEnrolled'));
    }

    public function enrollStore(Course $course)
    {
        // Pengecekan status course
        if ($course->status !== 'active') {
             return redirect()->back()->with('error', 'Course ini tidak aktif dan tidak dapat didaftarkan.');
        }

        // Mencegah duplikasi enrollment
        $existingEnrollment = Enrollment::where('user_id', Auth::id())
                                        ->where('course_id', $course->id)
                                        ->exists();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di course ini.');
        }

        // Buat enrollment baru
        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'status' => 'active',
        ]);
        
        return redirect()->route('course.show', $course->slug)
                         ->with('success', 'Selamat! Anda berhasil terdaftar di course ini.');
    }

    
}