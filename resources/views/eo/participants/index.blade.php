@extends('layouts.eo.app')

@section('header', 'Validasi Peserta')

@section('content')

    <div class="max-w-7xl mx-auto">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Daftar Pendaftar Masuk</h3>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                    Total: {{ $transactions->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                @if($transactions->isEmpty())
                    <div class="p-10 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <p>Belum ada peserta yang mendaftar saat ini.</p>
                    </div>
                @else
                    <table class="w-full table-auto text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 uppercase text-xs font-bold tracking-wider">
                                <th class="p-4 border-b">Nama Peserta</th>
                                <th class="p-4 border-b">Event</th>
                                <th class="p-4 border-b">Tanggal Daftar</th>
                                <th class="p-4 border-b text-center">Bukti Bayar</th>
                                <th class="p-4 border-b text-center">Status</th>
                                <th class="p-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                            @foreach($transactions as $trx)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="p-4 font-semibold text-gray-800">{{ $trx->user->name }}</td>
                                <td class="p-4 text-blue-600">{{ $trx->event->title }}</td>
                                <td class="p-4 text-gray-500">
                                    {{ $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($trx->payment_proof)
                                        <a href="{{ asset('storage/'.$trx->payment_proof) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 text-xs font-bold transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Lihat Foto
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border
                                        {{ $trx->status == 'confirmed' ? 'bg-green-50 text-green-600 border-green-200' : 
                                          ($trx->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border-yellow-200' : 'bg-red-50 text-red-600 border-red-200') }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($trx->status == 'pending')
                                        <div class="flex justify-center items-center gap-2">
                                            
                                            <form action="{{ route('eo.participants.approve', $trx->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="flex items-center bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Terima
                                                </button>
                                            </form>

                                            <form action="{{ route('eo.participants.reject', $trx->id) }}" method="POST" onsubmit="return confirm('Tolak peserta ini?');">
                                                @csrf
                                                <button type="submit" class="flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs font-medium italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>

@endsection