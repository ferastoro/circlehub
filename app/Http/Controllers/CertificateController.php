<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class CertificateController extends Controller
{
    public function download(Course $course)
    {
        $user = Auth::user();

        // 1. Validasi: Cek apakah user sudah Enroll dan Progress 100%
        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();

        if (!$enrollment || $enrollment->progress_percentage < 100) {
            return redirect()->back()->with('error', 'Selesaikan semua materi untuk mendapatkan sertifikat!');
        }

        // 2. Load Template
        $imgPath = public_path('images/certificate-template.png');
        
        if (!file_exists($imgPath)) {
            return back()->with('error', 'Template sertifikat tidak ditemukan.');
        }

        // 3. Buat Canvas dari Gambar Template
        $image = Image::read($imgPath);

        // --- SETUP WARNA ---
        $colorWhite = '#ffffff'; // Warna putih untuk teks utama
        $colorBlack = '#1F2937'; // Warna teks gelap

        // --- A. NAMA PESERTA (League Gothic) ---
        // Anda mungkin perlu menyesuaikan koordinat Y (900) sesuai posisi garis di template
        $image->text(strtoupper($user->name), 1000, 710, function ($font) use ($colorWhite) {
            $font->file(public_path('fonts/LeagueGothic-Regular.ttf')); // Pastikan file ini ada
            $font->size(145); // Ukuran font besar untuk nama
            $font->color($colorWhite);
            $font->align('center'); // Agar teks tepat di tengah secara horizontal
            $font->valign('middle');
        });

        // --- B. JUDUL COURSE (Nourd Bold) ---
        $image->text(strtoupper($course->title), 1000, 950, function ($font) use ($colorWhite) {
            $font->file(public_path('fonts/Nourd-Bold.ttf'));
            $font->size(55);
            $font->color($colorWhite);
            $font->align('center');
            $font->valign('middle');
        });

        // --- C. TANGGAL (Opsional - Pakai font biasa/bawaan jika Nourd tidak ada regular) ---
        $date = $enrollment->completed_at ? $enrollment->completed_at->format('d F Y') : now()->format('d F Y');
        $image->text('Completed on ' . $date, 1000, 1350, function ($font) use ($colorBlack) {
            $font->file(public_path('fonts/Nourd-Bold.ttf'));
            $font->size(33);
            $font->color('#6B7280'); // Abu-abu
            $font->align('center');
            $font->valign('top');
        });

        // 4. Output
        $filename = 'Certificate-' . $user->username . '.jpg';
        
        return response()->streamDownload(function() use ($image) {
            echo $image->toJpeg(quality: 90);
        }, $filename);
    }
}