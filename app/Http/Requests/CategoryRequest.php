<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; // Import Str Helper

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    protected function prepareForValidation()
    {
        // Secara otomatis membuat slug dari nama jika slug kosong
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }

    public function rules(): array
    {
        // Jika mode UPDATE, kita ambil ID category yang sedang diedit
        $categoryId = $this->route('category') ? $this->route('category')->id : null; 

        return [
            'name' => ['required', 'string', 'max:255'],
            
            // Slug harus unik, KECUALI untuk category yang sedang diedit
            'slug' => ['required', 'string', Rule::unique('categories')->ignore($categoryId)],
        ];
    }
}