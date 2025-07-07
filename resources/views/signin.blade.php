
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Daftar Akun Peneliti | UNUJA</title>
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">
  @vite('resources/css/app.css')
</head>
<body class="bg-white">

  <div class="relative isolate px-6 lg:px-8">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
      <div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>

  <!-- Header -->
  <div class="relative isolate px-4 sm:px-6 lg:px-8">
    <!-- Tombol kembali -->
    <div class="py-4">
      <a href="/" class="text-gray-900 font-semibold flex items-center gap-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Halaman Utama
      </a>
    </div>

    <!-- Background -->
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
      <div class="relative left-[calc(50%-11rem)] w-[36rem] sm:w-[72rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-pink-300 to-indigo-300 opacity-30"
        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
      </div>
    </div>

    <!-- Logo -->
    <div class="mx-auto max-w-md py-6 text-center">
      <img class="h-28 mx-auto" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="Logo UNUJA">
    </div>
  </div>



  <!-- Form Section -->
  <section class="px-4 sm:px-6">
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-6 sm:p-10">
      <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Akun Peneliti</h2>
       
      @if (session('error') || $errors->any())
        <div id="modalError" class="fixed flex inset-0 bg-black/70 bg-opacity-50 z-50 justify-center items-center">
          <div class="bg-red-100 border border-red-800 rounded-lg shadow-lg w-full max-w-md p-6 h-fit max-h-md">
          
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <strong>Gagal Mendaftarkan Akun!</strong> 
                <p class="mt-2 text-sm">{{ session('error') }}</p>
                <ul>
                  @foreach ($errors->all() as $item)
                  <li class="text-sm">{{ $item }}</li>            
                  @endforeach
                </ul>
            </div>  
          
            <div class="flex justify-end">
                <button type="button" onclick="tutupModalError()" class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-700 text-white font-semibold">Tutup</button>
            </div>
          
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

      <form action="" method="POST" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}"
            class="w-full border border-gray-400 rounded-lg px-4 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}"
            class="w-full border border-gray-400 rounded-lg px-4 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
          <input type="password" id="password" name="password"  minlength="6"
            class="w-full border border-gray-400 rounded-lg px-4 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
          <input type="password" id="password_confirmation" name="password_confirmation"  minlength="6"
            class="w-full border border-gray-400 rounded-lg px-4 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tombol Submit -->
        <div>
          <button type="submit"
            class="w-full bg-blue-600 text-white font-semibold py-1 px-4 rounded-lg hover:bg-blue-700 transition">
            Daftar Sekarang
          </button>
        </div>
      </form>

      <!-- Link ke Login -->
      <div class="pt-4 text-center">
        <p class="text-sm ">
          Sudah memiliki akun?<a href="/login" class="text-sm font-semibold text-blue-900 hover:text-blue-950">
            Masuk di sini
          </a>
        </p>
        
      </div>
    </div>
  </section>

  <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
    <div class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
  </div>

</body>

<script>
  function tutupModalError() {
            document.getElementById('modalError').classList.add('hidden');
            document.getElementById('modalError').classList.remove('flex');
        }

  function tutupModalSuccess() {
      const modal = document.getElementById('modalSuccess');
      if (modal) modal.classList.add('hidden');
  }
</script>
</html>
