<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Uji komite etik | {{ $title ?? 'Laravel App' }}</title>
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">
  @vite('resources/css/app.css')
  <style>
    body {
      background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%);
    }
    .glass {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(8px);
      border: 1px solid #bfdbfe;
    }
    .shadow-2xl {
      box-shadow: 0 8px 32px 0 rgba(59,130,246,0.15);
    }
    .drop-shadow-lg {
      filter: drop-shadow(0 4px 16px rgba(59,130,246,0.15));
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

<a href="/" class="fixed top-4 left-4 z-30 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-xs sm:text-sm font-semibold shadow hover:bg-blue-200 transition flex items-center gap-2">
  <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
  Halaman Utama
</a>
  <div class="glass shadow-2xl rounded-2xl w-full max-w-md p-6 relative overflow-hidden border border-blue-100">
    <!-- Konten form dan lainnya -->
    <div class="flex flex-col items-center mb-4">
      <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="UNUJA" class="w-14 h-14 mb-2 drop-shadow-lg">
      <h2 class="text-xl font-extrabold text-blue-700 mb-1 tracking-tight">Masuk ke Akun Peneliti</h2>
      <p class="text-xs text-gray-500 mb-2">Silakan login untuk melanjutkan</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 flex items-start gap-2 px-4 py-2 bg-red-50 border border-red-400 rounded-lg text-red-700 text-sm shadow-sm">
        <svg class="w-5 h-5 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
        </svg>
        <div>
          @foreach ($errors->all() as $item)
            <div>{{ $item }}</div>
          @endforeach
        </div>
      </div>
    @endif
    @if (session('success'))
      <div id="modalSuccess" class="fixed flex inset-0 bg-black/70 bg-opacity-50 z-50 justify-center items-center">
        <div class="bg-green-100 border border-green-800 rounded-lg shadow-lg w-full max-w-md p-6 h-fit max-h-md">
          <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <strong>Berhasil!</strong>
            <p class="text-sm mt-2">{{ session('success') }}</p>
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="tutupModalSuccess()" class="px-4 py-2 rounded bg-green-700 hover:bg-green-800 text-white font-semibold">Tutup</button>
          </div>
        </div>
      </div>
    @endif
      @if (session('status'))
        <div class="mb-4 flex items-start gap-2 px-4 py-2 bg-blue-50 border border-blue-400 rounded-lg text-blue-700 text-sm shadow-sm">
          <svg class="w-5 h-5 mt-0.5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
          </svg>
          <div>{{ session('status') }}</div>
        </div>
      @endif

    <form class="space-y-6" action="" method="POST">
      @csrf
      <div>
        <label for="email" class="block text-sm font-semibold text-blue-700">Alamat Email</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email Anda"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400">
        </div>
      </div>
      <div>
        <label for="password" class="block text-sm font-semibold text-blue-700">Password</label>
        <div class="mt-2 relative">
          <input type="password" name="password" id="password" placeholder="Masukkan password Anda"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400 pr-10">
          <button type="button" tabindex="-1" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
            <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </button>
        </div>
      </div>
  <script>
    function togglePassword(fieldId, btn) {
      const input = document.getElementById(fieldId);
      const icon = btn.querySelector('svg');
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.362-2.568A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.306M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />';
      } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
      }
    }
  </script>
      <div>
        <button type="submit"
          class="flex w-full justify-center rounded-lg bg-gradient-to-r from-blue-600 to-blue-400 px-3 py-2 text-sm font-bold text-white shadow hover:from-blue-700 hover:to-blue-500 transition">
          Masuk
        </button>
      </div>
    </form>
    <div class="flex justify-end mt-2">
      <a href="/forgot-password" class="text-xs text-blue-600 hover:underline font-semibold">Lupa password?</a>
    </div>
    <p class="mt-6 text-center text-sm text-gray-500">
      Belum punya akun?
      <a href="/signin" class="font-semibold text-blue-600 hover:text-blue-500">Daftar sekarang</a>
    </p>
  </div>
  <script>
    function tutupModalSuccess() {
      const modal = document.getElementById('modalSuccess');
      if (modal) modal.classList.add('hidden');
    }
  </script>
</body>
</html>
