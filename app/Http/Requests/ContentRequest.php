<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Izinkan Admin dan Teacher untuk mengakses modul ini
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'], // Isi materi (teks atau media)
            'order_sequence' => ['nullable', 'integer', 'min:1'], // Urutan materi
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'min' => 'Kolom :attribute harus minimal :min.',
            'integer' => 'Kolom :attribute harus berupa angka.',
        ];
    }
}