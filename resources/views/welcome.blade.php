<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventPro - Platform Event Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-gray-50 flex flex-col min-h-screen">
    
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="bg-blue-600 text-white p-2 rounded-xl font-bold text-xl group-hover:scale-110 transition duration-200">EP</div>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">EventPro</span>
                </a>
                
                <div class="flex items-center gap-3 md:gap-6">
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role == 'user')
                                <a href="{{ route('peserta.dashboard') }}" class="font-bold text-slate-600 hover:text-blue-600">Dashboard</a>
                            @elseif(Auth::user()->role == 'eo')
                                <a href="{{ route('eo.dashboard') }}" class="font-bold text-slate-600 hover:text-blue-600">Dashboard EO</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="font-bold text-slate-600 hover:text-blue-600">Admin Panel</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-blue-600 transition px-4 py-2">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-600 transition shadow-lg hover:shadow-blue-500/30">Daftar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-slate-900 overflow-hidden">
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-purple-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 py-24 sm:py-32 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-300 text-sm font-bold mb-6">
                🚀 Platform Event #1 di Indonesia
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                Jelajahi Event Seru <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Di Sekitarmu</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                Temukan seminar, workshop, konser, dan pameran terbaik. Tingkatkan skill dan perluas jaringanmu bersama EventPro.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.explore') }}" class="bg-blue-600 text-white px-8 py-3.5 rounded-full font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/25">
                    Mulai Jelajah
                </a>
                <a href="#event-terbaru" class="bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-3.5 rounded-full font-bold text-lg hover:bg-white/20 transition">
                    Lihat Terbaru
                </a>
            </div>
        </div>
    </div>

    <main id="event-terbaru" class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Event Terbaru</h2>
                <p class="text-slate-500 mt-2">Jangan lewatkan kesempatan emas minggu ini.</p>
            </div>
            <a href="{{ route('front.explore') }}" class="hidden md:flex items-center gap-1 text-blue-600 font-bold hover:underline">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
            <div class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                
                <div class="relative h-56 overflow-hidden">
                    @if($event->banner)
                        <img src="{{ asset('storage/'.$event->banner) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-medium">
                            No Image
                        </div>
                    @endif
                    
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur shadow-sm px-3 py-1 rounded-lg text-xs font-bold text-slate-900 uppercase tracking-wide">
                        {{ $event->category->name ?? 'Umum' }}
                    </div>

                    <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur text-white px-3 py-1 rounded-lg text-xs font-bold shadow-lg">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-slate-900 mb-2 line-clamp-2 leading-tight group-hover:text-blue-600 transition">
                        {{ $event->title }}
                    </h3>
                    
                    <p class="text-slate-500 text-sm line-clamp-2 mb-6 flex-grow">
                        {{ Str::limit($event->description, 100) }}
                    </p>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-400 font-bold uppercase">Harga Tiket</span>
                            <span class="text-lg font-extrabold text-blue-600">
                                {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="{{ route('front.details', $event->id) }}" class="bg-slate-900 text-white p-2.5 rounded-xl hover:bg-blue-600 transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="text-4xl mb-4">📅</div>
                <h3 class="text-lg font-bold text-slate-900">Belum ada event tersedia</h3>
                <p class="text-slate-500">Nantikan update event menarik selanjutnya!</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('front.explore') }}" class="inline-block bg-white border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl hover:bg-slate-50 transition w-full">
                Lihat Semua Event
            </a>
        </div>

    </main>

    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-blue-600 text-white p-1.5 rounded-lg font-bold">EP</div>
                        <span class="text-xl font-bold text-white">EventPro</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Platform manajemen event terbaik untuk mempublikasikan dan menemukan event seru di sekitarmu. Mudah, Cepat, dan Aman.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="{{ route('front.explore') }}" class="hover:text-blue-400 transition">Jelajah Event</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">Masuk / Daftar</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <span>📧</span> support@eventpro.id
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📱</span> +62 812 3456 7890
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} EventPro Indonesia. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>