<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ParticipantController extends Controller
{
    // ================================================
    // BAGIAN 1: KHUSUS EO (PANITIA) - VALIDASI PESERTA
    // ================================================

    // 1. Menampilkan Daftar Peserta (Hanya untuk event milik EO tersebut)
    public function index()
    {
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
        
        if ($transaction->event->user_id != Auth::id()) {
            abort(403);
        }

        $transaction->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Peserta ditolak.');
    }


    // ===================================================
    // BAGIAN 2: KHUSUS PESERTA (USER) - DASHBOARD & TIKET
    // ===================================================

    // 4. DASHBOARD UTAMA (Ringkasan Statistik) - UPDATE
    public function dashboard()
    {
        $userId = Auth::id();

        // Hitung Statistik
        $totalTickets = Transaction::where('user_id', $userId)->count();
        $activeTickets = Transaction::where('user_id', $userId)->where('status', 'confirmed')->count();
        $pendingTickets = Transaction::where('user_id', $userId)->where('status', 'pending')->count();
        
        // Ambil 3 tiket terbaru saja untuk preview
        $recentTickets = Transaction::with('event')
                                    ->where('user_id', $userId)
                                    ->latest()
                                    ->take(3)
                                    ->get();

        return view('peserta.dashboard', compact('totalTickets', 'activeTickets', 'pendingTickets', 'recentTickets'));
    }

    // 5. HALAMAN TIKET SAYA (Daftar Lengkap) - BARU
    public function tickets()
    {
        $transactions = Transaction::with('event')
                                   ->where('user_id', Auth::id())
                                   ->latest()
                                   ->get();

        return view('peserta.tickets', compact('transactions'));
    }

// 6. Form Checkout (Pendaftaran)
    public function checkout($id)
    {
        $event = Event::with('user')->findOrFail($id);

        // Cek transaksi TERAKHIR user di event ini
        $existing = Transaction::where('user_id', Auth::id())
                               ->where('event_id', $id)
                               ->latest() // PENTING: Ambil yang paling baru
                               ->first();

        // Redirect hanya jika transaksi ada DAN statusnya BUKAN rejected.
        // Jadi kalau statusnya 'rejected', dia akan lolos dari if ini (bisa daftar lagi).
        if ($existing && $existing->status != 'rejected') {
            return redirect()->route('peserta.tickets')->with('warning', 'Kamu sudah terdaftar (Pending/Aktif) di event ini!');
        }

        $eo_id = $event->user_id;
        $banks = Bank::where('user_id', $eo_id)->get();

        return view('peserta.checkout', compact('event', 'banks'));
    }

    // 7. Proses Simpan Pendaftaran
    public function store(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bank_id' => 'required'
        ]);

        $event = Event::findOrFail($id);
        $path = $request->file('payment_proof')->store('payments', 'public');

        Transaction::create([
            'user_id' => Auth::id(),
            'event_id' => $id,
            'transaction_date' => now(),
            'status' => 'pending',
            'payment_proof' => $path,
            'total_price' => $event->price,
        ]);

        // Redirect ke halaman Tiket Saya setelah sukses
        return redirect()->route('peserta.tickets')->with('success', 'Pendaftaran berhasil! Cek status tiket Anda.');
    }
    public function downloadTicket($id)
    {
        // 1. Ambil Data Transaksi
        $transaction = Transaction::with(['event', 'user'])->where('user_id', Auth::id())->findOrFail($id);

        // 2. Pastikan Statusnya Confirmed (Aktif)
        if ($transaction->status != 'confirmed') {
            return back()->with('error', 'Tiket belum aktif!');
        }

        // 3. Generate QR Code (Gambar)
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($transaction->id . '-' . $transaction->user->email));

        // 4. Load View PDF
        $pdf = Pdf::loadView('peserta.pdf_ticket', compact('transaction', 'qrcode'));
        
        // 5. Download File
        return $pdf->download('E-Ticket EventPro - ' . $transaction->event->title . '.pdf');
    }

// 1. Tampilkan Halaman Setting
    public function settings()
    {
        return view('peserta.settings');
    }

    // 2. Proses Update Profil (Nama, Email, Avatar)
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika ada upload foto baru
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (bukan foto default)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save(); // Simpan ke database

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 3. Proses Ganti Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update Password
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}