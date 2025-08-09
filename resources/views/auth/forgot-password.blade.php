<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Uji komite etik | {{ $title ?? 'Lupa Password' }}</title>
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
      <h2 class="text-xl font-extrabold text-blue-700 mb-1 tracking-tight">Lupa Password?</h2>
      <p class="text-xs text-gray-500 mb-2">Masukkan email Anda untuk menerima link reset password.</p>
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
    @if (session('status'))
      <div class="mb-4 flex items-start gap-2 px-4 py-2 bg-blue-50 border border-blue-400 rounded-lg text-blue-700 text-sm shadow-sm">
        <svg class="w-5 h-5 mt-0.5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
        </svg>
        <div>{{ session('status') }}</div>
      </div>
    @endif

    <form class="space-y-6" action="{{ route('password.email') }}" method="POST" onsubmit="return validateForgotEmail()">
      @csrf
      <div>
        <label for="email" class="block text-sm font-semibold text-blue-700">Alamat Email</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email Anda"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400" required autofocus autocomplete="email">
        </div>
        <div id="emailError" class="text-xs text-red-600 mt-1 hidden"></div>
      </div>
      <div>
        <button type="submit"
          class="flex w-full justify-center rounded-lg bg-gradient-to-r from-blue-600 to-blue-400 px-3 py-2 text-sm font-bold text-white shadow hover:from-blue-700 hover:to-blue-500 transition">
          Kirim Link Reset Password
        </button>
      </div>
    </form>
    <script>
      function validateForgotEmail() {
        const email = document.getElementById('email').value.trim();
        const errorDiv = document.getElementById('emailError');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
          errorDiv.textContent = 'Email wajib diisi.';
          errorDiv.classList.remove('hidden');
          return false;
        } else if (!emailPattern.test(email)) {
          errorDiv.textContent = 'Format email tidak valid.';
          errorDiv.classList.remove('hidden');
          return false;
        }
        errorDiv.classList.add('hidden');
        return true;
      }
    </script>
    <div class="flex justify-between mt-2">
      <a href="/login" class="text-xs text-blue-600 hover:underline font-semibold">Kembali ke Login</a>
      <a href="/signin" class="text-xs text-blue-600 hover:underline font-semibold">Daftar Akun</a>
    </div>
  </div>
  <script>
    function tutupModalSuccess() {
      const modal = document.getElementById('modalSuccess');
      if (modal) modal.classList.add('hidden');
    }
  </script>
</body>
</html>
