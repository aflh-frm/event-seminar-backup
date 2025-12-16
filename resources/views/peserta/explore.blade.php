@extends('layouts.peserta.app')

@section('title', 'Jelajah Event')

@section('content')

    <div class="bg-white border-b border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Temukan Event Favoritmu</h1>
            
            <form action="{{ route('front.explore') }}" method="GET" class="max-w-2xl mx-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition" 
                       placeholder="Cari konser, seminar, atau workshop...">
                
                <div class="absolute left-4 top-3.5 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <button type="submit" class="absolute right-2 top-2 bg-blue-600 text-white px-5 py-1.5 rounded-lg font-bold hover:bg-blue-700 transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        
        @if(request('search'))
            <p class="mb-6 text-gray-600">Menampilkan hasil pencarian untuk: <span class="font-bold text-gray-900">"{{ request('search') }}"</span></p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($events as $event)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300 group flex flex-col h-full">
                <div class="relative h-40 overflow-hidden bg-gray-200 flex-shrink-0">
                    @if($event->banner)
                        <img src="{{ asset('storage/'.$event->banner) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold bg-gray-100">No Image</div>
                    @endif
                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-md px-2 py-1 rounded-md text-[10px] font-bold text-blue-600 uppercase tracking-wide shadow-sm">
                        {{ $event->category->name }}
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2 font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                    </div>
                    
                    <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-tight group-hover:text-blue-600 transition">
                        {{ $event->title }}
                    </h3>
                    
                    <div class="pt-4 border-t border-gray-50 mt-auto flex items-center justify-between">
                        <span class="font-extrabold text-gray-900 text-lg">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('front.details', $event->id) }}" class="text-blue-600 font-bold text-sm hover:underline flex items-center gap-1">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <div class="inline-block p-4 rounded-full bg-gray-100 text-gray-400 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Event tidak ditemukan</h3>
                <p class="text-gray-500 text-sm mt-1">Coba kata kunci lain atau reset pencarian.</p>
                <a href="{{ route('front.explore') }}" class="inline-block mt-4 text-blue-600 font-bold text-sm hover:underline">Lihat Semua Event</a>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>

@endsection