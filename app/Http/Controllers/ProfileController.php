<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\LessonProgress; // Untuk hitung total progress
use App\Models\Enrollment;
use App\Models\Course;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Data Khusus untuk Profil
        $profileData = [];

        if ($user->hasRole('student')) {
            // Student: Menampilkan kursus yang diikuti dengan progress pembelajaran.
            $profileData['enrollments'] = Enrollment::where('user_id', $user->id)
                                                  ->with('course.teacher')
                                                  ->get();
        } elseif ($user->hasRole('teacher')) {
            // Teacher: Menampilkan kursus yang diajarkan, dengan akses ke informasi progress student.
            $profileData['taughtCourses'] = Course::where('teacher_id', $user->id)
                                                    ->with(['enrollments', 'enrollments.user', 'contents'])
                                                    ->get();
            
            // Helper untuk menghitung total pelajaran di setiap course yang diajarkan
            $profileData['lessonCounts'] = $profileData['taughtCourses']->pluck('contents')->map(fn ($contents) => $contents->count());
        }

        return view('profile.edit', array_merge($profileData, [
            'user' => $request->user(),
        ]));
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
