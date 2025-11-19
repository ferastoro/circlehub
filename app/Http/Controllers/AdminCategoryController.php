<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest; // Import Request yang baru dibuat

class AdminCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dan form tambah kategori. (List + Create Form)
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru ke database. (Create/Store)
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menghapus kategori dari database. (Delete)
     */
    public function destroy(Category $category)
    {
        // TODO: Tambahkan validasi agar kategori tidak bisa dihapus jika masih ada Course di dalamnya.
        
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ' . $category->name . ' berhasil dihapus.');
    }
    
    // Fungsi Edit dan Update akan diisi di langkah berikutnya
    public function edit(Category $category)
    {
        // Fungsi ini hanya me-redirect ke index dengan variabel category yang akan diedit
        return redirect()->route('admin.categories.index', ['edit_id' => $category->id]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        // Akan diisi nanti, biasanya sama seperti store tapi menggunakan $category->update()
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ' . $category->name . ' berhasil diperbarui.');
    }
}