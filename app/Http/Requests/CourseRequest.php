<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import Model User

/**
 * @property User $user
 */
class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Panggilan hasRole() untuk $this->user() di authorize()
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    protected function prepareForValidation()
    {
        // Dapatkan user saat ini dari Form Request
        $currentUser = $this->user(); 
        
        // Buat slug dari judul
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);

        // Jika user adalah Teacher, set teacher_id-nya secara otomatis
        // Gunakan $currentUser yang sudah di-hint
        if ($currentUser->hasRole('teacher')) { 
            $this->merge([
                'teacher_id' => $currentUser->id,
            ]);
        }
        
        // Atur status default jika tidak ada di request
        if (! $this->has('status')) {
            $this->merge(['status' => 'active']);
        }
    }

    public function rules(): array
    {
        // Dapatkan user saat ini untuk digunakan di rules
        $currentUser = $this->user();

        // Ambil ID course yang sedang diedit (jika ada)
        $courseId = $this->route('course') ? $this->route('course')->id : null; 
        
        // Aturan untuk teacher_id dan status hanya berlaku untuk Admin
        $teacherIdRule = $currentUser->hasRole('admin') 
                         ? ['required', 'exists:users,id'] // Admin harus memilih Teacher
                         : ['required', Rule::in([$currentUser->id])]; // Teacher hanya boleh memilih dirinya sendiri
        
        $statusRule = $currentUser->hasRole('admin') 
                      ? ['required', 'in:active,inactive'] 
                      : ['in:active,inactive'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique('courses')->ignore($courseId)],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'teacher_id' => $teacherIdRule,
            'status' => $statusRule,
        ];
    }
}