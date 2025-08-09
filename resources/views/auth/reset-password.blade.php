<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Uji komite etik | {{ $title ?? 'Reset Password' }}</title>
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
  <div class="glass shadow-2xl rounded-2xl w-full max-w-md p-6 relative overflow-hidden border border-blue-100">
    <!-- Konten form dan lainnya -->
    <div class="flex flex-col items-center mb-4">
      <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="UNUJA" class="w-14 h-14 mb-2 drop-shadow-lg">
      <h2 class="text-xl font-extrabold text-blue-700 mb-1 tracking-tight">Reset Password</h2>
      <p class="text-xs text-gray-500 mb-2">Masukkan email dan password baru Anda</p>
    </div>

    @if (session('status'))
      <div class="mb-4 flex items-start gap-2 px-4 py-2 bg-green-50 border border-green-400 rounded-lg text-green-700 text-sm shadow-sm">
        <svg class="w-5 h-5 mt-0.5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
        </svg>
        <div>{{ session('status') }}</div>
      </div>
    @endif
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

    <form class="space-y-6" action="{{ route('password.reset.update') }}" method="POST" onsubmit="return validateResetPassword()">
      @csrf
      <input type="hidden" name="token" value="{{ $token ?? request('token') }}">
      <div>
        <label for="email" class="block text-sm font-semibold text-blue-700">Alamat Email</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" value="{{ old('email') }}"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400" required autofocus placeholder="Masukkan email Anda">
        </div>
      </div>
      <div class="text-xs text-gray-500 mb-2">
        <ul class="list-disc pl-5">
          <li>Password minimal 8 karakter dan kombinasi huruf & angka.</li>
          <li>Jangan gunakan password yang sama dengan akun lain.</li>
          <li>Setelah reset, gunakan password baru untuk login.</li>
        </ul>
      </div>
      <div>
        <label for="password" class="block text-sm font-semibold text-blue-700">Password Baru</label>
        <div class="mt-2 relative">
          <input type="password" name="password" id="password" placeholder="Masukkan password baru Anda"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400 pr-10" required oninput="checkPasswordStrength()">
          <button type="button" tabindex="-1" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
            <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </button>
          <div id="passwordStrength" class="text-xs mt-1 font-semibold"></div>
          <div id="passwordError" class="text-xs text-red-600 mt-1 hidden"></div>
        </div>
      </div>
      <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-blue-700">Konfirmasi Password Baru</label>
        <div class="mt-2 relative">
          <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password baru Anda"
            class="block w-full bg-blue-50 rounded-lg border-2 border-blue-100 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-400 pr-10" required>
          <button type="button" tabindex="-1" onclick="togglePassword('password_confirmation', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
            <svg id="icon-password-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </button>
          <div id="passwordConfirmError" class="text-xs text-red-600 mt-1 hidden"></div>
        </div>
      </div>
    <script>
      function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthDiv = document.getElementById('passwordStrength');
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        let status = '';
        let color = '';
        if (password.length === 0) {
          status = '';
        } else if (strength <= 2) {
          status = 'Password lemah';
          color = 'text-red-600';
        } else if (strength === 3 || strength === 4) {
          status = 'Password sedang';
          color = 'text-yellow-600';
        } else if (strength >= 5) {
          status = 'Password kuat';
          color = 'text-green-600';
        }
        strengthDiv.textContent = status;
        strengthDiv.className = 'text-xs mt-1 font-semibold ' + color;
      }

      function validateResetPassword() {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        const passwordError = document.getElementById('passwordError');
        const passwordConfirmError = document.getElementById('passwordConfirmError');
        let valid = true;
        // Password minimal 8 karakter, kombinasi huruf dan angka
        const passPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=]{8,}$/;
        if (!passPattern.test(password)) {
          passwordError.textContent = 'Password minimal 8 karakter dan kombinasi huruf & angka.';
          passwordError.classList.remove('hidden');
          valid = false;
        } else {
          passwordError.classList.add('hidden');
        }
        if (password !== passwordConfirm) {
          passwordConfirmError.textContent = 'Konfirmasi password tidak sama.';
          passwordConfirmError.classList.remove('hidden');
          valid = false;
        } else {
          passwordConfirmError.classList.add('hidden');
        }
        return valid;
      }
    </script>
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
          Reset Password
        </button>
      </div>
    </form>
    <div class="flex justify-end mt-2">
      <a href="/login" class="text-xs text-blue-600 hover:underline font-semibold">Kembali ke Login</a>
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
