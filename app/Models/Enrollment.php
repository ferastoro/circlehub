<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
