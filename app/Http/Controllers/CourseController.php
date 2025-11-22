<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Tampilkan daftar course. (List Courses)
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Logika tampilan Course berdasarkan Role
        if ($user->hasRole('admin')) {
            // Admin: Tampilkan semua Course
            $courses = Course::with('teacher', 'category')->latest()->paginate(10);
        } else {
            // Teacher: Tampilkan hanya Course yang dia buat
            $courses = Course::where('teacher_id', $user->id)
                             ->with('teacher', 'category')
                             ->latest()
                             ->paginate(10);
        }
        
        return view($user->role . '.courses.index', compact('courses'));
    }

    /**
     * Tampilkan form untuk membuat course baru. (Create Course)
     */
    public function create()
    {
        $categories = Category::all();
        $teachers = User::where('role', 'teacher')->get();
        
        /** @var User $user */
        $user = Auth::user();

        return view($user->role . '.courses.create', compact('categories', 'teachers'));
    }

    /**
     * Simpan course baru. (Store Course)
     */
    public function store(CourseRequest $request)
    {
        // Validasi data sudah dilakukan oleh CourseRequest
        $validated = $request->validated();

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Simpan file fisik
            $path = $request->file('image')->store('course-covers', 'public');
            
            // 🔥 PENTING: Simpan string 'storage/...' agar konsisten dengan 'images/...'
            // Hasilnya: 'storage/course-covers/namafile.jpg'
            $validated['image_path'] = 'storage/' . $path; 
        }
        // Buat Course baru dengan data yang sudah divalidasi (termasuk image_path jika ada)
        Course::create($validated);

        /** @var User $user */
        $user = Auth::user();

        return redirect()->route($user->role . '.courses.index')
                         ->with('success', 'Course baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit course. (Edit Course)
     */
    public function edit(Course $course)
    {
        /** @var User $user */ 
        $user = Auth::user();
        
        // Penerapan RBAC di sini: Hanya Admin ATAU Teacher pembuat yang boleh edit
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) { // Menggunakan $user->id
            abort(403, 'Akses Ditolak. Anda hanya dapat mengedit kursus yang Anda buat.');
        }

        $categories = Category::all();
        $teachers = User::where('role', 'teacher')->get();
        
        return view($user->role . '.courses.edit', compact('course', 'categories', 'teachers'));
    }

    /**
     * Update course. (Update Course)
     */
    public function update(CourseRequest $request, Course $course)
    {   
        /** @var User $user */
        $user = Auth::user();
        
        // RBAC: Cek lagi saat update
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) { // Menggunakan $user->id
            abort(403, 'Akses Ditolak.');
        }
        
        $validated = $request->validated();

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Simpan file fisik
            $path = $request->file('image')->store('course-covers', 'public');
            
            // 🔥 PENTING: Sama seperti di atas
            $validated['image_path'] = 'storage/' . $path;
        }

        $course->update($validated);

        return redirect()->route($user->role . '.courses.index')
                         ->with('success', 'Course "' . $course->title . '" berhasil diperbarui.');
    }

    /**
     * Hapus course. (Delete Course)
     */
    public function destroy(Course $course)
    {
        $courseTitle = $course->title;
        /** @var User $user */ 
        $user = Auth::user();

        // RBAC: Hanya Admin ATAU Teacher pembuat yang boleh menghapus
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Akses Ditolak. Anda hanya dapat menghapus kursus yang Anda buat.');
        }

        $course->delete(); // Cascade delete akan menghapus Contents dan Enrollments terkait

        return redirect()->route($user->role . '.courses.index')
                         ->with('success', 'Course "' . $courseTitle . '" berhasil dihapus.');
    }
}