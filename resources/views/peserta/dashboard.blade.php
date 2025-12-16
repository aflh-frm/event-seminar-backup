@extends('layouts.peserta.app')
@section('title', 'Dashboard Peserta')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg mb-10">
        <h1 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-blue-100">Selamat datang kembali di EventPro. Siap mencari pengalaman baru hari ini?</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-bold uppercase mb-1">Total Tiket</div>
            <div class="text-3xl font-extrabold text-gray-800">{{ $totalTickets }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-green-600 text-sm font-bold uppercase mb-1">Tiket Aktif</div>
            <div class="text-3xl font-extrabold text-green-600">{{ $activeTickets }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-yellow-600 text-sm font-bold uppercase mb-1">Menunggu Konfirmasi</div>
            <div class="text-3xl font-extrabold text-yellow-600">{{ $pendingTickets }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Aktivitas Terakhir</h2>
            <a href="{{ route('peserta.tickets') }}" class="text-blue-600 text-sm font-bold hover:underline">Lihat Semua Tiket &rarr;</a>
        </div>
        <div class="p-6">
            @if($recentTickets->count() > 0)
                <ul class="space-y-4">
                    @foreach($recentTickets as $ticket)
                    <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-bold text-gray-800">{{ $ticket->event->title }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $ticket->status == 'confirmed' ? 'bg-green-100 text-green-700' : ($ticket->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada aktivitas.</p>
            @endif
        </div>
    </div>

</div>
@endsection