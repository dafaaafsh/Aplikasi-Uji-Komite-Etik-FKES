<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Uji komite etik | {{ $title ?? 'Laravel App' }}</title>
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">

  @vite('resources/css/app.css')
</head>
<body class="h-full">
  <div class="relative isolate px-4 sm:px-6 lg:px-8">

    <div class="relative isolate px-6 lg:px-8">
      <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
      
    
    <!-- Link kembali ke halaman utama -->
    <div class="py-6">
      <a href="/" class="text-gray-900 font-semibold flex items-center gap-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Halaman Utama
      </a>
    </div>

    <!-- Logo -->
    <div class="mx-auto max-w-md py-5 text-center">
      <img class="h-35 mx-auto" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="Logo UNUJA">
    </div>

    <!-- Judul -->
    <h2 class="text-center text-2xl font-bold tracking-tight text-gray-900">Masuk ke akun Anda</h2>
    
    <!-- Form -->
    <div class="mt-4 md:mx-auto md:w-100 md:max-w-sm m-14">
      @if ($errors->any())
        <div class=" mb-4 px-4 py-2 opacity-80 bg-red-100 text-red-800 border border-red-800 rounded-xl text-sm ">
          <ul>
            @foreach ($errors->all() as $item)
            <li>{{ $item }}</li>            
            @endforeach
          </ul>
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
      <form class="space-y-6" action="" method="POST">

        @csrf 

        <div>
          <label for="email" class="block text-sm font-medium text-gray-900">Alamat Email</label>
          <div class="mt-2">
            <input type="email" name="email" id="email" value="{{ old('email') }}"
              class="block w-full bg-white rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
          <div class="mt-2">
            <input type="password" name="password" id="password"  value="{{ old('password') }}"
              class="block w-full bg-white rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>
        </div>

        
        <!-- Tombol Masuk -->
        <div>
          <button type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Masuk
          </button>
        </div>
        
      </form>

      <!-- Link daftar -->
      <p class="mt-6 text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="/signin" class="font-semibold text-indigo-600 hover:text-indigo-500">Daftar sekarang</a>
      </p>
    </div>

    
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
      <div class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
  </div>
  </div>
</body>
<script>
  function tutupModalSuccess() {
      const modal = document.getElementById('modalSuccess');
      if (modal) modal.classList.add('hidden');
  }
</script>
</html>
