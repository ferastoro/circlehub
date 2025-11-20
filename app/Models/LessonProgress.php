<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress'; // Nama tabel yang sudah dibuat
    
    protected $fillable = [
        'user_id',
        'course_content_id',
        'completed_at',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi balik ke CourseContent
    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }
}