<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    // Halaman Depan (Landing Page)
    public function index()
    {
        $events = Event::with('category')->where('status', 'published')->latest()->take(6)->get();
        return view('welcome', compact('events'));
    }

    // Halaman Detail Event
public function show($id)
    {
        // 1. Ambil data event LENGKAP dengan relasi category & user (EO)
        $event = Event::with(['category', 'user'])->findOrFail($id);

        // 2. Cek apakah user sudah pernah daftar (Logika Status)
        $existingTransaction = null;
        
        if (Auth::check()) {
            $existingTransaction = Transaction::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->latest()
                ->first();
        }
        
        return view('detail', compact('event', 'existingTransaction'));
    }

public function explore(Request $request)
    {
        $query = Event::with('category')->where('status', 'published');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $events = $query->latest()->paginate(12);
        $events->appends($request->all());

        return view('peserta.explore', compact('events'));
    }
    
public function details($id)
    {
        $event = Event::findOrFail($id);

        // Cek apakah user sedang login & apakah sudah pernah daftar event ini
        $existingTransaction = null;
        
        if (Auth::check()) {
            $existingTransaction = Transaction::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->latest() // Ambil yang paling baru (jika pernah daftar berkali-kali)
                ->first();
        }

        // Kirim variable $existingTransaction ke View
        return view('detail', compact('event', 'existingTransaction'));
    }
}