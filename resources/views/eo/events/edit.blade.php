@extends('layouts.eo.app')

@section('header', 'Edit Event')

@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">

            <form action="{{ route('eo.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Judul Event</label>
                    <input type="text" name="title" value="{{ $event->title }}" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select name="category_id" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $event->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="5" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>{{ $event->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" name="event_date" value="{{ $event->event_date }}" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                        <input type="text" name="location" value="{{ $event->location }}" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Kuota Peserta</label>
                        <input type="number" name="quota" value="{{ $event->quota }}" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Harga Tiket</label>
                        <input type="number" name="price" value="{{ $event->price }}" class="w-full border-gray-300 border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Poster Event</label>
                    
                    @if($event->banner)
                        <div class="mb-3">
                            <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Poster Saat Ini:</span>
                            <div class="mt-1">
                                <img src="{{ asset('storage/'.$event->banner) }}" alt="Poster" class="h-32 w-auto rounded-md border shadow-sm object-cover">
                            </div>
                        </div>
                    @endif

                    <input type="file" name="banner" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border p-2 rounded-lg cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengganti poster.</p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg transition duration-200 shadow-md transform hover:scale-105">
                        Update Event
                    </button>
                    <a href="{{ route('eo.events.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition duration-200 underline">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection