<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // 1. Menampilkan Daftar Event (Hanya milik EO yang sedang login)
    public function index(Request $request)
    {
        $events = Event::where('user_id', Auth::id())->get();

        $search = $request->input('search');
        $events = Event::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                // Jika ada pencarian, cari berdasarkan Judul ATAU Lokasi
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(5); // Tampilkan 5 data per halaman (Pagination)

        return view('eo.events.index', compact('events'));
    }

    // 2. Menampilkan Form Tambah Event
    public function create()
    {
        $categories = Category::all(); // Ambil data kategori untuk dropdown
        return view('eo.events.create', compact('categories'));
    }

    // 3. Menyimpan Data ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'event_date' => 'required|date',
            'quota' => 'required|numeric',
            'price' => 'required|numeric',
            'banner' => 'image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        // Upload Gambar (Jika ada)
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        // Simpan ke Database
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location ?? 'Online', // Default Online jika kosong
            'quota' => $request->quota,
            'price' => $request->price,
            'banner' => $bannerPath,
            'user_id' => Auth::id(), // ID EO yang sedang login
            'category_id' => $request->category_id,
            'status' => 'draft', // Default status draft
        ]);

        return redirect()->route('eo.events.index')->with('success', 'Event berhasil dibuat!');
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        // Keamanan: Cek apakah event ini milik EO yang sedang login?
        if ($event->user_id != Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit event ini');
        }

        $categories = Category::all();
        return view('eo.events.edit', compact('event', 'categories'));
    }

    // 5. Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Keamanan
        if ($event->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'event_date' => 'required|date',
            'quota' => 'required|numeric',
            'price' => 'required|numeric',
            'banner' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah user upload gambar baru?
        if ($request->hasFile('banner')) {
            // Hapus gambar lama jika ada
            if ($event->banner) {
                Storage::disk('public')->delete($event->banner);
            }
            // Simpan gambar baru
            $bannerPath = $request->file('banner')->store('banners', 'public');
            $event->banner = $bannerPath;
        }

        // Update data text
        $event->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'quota' => $request->quota,
            'price' => $request->price,
            // Status tidak diupdate disini, karena itu hak Admin
        ]);

        return redirect()->route('eo.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    // 6. Hapus Event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Keamanan
        if ($event->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus gambarnya dulu agar server tidak penuh sampah
        if ($event->banner) {
            Storage::disk('public')->delete($event->banner);
        }

        $event->delete();

        return redirect()->route('eo.events.index')->with('success', 'Event berhasil dihapus!');
    }

}