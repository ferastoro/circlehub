<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ForumController extends Controller
{
    public function store(Request $request, Course $course)
    {
        /** @var \App\Models\User $user */ // Type hint untuk IDE
        $user = Auth::user();

        // ... (validasi) ...

        // GUNAKAN $user->id, BUKAN Auth::id()
        $isEnrolled = $course->enrollments()->where('user_id', $user->id)->exists();
        
        // GUNAKAN $user->id
        $isTeacher = $course->teacher_id === $user->id;
        
        // GUNAKAN $user->hasRole(...) <--- INI KUNCINYA
        $isAdmin = $user->hasRole('admin');

        if (!$isEnrolled && !$isTeacher && !$isAdmin) {
            return back()->with('error', 'Anda harus terdaftar di kelas ini untuk berdiskusi.');
        }

        ForumPost::create([
            'course_id' => $course->id,
            'user_id' => $user->id, // Gunakan $user->id
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function destroy(ForumPost $post)
    {
        /** @var \App\Models\User $user */ // Tambahkan ini juga di destroy()
        $user = Auth::user();

        // Gunakan $user untuk pengecekan
        if ($user->id !== $post->user_id && !$user->hasRole('admin') && !$user->hasRole('teacher')) {
            abort(403);
        }

        $post->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}