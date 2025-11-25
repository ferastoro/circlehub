<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Menampilkan daftar Course yang diikuti Student dan progresnya.
     */
    public function index()
    {
        // Ambil semua enrollment yang diikuti oleh user yang sedang login
        $enrollments = Enrollment::where('user_id', Auth::id())
                                 ->with('course.teacher', 'course.category')
                                 ->orderByDesc('updated_at')
                                 ->paginate(10);
        
        return view('student.dashboard', compact('enrollments'));
    }

    public function myCourses()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
                                 ->with('course.teacher', 'course.category')
                                 ->latest()
                                 ->paginate(12); // Tampilkan lebih banyak per halaman
        
        return view('student.my_courses', compact('enrollments'));
    }

}