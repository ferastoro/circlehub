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
        $enrollmentQuery = Enrollment::where('user_id', Auth::id());

        $enrollments = (clone $enrollmentQuery)
            ->with('course.teacher', 'course.category')
            ->latest()
            ->paginate(10);

        $totalEnrollments = (clone $enrollmentQuery)->count();
        $completedEnrollments = (clone $enrollmentQuery)
            ->where('status', 'completed')
            ->count();
        $averageProgress = (clone $enrollmentQuery)->avg('progress_percentage') ?? 0;

        return view('student.dashboard', compact(
            'enrollments',
            'totalEnrollments',
            'completedEnrollments',
            'averageProgress'
        ));
    }
}
