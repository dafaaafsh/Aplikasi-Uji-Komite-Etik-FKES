@php
    if (!empty(Auth::user()->role)) {
      if (Auth::user()->role == 'Peneliti'){
        header("Location: /peneliti/dashboard");
      }
      if (Auth::user()->role == 'Admin'){
        header("Location: /admin/dashboard");
      }
      if (Auth::user()->role == 'Kepk'){
        header("Location: /kepk/dashboard");
      }
      if (Auth::user()->role == 'Penguji'){
        header("Location: /penguji/dashboard");
      }
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Uji komite etik | Landing Page</title>
    <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">

    <script>
      function toggle(id) {
          document.getElementById(id).classList.toggle("hidden");
        }
        
    </script>
</head>
<body>

    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
          <nav id='nav' class="flex fixed w-full items-center transition-all duration-200 justify-between p-6 md:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
              <a href="#" class="-m-1.5 p-1.5">
                <img class="h-15 w-auto" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="">
              </a>
            </div>
            <div id="navTog" class="flex lg:hidden">
              <button type="button" class="sideNav" onclick="openNav()" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
              </button>
            </div>
            <div id="link" class="hidden text-md justify-center lg:flex lg:gap-x-12 w-100 text-gray-900">
              <a href="#penelitian" class=" font-semibold hover:text-blue-500">Penelitian</a>
              <a href="#alurLayanan" class=" font-semibold hover:text-blue-500">Alur Layanan</a>
              <a href="#kontak" class=" font-semibold hover:text-blue-500">Kontak</a>
            </div>
            <div id="signin" class="hidden lg:flex lg:flex-1 lg:justify-end text-gray-900">
              <a href="signin" class="text-lg font-bold hover:text-blue-500">
                Daftar Akun <span aria-hidden="true">&rarr;</span>
            </a>
            </div>
          </nav>
          <!-- Mobile menu, show/hide based on menu open state. -->
          <div id="navMob" class="lg:hidden hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
              <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                  <img class="h-15 w-auto" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="">
                </a>
                <button type="button" onclick="closeNav()" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                  <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                  <div class="space-y-2 py-6">
                    <a href="#penelitian" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-200">Penelitian</a>
                    <a href="#alurLayanan" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-200">Alur layanan</a>
                    <a href="#kontak" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-200">Kontak</a>
                  </div>
                  <div class="py-6">
                    <a href="login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-200">Masuk akun</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>
      
        <div class="relative isolate px-6 pt-14 lg:px-8">
          <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
          <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-20">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <img class="h-50 w-auto" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="">
            </div>
            <div class="text-center">
              <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-6xl">Aplikasi layanan komisi etik penelitian kesehatan</h1>
              <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">Fakultas Kesehatan Universitas Nurul Jadid Paiton</p>
              <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="signin" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Daftar Sekarang</a>
                <a href="login" class="text-sm/6 font-semibold text-gray-900 hover:text-blue-900">Masuk Akun <span aria-hidden="true">→</span></a>
              </div>
            </div>
          </div>
          <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
        </div>
      </div>
      
      {{-- Content Section --}}
      <div id="penelitian" class="scroll-mt-24 bg-white py-10 sm:py-10">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto max-w-2xl lg:mx-0">
            <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">Penelitian kami</h2>
            <p class="mt-2 text-lg/8 text-gray-600">Kumpulan hasil penelitian yang telah melalui proses uji etik oleh Komite Etik Fakultas Kesehatan Universitas Nurul Jadid.</p>
          </div>
          <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-6 border-t border-gray-600 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">

            @foreach ($data->take(9) as $item)
            
            <article class="flex max-w-xl flex-col items-start justify-between bg-gradient-to-br from-blue-100 to-yellow-100 p-8 rounded-3xl">
              <div class="flex items-center gap-x-4 text-xs">
                <time datetime="2020-03-16" class="text-gray-500">{{ $item->tanggal_pengajuan }}</time>
                <a href="login" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{ $item->peneliti->status_peneliti }}</a>
              </div>
              <div class="group relative">
                <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                  <a href="login">
                    <span class="absolute inset-0"></span>
                    {{ $item->judul }}
                  </a>
                </h3>
                <p class="mt-5  text-sm/6 text-gray-600 group-hover:text-gray-400">
                  Diterima pada tanggal {{ \Carbon\Carbon::parse($item->putusan->created_at)->translatedFormat('d F Y') }}, 
                  penelitian dengan jenis <strong>{{ $item->jenis_penelitian }}</strong> dan subjek <strong>{{ $item->subjek_penelitian }}</strong> 
                  ini telah dinyatakan selesai melalui proses uji etik pada 
                  <strong>Layanan Komisi Etik Penelitian Kesehatan Universitas Nurul Jadid Paiton</strong>.
                </p>
                
              </div>
              <div class="relative mt-8 flex items-center gap-x-4">
                <img src="{{ asset("storage/". $item->peneliti->avatar_path )}}" alt="Profil" class="size-10 rounded-full bg-gray-50">
                <div class="text-sm/6">
                  <p class="font-semibold text-gray-900">
                    <a href="login">
                      <span class="absolute inset-0"></span>
                      {{ $item->peneliti->name }}
                    </a>
                  </p>
                  <p class="text-gray-600">{{ $item->peneliti->email }}</p>
                </div>
              </div>
            </article>

            @endforeach
            
          </div>
          <h1 class="text-right mr-5 mt-5">
              <a href="login" class="text-md/6 font-semibold text-gray-900 text-center">Tampilkan lebih banyak <span aria-hidden="true">→</span></a>
          </h1>
        </div>
      </div>

      {{-- Alur Section --}}
      <section id="alurLayanan" class="scroll-mt-24 bg-white py-10 lg:py-10">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto max-w-2xl lg:mx-0">
            <h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Alur Layanan Uji Etik</h2>
            <p class="mt-2 text-lg text-gray-600">Ikuti tahapan berikut untuk memulai layanan uji etik penelitian secara mudah dan sistematis.</p>
          </div>
      
          <div class="py-12 px-10 mt-12 border-t border-gray-300 space-y-10">
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">1. Buat Akun / Masuk</h3>
              <p class="mt-2 text-gray-700 text-justify">Sebelum memulai layanan, Anda harus memiliki akun.</p>
              <ul class="list-disc ml-6 text-gray-700">
                <li><a href="signin" class="text-blue-700 hover:underline">Buat akun sekarang</a> menggunakan email aktif dan password.</li>
                <li>Sudah punya akun? <a href="login" class="text-blue-700 hover:underline">Login di sini</a>.</li>
              </ul>
            </div>
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">2. Lengkapi Profil Peneliti</h3>
              <p class="mt-2 text-gray-700 text-justify">Setelah login, lengkapi data diri Anda seperti nomor HP, status peneliti, institusi asal, dan informasi pendukung lainnya melalui menu Profil.</p>
            </div>
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">3. Permohonan Nomor Protokol & Transaksi</h3>
              <p class="mt-2 text-gray-700 text-justify">Ajukan permohonan nomor protokol dan lakukan pembayaran jasa layanan. Data yang dibutuhkan:</p>
              <ul class="list-decimal ml-8 text-gray-700">
                <li>Judul Penelitian</li>
                <li>Jenis & Subjek Penelitian</li>
                <li>Jenis Pengajuan</li>
                <li>Tanggung Jawab Etik & Pernyataan Konflik</li>
              </ul>
            </div>

            <div>
              <h3 class="text-xl font-semibold text-gray-800">4. Transaksi Jasa Uji Komisi Etik Penelitian Kesehatan</h3>
              <p class="mt-2 text-gray-700 text-justify">
                Setelah permohonan nomor protokol diajukan, Anda akan menerima informasi pembayaran melalui virtual account atau QR code pada menu detail. 
                Silakan lakukan pembayaran ke rekening resmi yang tersedia, lalu unggah bukti pembayaran pada sistem.
              </p>
            </div>
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">5. Ajukan Penelitian</h3>
              <p class="mt-2 text-gray-700 text-justify">Setelah mendapatkan nomor protokol, isi form pengajuan penelitian dan unggah dokumen berikut:</p>
              <ul class="list-disc ml-8 text-gray-700">
                <li>Surat Permohonan & Surat Institusi</li>
                <li>Protokol Etik Penelitian</li>
                <li>Informed Consent & Proposal + Instrumen</li>
                <li>Sertifikat GCP (jika ada)</li>
                <li>CV & Daftar Tim Peneliti</li>
                <li>Surat Pernyataan Komitmen Etik</li>
              </ul>
            </div>
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">6. Tunggu Review Tim KEPK</h3>
              <p class="mt-2 text-gray-700 text-justify">Tim KEPK akan menelaah kelengkapan dan substansi penelitian Anda. Pantau progresnya melalui dasbor Anda.</p>
            </div>
      
            <div>
              <h3 class="text-xl font-semibold text-gray-800">7. Lihat Hasil Review & Keputusan</h3>
              <p class="mt-2 text-gray-700 text-justify">Hasil telaah dan keputusan akhir dapat dilihat pada halaman <strong>Penelitian Saya</strong>. Anda bisa mengunduh surat keputusan dan menindaklanjuti hasil uji etik sesuai arahan.</p>
            </div>
      
            <div class="text-center pt-8">
              <p class="text-sm text-gray-500 italic">Mudah, transparan, dan aman bersama KEPK Universitas Nurul Jadid</p>
            </div>
          </div>
        </div>
      </section>
      

      {{-- Kontak Section --}}
          <section id="kontak" class="scroll-mt-24 bg-white py-10 sm:py-3 mb-10">
            <div class="max-w-6xl mx-auto px-6 lg:px-8">
              <h2 class="text-4xl font-bold text-center text-gray-900 mb-4">Kontak Kami</h2>
              <p class="text-center text-gray-600 mb-12 text-lg">
                jika anda mendapatkan kendala atau kesusahan dalam melakukan layanan uji komite etik fakultas kesehatan universitas nurul jadid, anda dapat menghubungi kontak yang kami sediakan.
              </p>
          
              <div class="grid gap-8 md:grid-cols-3">
                <!-- Telepon -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 text-center">
                  <div class="flex items-center justify-center mb-4">
                    <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                          </svg>
                          
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 5h2l3.6 7.59-1.35 2.44A2 2 0 008 18h10v-2H8.42a.5.5 0 01-.45-.28L9.1 14h6.45a2 2 0 001.8-1.1l3.24-6.14A1 1 0 0019.76 5H5.21l-.94-2H1v2h2z"/>
                      </svg>
                    </div>
                  </div>
                  <h4 class="text-xl font-semibold text-gray-800 mb-2">Telepon</h4>
                  <p class="text-gray-600 text-lg">+62 8## #### ####</p>
                </div>
          
                <!-- Email -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 text-center">
                  <div class="flex items-center justify-center mb-4">
                    <div class="bg-green-100 text-green-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                          </svg>
                          
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 12H8m0 0l4 4m-4-4l4-4"/>
                      </svg>
                    </div>
                  </div>
                  <h4 class="text-xl font-semibold text-gray-800 mb-2">Email</h4>
                  <p class="text-gray-600 text-lg">email@saya.com</p>
                </div>
          
                <!-- Alamat -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 text-center">
                  <div class="flex items-center justify-center mb-4">
                    <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                          </svg>
                          
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.657 16.657L13.414 12l4.243-4.243M6.343 7.343L10.586 12 6.343 16.243"/>
                      </svg>
                    </div>
                  </div>
                  <h4 class="text-xl font-semibold text-gray-800 mb-2">Alamat</h4>
                  <p class="text-gray-600 text-md">Jl. PP Nurul Jadid, Dusun Tj. Lor, Karanganyar, Kec. Paiton, Kabupaten Probolinggo, Jawa Timur 67291</p>
                </div>
              </div>
            </div>
          </section>
          
          <footer class="bg-gray-900 text-gray-300 py-8">
            <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
              <p class="text-sm text-center md:text-left">
                &copy; 2025 <span class="text-white font-semibold">FKES</span>. Universitas Nurul Jadid.
              </p>
              
              <p class="text-sm text-center md:text-right mt-4 md:mt-0">
                Dirancang & Dibangun oleh 
                <a href="#" class="text-blue-400 hover:underline">
                  Hamada
                </a>
              </p>
            </div>
          </footer>

        </div>
      </div>
      <script>
        window.addEventListener('scroll', function () {
          const navbar = document.getElementById('nav');
          const link =document.getElementById('link');
          const signin = document.getElementById('signin');
          const toggleNav = document.getElementById('navTog');
          const sideNav = document.getElementById('sideNav');
          if (window.scrollY > 50) {
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-blue-950', 'shadow-md', 'text-white');
            link.classList.add('text-white');
            signin.classList.add('text-white');
            sideNav.classList.add('text-white');
          } else {
            navbar.classList.remove('bg-blue-950', 'shadow-md', 'text-white');
            navbar.classList.add('bg-transparent');
            link.classList.remove('text-white');
            signin.classList.remove('text-white');
            sideNav.classList.remove('text-white');
          }
        });

        function openNav(){
          const navbar = document.getElementById('navMob');

          navbar.classList.add('block')
          navbar.classList.remove('hidden')
        }

        function closeNav(){
          const navbar = document.getElementById('navMob');

          navbar.classList.remove('block')
          navbar.classList.add('hidden')
        }
      </script>
</body>
</html>