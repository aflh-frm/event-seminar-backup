<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class EOProfileController extends Controller
{
    // 1. Tampilkan Halaman Edit Profil
    public function edit()
    {
        $user = Auth::user();
        return view('eo.profile.edit', compact('user'));
    }

    // 2. Update Data Diri & Foto
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Update Text
        $user->name = $request->name;
        $user->email = $request->email;

        // Update Foto jika ada yang diupload
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (dan bukan foto default)
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            
            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 3. Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // Confirm password harus sama
        ]);

        $user = User::find(Auth::id());

        // Cek password lama benar atau tidak
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai!']);
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diganti!');
    }
}