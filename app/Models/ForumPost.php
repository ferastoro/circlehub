<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'user_id', 'parent_id', 'body'];

    // Siapa penulis postingan ini?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Postingan ini milik course apa?
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi ke Anak (Balasan/Replies)
    public function replies()
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }
}