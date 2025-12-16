<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $event->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased py-10">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Selesaikan Pendaftaran</h1>
            <p class="text-gray-500 mt-2">Upload bukti pembayaran untuk mengamankan tiketmu.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">{{ $event->title }}</h2>
                <div class="flex gap-4 mt-2 text-sm text-gray-600">
                    <span>📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                    <span>📍 {{ $event->location }}</span>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-8 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <p class="text-sm text-blue-600 mb-1 font-bold uppercase">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mb-4">
                        {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                    </p>

                    @if($event->price > 0)
                        <div class="border-t border-blue-200 pt-4 mt-4">
                            <p class="text-sm font-bold text-gray-700 mb-2">Silakan Transfer ke salah satu rekening EO:</p>
                            <div class="space-y-2">
                                @forelse($banks as $bank)
                                    <div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-blue-100 shadow-sm">
                                        @if($bank->logo)
                                            <img src="{{ asset('storage/'.$bank->logo) }}" class="w-10 h-10 object-contain">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold">Bank</div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $bank->bank_name }} - {{ $bank->account_number }}</p>
                                            <p class="text-xs text-gray-500">A.n {{ $bank->account_holder }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-red-500 text-sm">EO belum memasukkan nomor rekening. Hubungi panitia.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>

                <form action="{{ route('peserta.store', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @if($event->price > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Transfer ke Bank Mana?</label>
                            <select name="bank_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Pilih Bank Tujuan --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }} ({{ $bank->account_number }})</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="bank_id" value="0">
                    @endif

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $event->price > 0 ? 'Upload Bukti Transfer' : 'Upload Kartu Identitas / Bukti Diri' }}
                        </label>
                        <input type="file" name="payment_proof" class="w-full p-2 border border-gray-300 rounded-lg text-sm" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ url('/') }}" class="w-1/3 py-3 text-center border border-gray-300 rounded-xl font-bold text-gray-600 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="w-2/3 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                            {{ $event->price > 0 ? 'Kirim Bukti Bayar' : 'Daftar Sekarang' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>