<x-guest-layout>
    <div class="pt-4 pb-2">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Selamat Datang! 👋</h1>
            <p class="text-gray-500 mt-2 text-sm">Masuk untuk mengelola event Anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    class="block w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 sm:text-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 sm:text-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline transition" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition duration-200">
                    MASUK SEKARANG
                </button>
            </div>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">
                        Daftar disini
                    </a>
                </p>
            </div>

        </form>
    </div>
</x-guest-layout>