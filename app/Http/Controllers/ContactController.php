<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Proses Pesan (Opsional: Simpan ke DB atau Kirim Email)
        // Contoh: Mail::to('admin@circlehub.id')->send(new ContactMail($request->all()));
        // Untuk sekarang, kita anggap pesan sukses terkirim.

        // 3. Redirect Kembali dengan Pesan Sukses
        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah kami terima. Tim kami akan segera menghubungi Anda.');
    }
}