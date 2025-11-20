<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi: User sebagai Teacher punya banyak Course
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // Relasi: User sebagai Student punya banyak Enrollment (Kelas yang diambil)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    // Helper function untuk cek role dengan mudah
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }
}
