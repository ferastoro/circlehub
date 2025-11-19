<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminUserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        // Ambil ID user yang sedang diedit melalui Route Model Binding
        $userId = $this->route('user')->id; 

        return [
            'name' => ['required', 'string', 'max:255'],
            
            // Username dan Email harus unik, KECUALI untuk user yang sedang diedit ($userId)
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            
            // Password bersifat opsional saat edit. Jika diisi, harus valid.
            'password' => ['nullable', 'confirmed', Password::defaults()],
            
            'role' => ['required', 'string', 'in:student,teacher,admin'],
            'status' => ['required', 'string', 'in:active,inactive'], // Tambahkan Status
        ];
    }
}