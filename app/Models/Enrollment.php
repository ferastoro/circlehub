<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth; // Digunakan di accessor

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'status', 'completed_at'];

    // Relasi: Enrollment milik satu User (Student)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Enrollment mengacu ke satu Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Accessor untuk menghitung progres belajar dalam persentase.
     */
    protected function getProgressPercentageAttribute()
    {
        $totalLessons = $this->course->contents()->count();
        
        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = LessonProgress::where('user_id', $this->user_id)
                                          ->whereHas('content', function ($query) {
                                              $query->where('course_id', $this->course_id);
                                          })
                                          ->count();
        
        return round(($completedLessons / $totalLessons) * 100);
    }
}
