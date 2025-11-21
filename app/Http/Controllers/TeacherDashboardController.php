<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function index(): View
    {
        $teacher = Auth::user();
        $courseQuery = $teacher->courses();

        $courseIds = (clone $courseQuery)->pluck('id');

        $courses = (clone $courseQuery)
            ->withCount('enrollments')
            ->latest()
            ->take(3)
            ->get();

        $totalCourses = $courseIds->count();
        $activeCourses = (clone $courseQuery)->where('status', 'active')->count();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->count();
        $totalLessons = CourseContent::whereIn('course_id', $courseIds)->count();

        return view('teacher.dashboard', compact(
            'teacher',
            'courses',
            'totalCourses',
            'activeCourses',
            'totalStudents',
            'totalLessons'
        ));
    }
}
