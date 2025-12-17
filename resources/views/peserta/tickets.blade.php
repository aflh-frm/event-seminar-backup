@extends('layouts.peserta.app')
@section('title', 'Tiket Saya')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tiket Saya</h1>
        <a href="{{ route('front.explore') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
            + Cari Event
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($transactions as $trans)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition">
            <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500">ID: #{{ $trans->id }}</span>
                @if($trans->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold">Menunggu</span>
                @elseif($trans->status == 'confirmed')
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Aktif</span>
                @else
                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-bold">Ditolak</span>
                @endif
            </div>
            <div class="p-6 flex-1">
                <h3 class="font-bold text-lg mb-2">{{ $trans->event->title }}</h3>
                <p class="text-gray-500 text-sm mb-4">📅 {{ \Carbon\Carbon::parse($trans->event->event_date)->format('d M Y') }}</p>
                <p class="font-bold text-xl">{{ $trans->total_price == 0 ? 'GRATIS' : 'Rp ' . number_format($trans->total_price, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-100">
                <a href="{{ route('front.details', $trans->event_id) }}" class="block text-center text-blue-600 font-bold text-sm hover:underline">Lihat Detail Event</a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500">Belum ada riwayat tiket.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection