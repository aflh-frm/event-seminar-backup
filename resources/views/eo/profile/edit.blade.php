@extends('layouts.eo.app')

@section('header', 'Pengaturan Akun')

@section('content')

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Edit Profil</h3>
            </div>

            <form action="{{ route('eo.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-50 mb-3 shadow-sm">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=EBF4FF&color=3B82F6" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <label class="cursor-pointer bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                        <span>Ganti Foto</span>
                        <input type="file" name="avatar" class="hidden">
                    </label>
                    @error('avatar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition shadow-md">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 h-fit">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <div class="bg-yellow-100 p-2 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Ganti Password</h3>
            </div>

            <form action="{{ route('eo.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" class="w-full rounded-lg border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 shadow-sm">
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 shadow-sm">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 shadow-sm">
                </div>

                <button type="submit" class="w-full bg-slate-800 text-white font-bold py-2.5 rounded-lg hover:bg-slate-900 transition shadow-md">
                    Update Password
                </button>
            </form>
        </div>

    </div>
</div>

@endsection