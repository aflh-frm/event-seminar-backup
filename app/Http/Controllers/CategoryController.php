<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Tampilkan Daftar Kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Simpan Kategori Baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        
        Category::create(['name' => $request->name]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 3. Update Kategori
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:categories,name,'.$id]);
        
        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 4. Hapus Kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}