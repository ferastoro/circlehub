<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminUserStoreRequest; // Import Form Request untuk Create User

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna. (List Users)
     */
    public function index()
    {
        // Ambil semua user, urutkan terbaru, dan gunakan pagination
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru. (Create User)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data user baru ke database. (Store User)
     */
    public function store(AdminUserStoreRequest $request)
    {
        // Data sudah divalidasi oleh AdminUserStoreRequest
        $validated = $request->validated();
        
        // Simpan User Baru
        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'active', // Default status: active
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan!');
    }
    
    // --- FUNGSI LAIN (Edit, Update, Delete) akan kita kerjakan setelah ini ---

    /**
     * Menampilkan detail user (Jika diperlukan).
     */
    public function show(User $user)
    {
        // Tidak perlu diimplementasikan sekarang
    }

    /**
     * Menampilkan form untuk edit user yang ada. (Akan diisi nanti)
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database. (Akan diisi nanti)
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validated();
        
        // Data yang akan di-update
        $dataToUpdate = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        // Jika password diisi, hash password baru
        if (!empty($validated['password'])) {
            $dataToUpdate['password'] = Hash::make($validated['password']);
        }
        
        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('success', 'User ' . $user->username . ' berhasil diperbarui!');   
    }

    /**
     * Menghapus user dari database. (Akan diisi nanti)
     */
    public function destroy(User $user)
    {
        // Pastikan Admin tidak bisa menghapus akunnya sendiri
        if (Auth::user()->id === $user->id) { 
        return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $username = $user->username;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User ' . $username . ' berhasil dihapus.');
    }
}