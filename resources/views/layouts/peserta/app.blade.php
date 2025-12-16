<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EventPro')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-8">
                    <a href="/" class="flex items-center gap-2">
                        <div class="bg-blue-600 text-white p-1.5 rounded-lg font-bold">EP</div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">EventPro</span>
                    </a>
                    
                    <div class="hidden md:flex gap-6 text-sm font-medium">
                        <a href="{{ route('front.explore') }}" 
                        class="{{ request()->routeIs('front.explore') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }} transition">
                            Cari Event
                        </a>  

                        <a href="{{ route('peserta.dashboard') }}" class="{{ request()->routeIs('peserta.dashboard') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }} transition">
                            Dashboard
                        </a>

                        <a href="{{ route('peserta.tickets') }}" class="{{ request()->routeIs('peserta.tickets') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }} transition">
                            Tiket Saya
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-blue-500 font-medium">Peserta</div>
                    </div>

                    <a href="{{ route('peserta.settings') }}" title="Pengaturan Akun" class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden border border-gray-300 hover:ring-2 hover:ring-blue-500 transition cursor-pointer block">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="h-full w-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="h-full w-full object-cover">
                        @endif
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition ml-2" title="Keluar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} EventPro Management System.
        </div>
    </footer>

</body>
</html>