<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    // 1. Menampilkan Daftar Peserta (Hanya untuk event milik EO tersebut)
    public function index()
    {
        // Logika: Ambil transaksi dimana event-nya dibuat oleh EO yang sedang login
        $transactions = Transaction::with(['user', 'event'])
            ->whereHas('event', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('eo.participants.index', compact('transactions'));
    }

    // 2. Fitur Approve (Terima Pembayaran)
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Pastikan event ini milik EO yang login (Keamanan)
        if ($transaction->event->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Peserta berhasil diterima!');
    }

    // 3. Fitur Reject (Tolak Pembayaran)
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Keamanan
        if ($transaction->event->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Peserta ditolak.');
    }
}