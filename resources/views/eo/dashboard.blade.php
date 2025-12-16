@extends('layouts.eo.app')

@section('header', 'Dashboard Overview')

@section('content')

    <div class="max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium tracking-wide uppercase">Total Event</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalEvent }}</h3>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-green-500 font-bold mr-1">●</span> Status Aktif & Draft
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium tracking-wide uppercase">Total Peserta</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPeserta }}</h3>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-purple-500 font-bold mr-1">●</span> Dari semua event
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium tracking-wide uppercase">Estimasi Pendapatan</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">
                            Rp {{ number_format($pendapatan, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-emerald-500 font-bold mr-1">●</span> Transaksi Terkonfirmasi
                </div>
            </div>

        </div>

        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden text-white relative">
            
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-white opacity-10 blur-xl"></div>

            <div class="p-8 md:p-10 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                
                <div>
                    <h2 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-blue-100 max-w-xl text-lg">
                        Siap membuat event spektakuler hari ini? Kelola semua jadwal dan peserta Anda dengan mudah dalam satu panel.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('eo.events.create') }}" class="px-6 py-3 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition transform hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Event Baru
                    </a>
                    <a href="{{ route('eo.participants.index') }}" class="px-6 py-3 bg-blue-800 bg-opacity-40 text-white font-bold rounded-xl hover:bg-opacity-60 transition border border-blue-400 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Cek Validasi
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection