<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Landing Page)
Route::get('/', function () {

    Event::where('status', 'published')
         ->whereDate('event_date', '<', Carbon::now())
         ->update(['status' => 'closed']);

    $events = Event::with('category')
                   ->where('status', 'published')
                   ->latest()
                   ->take(6)
                   ->get();

    return view('welcome', compact('events'));
});

// Halaman Depan & Detail
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/event/{id}', [FrontController::class, 'show'])->name('front.details');


// 2. Logic Pengalihan Dashboard (Redirect setelah Login)
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if (!$user) {
        return redirect('/login');
    }

    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'eo') return redirect()->route('eo.dashboard');
    
    return redirect()->route('peserta.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// GRUP 1: Khusus SUPER ADMIN
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // Approval Event
    Route::get('/events', [\App\Http\Controllers\AdminController::class, 'events'])->name('events.index');
    Route::post('/events/{id}/approve', [\App\Http\Controllers\AdminController::class, 'approveEvent'])->name('events.approve');
    Route::post('/events/{id}/close', [\App\Http\Controllers\AdminController::class, 'closeEvent'])->name('events.close');

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Manajemen User
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    
});


// ====================================================
// GRUP 2: Khusus EO (Event Organizer)
// ====================================================
Route::middleware(['auth', 'role:eo'])->prefix('eo')->name('eo.')->group(function () {
    
    // A. Dashboard EO (Dengan Logika Statistik)
    Route::get('/dashboard', function () {
        $userId = Auth::id();

        // Hitung Total Event buatan sendiri
        $totalEvent = Event::where('user_id', $userId)->count();

        // Hitung Total Peserta
        $totalPeserta = Transaction::whereHas('event', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        // Hitung Pendapatan
        $pendapatan = Transaction::whereHas('event', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'confirmed')
          ->with('event')
          ->get()
          ->sum(function($trx) {
              return $trx->event->price;
          });

        return view('eo.dashboard', compact('totalEvent', 'totalPeserta', 'pendapatan'));
    })->name('dashboard');

    // B. Manajemen Event (CRUD)
    Route::resource('events', EventController::class);

    // C. Manajemen Peserta (Validasi)
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::post('/participants/{id}/approve', [ParticipantController::class, 'approve'])->name('participants.approve');
    Route::post('/participants/{id}/reject', [ParticipantController::class, 'reject'])->name('participants.reject');

    // Profil & Password
    Route::get('/profile', [\App\Http\Controllers\EOProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\EOProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [\App\Http\Controllers\EOProfileController::class, 'updatePassword'])->name('profile.password');

    // Kelola Rekening
    Route::resource('banks', \App\Http\Controllers\EOBankController::class)
        ->names([
            'index' => 'banks.index',
            'store' => 'banks.store',
            'destroy' => 'banks.destroy',
        ])
        ->only(['index', 'store', 'destroy']);
});


// ====================================================
// GRUP 3: Khusus PESERTA (User)
// ====================================================
Route::middleware(['auth', 'role:user'])->prefix('peserta')->name('peserta.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\ParticipantController::class, 'dashboard'])->name('dashboard');

    // Tiket Saya
    Route::get('/my-tickets', [\App\Http\Controllers\ParticipantController::class, 'tickets'])->name('tickets');

    // Checkout
    Route::get('/checkout/{id}', [\App\Http\Controllers\ParticipantController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{id}', [\App\Http\Controllers\ParticipantController::class, 'store'])->name('store');

    // Cetak E-Tiket
    Route::get('/ticket/download/{id}', [ParticipantController::class, 'downloadTicket'])
        ->name('ticket.download');
    
    });

    // Halaman Jelajah / Pencarian Event
    Route::get('/explore', [FrontController::class, 'explore'])->name('front.explore');


// ====================================================
// PROFILE ROUTES (Bawaan Laravel Breeze)
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';