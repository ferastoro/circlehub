<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContentController; // Tambahkan ContentController
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentDashboardController;

// --- Rute Redirect Dashboard ---
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP ROUTE ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // CMS Modul: User, Category, Course
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show', 'create']);
    Route::resource('courses', CourseController::class);
    
    // 🔥 Modul 4: Content Management (NESTED RESOURCE - ADMIN)
    Route::resource('courses.contents', ContentController::class);
});


// --- GROUP ROUTE TEACHER ---
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');
    
    // CMS Modul: Course
    Route::resource('courses', CourseController::class);
    
    // 🔥 Modul 4: Content Management (NESTED RESOURCE - TEACHER)
    Route::resource('courses.contents', ContentController::class);
});


// --- GROUP ROUTE STUDENT ---
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::controller(LessonController::class)->group(function () {
        // Rute untuk menampilkan satu materi
        Route::get('/course/{course}/lesson/{content}', 'showLesson')->name('lesson.show');
        // Rute untuk menandai materi selesai
        Route::post('/course/{course}/lesson/{content}/done', 'markAsDone')->name('lesson.mark_done');
    });
});


// 🔥 RUTE PUBLIK (GUEST & STUDENT) - DITARUH PALING AKHIR UNTUK MENGHINDARI KONFLIK
Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'homepage')->name('homepage'); // Homepage (Menggantikan view welcome)
    Route::get('/catalog', 'catalog')->name('catalog'); // Course Catalog
    Route::get('/course/{course:slug}', 'showCourse')->name('course.show'); // Detail Course

    // Enrollment Logic
    Route::post('/enroll/{course:slug}', 'enrollStore')
        ->middleware('auth') // Hanya user yang sudah login bisa enroll
        ->name('enroll.store');
});


// Route Profile Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';