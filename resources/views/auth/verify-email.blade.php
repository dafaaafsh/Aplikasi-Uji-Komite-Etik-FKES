<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 max-w-lg w-full space-y-6">
            <div class="text-center">
                <svg class="mx-auto mb-4 w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5L21 7.5m0 0l-4.5-3m4.5 3v9a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 16.5v-9A2.25 2.25 0 015.25 5.25H18a2.25 2.25 0 012.25 2.25z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Konfirmasi Email Anda</h1>
                <p class="text-gray-600 mt-2">
                    Kami telah mengirimkan tautan verifikasi ke email Anda. Silakan klik tautan tersebut untuk mengaktifkan akun.
                </p>
            </div>
    
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 text-green-700 border border-green-300 rounded p-3 text-sm text-center">
                    Tautan verifikasi baru berhasil dikirim!
                </div>
            @endif
    
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
    
            <form method="get" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit"
                    class="mt-4 text-sm text-gray-500 hover:underline hover:text-gray-700">
                    Keluar dari akun
                </button>
            </form>
        </div>
    </div>
</x-Layout>