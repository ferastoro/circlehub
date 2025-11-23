<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'start_date', 'end_date', 
        'teacher_id', 'category_id', 'status', 'image_path', 
    ];

    // Relasi: Course dimiliki satu Teacher (User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi: Course masuk dalam satu Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Course punya banyak materi (Contents)
    public function contents()
    {
        return $this->hasMany(CourseContent::class)->orderBy('order_sequence');
    }

    // Relasi: Course punya banyak murid (Enrollments)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function forumPosts()
    {
        // Ambil postingan induk saja (bukan balasan), urutkan dari yang terbaru
        return $this->hasMany(ForumPost::class)->whereNull('parent_id')->latest();
    }
}
