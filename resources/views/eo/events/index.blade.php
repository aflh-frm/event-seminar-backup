@extends('layouts.eo.app')

@section('header', 'Kelola Event Saya')

@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            
            <a href="{{ route('eo.events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center gap-2 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Event
            </a>

            <form action="{{ route('eo.events.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                           placeholder="Cari event...">
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-6">
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 uppercase text-xs font-bold tracking-wider">
                            <th class="p-4 border-b">No</th>
                            <th class="p-4 border-b">Judul Event</th>
                            <th class="p-4 border-b">Kategori</th>
                            <th class="p-4 border-b">Lokasi & Tanggal</th>
                            <th class="p-4 border-b text-center">Status</th>
                            <th class="p-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                        @forelse($events as $key => $event)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="p-4 text-center font-medium">
                                {{ $events->firstItem() + $key }}
                            </td>
                            
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $event->title }}
                                <div class="text-xs text-gray-400 font-normal mt-0.5">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                            </td>
                            
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold">
                                    {{ $event->category->name ?? '-' }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-gray-600">
                                <div class="font-medium">
                                    {{ $event->location }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                </div>
                            </td>
                            
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold border 
                                    {{ $event->status == 'published' ? 'bg-green-50 text-green-600 border-green-200' : 
                                      ($event->status == 'closed' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-gray-50 text-gray-600 border-gray-200') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('eo.events.edit', $event->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('eo.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Data event tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $events->withQueryString()->links() }}
            </div>
            
        </div>
    </div>

@endsection