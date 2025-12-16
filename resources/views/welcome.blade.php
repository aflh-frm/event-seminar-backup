<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventPro - Temukan Event Seru</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <nav class="bg-white border-b border-gray-100 fixed w-full z-50 top-0 start-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <div class="bg-blue-600 text-white p-2 rounded-lg font-bold text-xl">EP</div>
                        <span class="text-2xl font-bold text-gray-900 tracking-tight">EventPro</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-bold transition shadow-lg shadow-blue-500/30">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-gradient-to-br from-blue-900 to-indigo-900 pt-40 pb-24 text-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-10">
                Temukan & Ikuti <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Event Impianmu</span>
            </h1>
            
            <form action="{{ url('/login') }}" method="GET" class="max-w-xl mx-auto bg-white p-2 rounded-full shadow-2xl flex relative z-20">
                <input placeholder="Cari event apa hari ini?" class="flex-1 rounded-full border-none focus:ring-0 px-6 py-3 text-gray-700 placeholder-gray-400 outline-none">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold transition">
                    Cari
                </button>
            </form>

        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Event Terbaru</h2>
                <p class="text-gray-500 mt-2">Jangan sampai ketinggalan acara menarik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                @forelse($events as $event)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 group">
                    <div class="relative h-48 overflow-hidden bg-gray-200">
                        @if($event->banner)
                            <img src="{{ asset('storage/'.$event->banner) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-600 shadow-sm">
                            {{ $event->category->name ?? 'Umum' }}
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs text-gray-500 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-blue-600 transition">
                            {{ $event->title }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                            {{ $event->description }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold">Harga Tiket</span>
                                <div class="text-lg font-bold text-blue-600">
                                    {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    <br>

<footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-blue-600 text-white p-1.5 rounded-lg font-bold text-lg">EP</div>
                        <span class="text-2xl font-bold text-white tracking-tight">EventPro</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Platform manajemen event terpercaya untuk menemukan dan mengikuti berbagai seminar, workshop, dan hiburan di Indonesia.
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Akses Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">Masuk / Daftar</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Kategori Populer</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Teknologi & IT</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Bisnis & Marketing</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Desain Kreatif</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Pengembangan Diri</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>support@eventpro.id</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jakarta Selatan, Indonesia</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500 text-center md:text-left">
                    &copy; {{ date('Y') }} EventPro Management System. All rights reserved.
                </p>
                
                <div class="flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-slate-400 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>