<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - EventPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg font-bold">EP</div>
                    <span class="text-xl font-bold text-slate-900">EventPro</span>
                </a>
                
                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role == 'user')
                            <a href="{{ route('front.explore') }}" class="text-slate-600 font-bold hover:text-blue-600 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="font-bold text-slate-600 hover:text-blue-600">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-slate-900 text-white px-5 py-2.5 rounded-full text-sm font-bold hover:bg-slate-800">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative h-[400px] bg-slate-900 overflow-hidden">
        @if($event->banner)
            <img src="{{ asset('storage/'.$event->banner) }}" class="w-full h-full object-cover opacity-60">
        @else
            <div class="w-full h-full flex items-center justify-center bg-slate-800 text-slate-600">
                <span class="text-2xl font-bold">No Banner Available</span>
            </div>
        @endif
        
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-slate-900 to-transparent pt-32 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                    {{ $event->category->name ?? 'Event' }}
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-2 leading-tight drop-shadow-lg">
                    {{ $event->title }}
                </h1>
                <p class="text-slate-200 text-lg flex items-center gap-2 drop-shadow-md">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $event->location }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2">
                
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Tentang Event Ini</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 flex items-center gap-6">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex-shrink-0 overflow-hidden border-2 border-slate-200">
                        @if($event->user->avatar)
                            <img src="{{ asset('storage/'.$event->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($event->user->name) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-wider mb-1">Diselenggarakan Oleh</p>
                        <h3 class="text-xl font-bold text-slate-900">{{ $event->user->name }}</h3>
                        <p class="text-sm text-slate-500">Verified Event Organizer</p>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                            <p class="text-slate-500 text-sm font-medium mb-1">Harga Tiket Masuk</p>
                            <div class="text-3xl font-extrabold text-blue-600">
                                {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-blue-50 text-blue-600 p-3 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Tanggal Pelaksanaan</p>
                                    <p class="text-slate-600">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="bg-blue-50 text-blue-600 p-3 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Waktu Acara</p>
                                    <p class="text-slate-600">09:00 WIB - Selesai</p>
                                </div>
                            </div>

                            <hr class="border-slate-100 my-4">

                            @auth
                                @if(Auth::user()->role == 'user')
                                    
                                    {{-- LOGIKA STATUS TRANSAKSI --}}
                                    @if($existingTransaction)
                                    
                                        @if($existingTransaction->status == 'pending')
                                            <button disabled class="block w-full bg-yellow-100 text-yellow-700 border border-yellow-200 text-center font-bold py-4 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Pendaftaran Pending
                                            </button>
                                            <p class="text-xs text-center text-yellow-600 mt-2 font-medium">
                                                Menunggu konfirmasi pembayaran dari Admin/EO.
                                            </p>

                                        @elseif($existingTransaction->status == 'confirmed')
                                            <a href="{{ route('peserta.ticket.download', $existingTransaction->id) }}" class="block w-full bg-green-600 text-white text-center font-bold py-4 rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Download E-Tiket (PDF)
                                                </a>
                                                <p class="text-xs text-center text-green-600 mt-2 font-medium">
                                                    Selamat! Pendaftaran diterima. Silakan unduh tiket Anda.
                                                </p>

                                        @elseif($existingTransaction->status == 'rejected')
                                            <div class="bg-red-50 p-3 rounded-lg mb-3 border border-red-100 text-center">
                                                <p class="text-xs text-red-600 font-bold">Pendaftaran sebelumnya ditolak.</p>
                                            </div>
                                            <a href="{{ route('peserta.checkout', $event->id) }}" class="block w-full bg-blue-600 text-white text-center font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                                Daftar Lagi
                                            </a>
                                        @endif

                                    @else
                                        <a href="{{ route('peserta.checkout', $event->id) }}" class="block w-full bg-blue-600 text-white text-center font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 transform hover:-translate-y-1">
                                            Daftar Sekarang
                                        </a>
                                    @endif

                                @else
                                    <button disabled class="block w-full bg-slate-200 text-slate-500 text-center font-bold py-4 rounded-xl cursor-not-allowed">
                                        Anda Login sebagai {{ ucfirst(Auth::user()->role) }}
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full bg-slate-900 text-white text-center font-bold py-4 rounded-xl hover:bg-slate-800 transition">
                                    Login untuk Mendaftar
                                </a>
                            @endauth

                            <p class="text-xs text-center text-slate-400 mt-4">
                                *Pastikan data diri Anda sudah benar sebelum mendaftar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-white border-t border-slate-200 py-10 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} EventPro. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>