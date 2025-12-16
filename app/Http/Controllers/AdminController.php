<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Dashboard Admin
    public function index()
    {
        $totalUser = User::where('role', 'user')->count();
        $totalEO = User::where('role', 'eo')->count();
        $totalEvent = Event::count();
        $pendingEvents = Event::where('status', 'draft')->count();

        return view('admin.dashboard', compact('totalUser', 'totalEO', 'totalEvent', 'pendingEvents'));
    }

    // 2. Halaman List Event (Untuk Moderasi)
    public function events()
    {
        // Tampilkan event yang statusnya 'draft' di paling atas
        $events = Event::with('user')->orderByRaw("FIELD(status, 'draft', 'published', 'closed')")->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // 3. Aksi Approve (Publish Event)
    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'published']);
        return redirect()->back()->with('success', 'Event berhasil di-publish!');
    }

    // 4. Aksi Reject (Kembalikan ke Draft / Tutup)
    public function closeEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'closed']); // Atau 'draft'
        return redirect()->back()->with('success', 'Event ditutup/ditolak.');
    }
}