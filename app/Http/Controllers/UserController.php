<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1. Daftar Semua User (Kecuali Admin sendiri)
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
                     ->orderBy('role', 'asc') // Urutkan biar EO dan User berkelompok
                     ->latest()
                     ->paginate(10);
                     
        return view('admin.users.index', compact('users'));
    }

    // 2. Hapus User (Banned)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus semua event & transaksi terkait user ini (Opsional, biar bersih)
        // $user->events()->delete(); 
        // $user->transactions()->delete();

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}