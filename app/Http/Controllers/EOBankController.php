<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EOBankController extends Controller
{
    // Tampilkan HANYA rekening milik EO yang sedang login
    public function index()
    {
        $banks = Bank::where('user_id', Auth::id())->latest()->get();
        return view('eo.banks.index', compact('banks'));
    }

    // Simpan Rekening Baru
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|numeric',
            'account_holder' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // PENTING: Set pemilik rekening otomatis

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('banks', 'public');
        }

        Bank::create($data);

        return back()->with('success', 'Rekening berhasil ditambahkan!');
    }

    // Hapus Rekening
    public function destroy($id)
    {
        // Pastikan yang dihapus adalah rekening milik sendiri (Keamanan)
        $bank = Bank::where('user_id', Auth::id())->findOrFail($id);
        
        if($bank->logo && Storage::exists('public/'.$bank->logo)){
            Storage::delete('public/'.$bank->logo);
        }

        $bank->delete();
        return back()->with('success', 'Rekening berhasil dihapus!');
    }
}