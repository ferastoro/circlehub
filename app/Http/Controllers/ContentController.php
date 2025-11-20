<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContentRequest;
use App\Models\User; // Digunakan untuk type hint

class ContentController extends Controller
{
    /**
     * Tampilkan daftar materi untuk course tertentu. (List Contents)
     */
    public function index(Course $course)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. RBAC: Pastikan user adalah Admin ATAU Teacher pembuat Course
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke konten kursus ini.');
        }

        // Ambil semua konten yang terkait dengan course ini, urutkan berdasarkan sequence
        $contents = $course->contents()->latest('order_sequence')->paginate(10); 
        
        $viewPath = $user->role . '.contents.index';

        return view($viewPath, compact('course', 'contents'));
    }

    /**
     * Tampilkan form untuk membuat materi baru. (Create Content)
     */
    public function create(Course $course)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // RBAC: Pastikan user adalah Admin ATAU Teacher pembuat Course
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke konten kursus ini.');
        }

        $viewPath = $user->role . '.contents.create';
        return view($viewPath, compact('course'));
    }

    /**
     * Menyimpan materi baru ke database. (Store Content)
     */
    public function store(ContentRequest $request, Course $course)
    {
        /** @var User $user */
        $user = Auth::user();

        // RBAC: Hanya Admin ATAU Teacher pembuat Course yang boleh menambah materi
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Akses Ditolak.');
        }

        $validated = $request->validated();
        
        // Tambahkan course_id ke data yang divalidasi
        $content = $course->contents()->create($validated);
        
        // Jika order_sequence kosong, kita set otomatis ke urutan terakhir
        if (! $content->order_sequence) {
             $content->order_sequence = $course->contents()->max('order_sequence') ?? 1;
             $content->save();
        }

        return redirect()->route($user->role . '.courses.contents.index', $course)
                         ->with('success', 'Materi "' . $content->title . '" berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit materi. (Edit Content)
     */
    public function edit(Course $course, CourseContent $content)
    {
        /** @var User $user */
        $user = Auth::user();

        // RBAC: Hanya Admin ATAU Teacher pembuat Course yang boleh edit materi
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Akses Ditolak.');
        }

        $viewPath = $user->role . '.contents.edit';
        return view($viewPath, compact('course', 'content'));
    }

    /**
     * Memperbarui materi di database. (Update Content)
     */
    public function update(ContentRequest $request, Course $course, CourseContent $content)
    {
        /** @var User $user */
        $user = Auth::user();

        // RBAC: Cek lagi saat update
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Akses Ditolak.');
        }
        
        $content->update($request->validated());

        return redirect()->route($user->role . '.courses.contents.index', $course)
                         ->with('success', 'Materi "' . $content->title . '" berhasil diperbarui.');
    }

    /**
     * Menghapus materi dari database. (Delete Content)
     */
    public function destroy(Course $course, CourseContent $content)
    {
        /** @var User $user */
        $user = Auth::user();

        // RBAC: Cek lagi saat destroy
        if ($user->hasRole('teacher') && $course->teacher_id !== $user->id) {
            abort(403, 'Akses Ditolak.');
        }
        
        $contentTitle = $content->title;
        $content->delete(); 

        return redirect()->route($user->role . '.courses.contents.index', $course)
                         ->with('success', 'Materi "' . $contentTitle . '" berhasil dihapus.');
    }
}