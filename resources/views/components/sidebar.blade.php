@php
  use App\Models\User;

  $profil = Auth::user();
@endphp

@if ($profil->role == 'Peneliti')
{{-- Sidebar Peneliti --}}
<aside id="sidebar" class="w-full md:w-50 bg-gray-200 pt-16 h-auto md:h-screen shadow fixed md:max-h-full md:block hidden">
  <div class="flex flex-col justify-between h-full">
    
    {{-- Bagian atas: profil dan menu --}}
    <div>
      {{-- Profil (mode mobile) --}}
      <div class="w-full p-4 bg-gray-300 md:hidden md:w-auto md:mt-0 md:items-center">
        <div class="flex items-center space-x-2 justify-between">
          @php
              $profil = Auth::user();
          @endphp

          <div class="pl-4">
              <a href="../Peneliti/profil" class="hover:text-blue-950">
                  <p class="text-lg font-bold">Hai, {{ $profil->name }}</p>
                  <p class="text-sm font-light">masuk profil</p>
              </a>
          </div>
          <a href="../Peneliti/profil">
            <img 
              @if (!empty($profil->avatar_path))
                  src="{{ asset('public/' . $profil->avatar_path) }}"
              @else
                  src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
              @endif
              alt="Foto Profil" class="w-11 h-11 rounded-full" />
          </a>
        </div>
      </div>

      {{-- Menu Navigasi --}}
      <ul class="divide-y divide-gray-600 md:pt-2">
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../peneliti/dashboard" :active="request()->is('peneliti/dashboard')">Dasbor Peneliti</x-Nav-Link></li>
          <li><x-Nav-Link href="../peneliti/penelitian" :active="request()->is('peneliti/penelitian')">Penelitian saya</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../peneliti/nomorProtokol" :active="request()->is('peneliti/nomorProtokol')">Nomor protokol</x-Nav-Link></li>
          <li><x-Nav-Link href="../peneliti/pengajuanPenelitian" :active="request()->is('peneliti/pengajuanPenelitian')">Ajukan Penelitian</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../peneliti/template" :active="request()->is('peneliti/template')">Template</x-Nav-Link></li>
          <li><x-Nav-Link href="../peneliti/tentangKami" :active="request()->is('peneliti/tentangKami')">Tentang kami</x-Nav-Link></li>
        </div>
      </ul>
    </div>

    {{-- Bagian bawah: Logout --}}
    <div class="p-4 border-t border-gray-600 hover:text-red-800 hover:bg-gray-300 transition-all duration-300 ease-in-out">
      <x-Nav-Link href="#" class="font-semibold" onclick="document.getElementById('logoutModal').classList.remove('hidden')" :active="false">
        <div class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
          </svg>
          <span>Keluar akun</span>
        </div>
      </x-Nav-Link>
    </div>

  </div>
</aside>



@elseif ($profil->role == 'Admin')
{{-- Sidebar Admin --}}
<aside id="sidebar" class="w-full md:w-50 bg-gray-200 pt-16 h-auto md:h-screen shadow fixed md:max-h-full md:block hidden">
  <div class="flex flex-col justify-between h-full">

    {{-- Bagian atas: profil dan menu --}}
    <div>
      {{-- Profil (mobile) --}}
      <div class="w-full p-4 bg-gray-300 md:hidden md:w-auto md:mt-0 md:items-center">
        <div class="flex items-center space-x-2 justify-between">
          <div class="pl-4"> 
              @php
                  $profil = Auth::user();
              @endphp

              <a href="../Admin/profil" class="hover:text-blue-950">
                  <p class="text-lg font-bold">Hai, {{ $profil->name }}</p>
                  <p class="text-sm font-light">masuk profil</p>
              </a>
          </div>
          <a href="../Admin/profil">
            <img 
              @if (!empty($profil->avatar_path))
                  src="{{ asset("public/" . $profil->avatar_path) }}"
              @else
                  src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
              @endif
              alt="Foto Profil" class="w-11 h-11 rounded-full" />
          </a>
        </div>
      </div>

      {{-- Menu Navigasi --}}
      <ul class="divide-y divide-gray-600 md:pt-2">
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../admin/dashboard" :active="request()->is('admin/dashboard')">Dasbor Admin</x-Nav-Link></li>
          <li><x-Nav-Link href="../admin/kelolaUser" :active="request()->is('admin/kelolaUser')">Kelola User</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../admin/nomorProtokol" :active="request()->is('admin/nomorProtokol')">Nomor Protokol</x-Nav-Link></li>
          <li><x-Nav-Link href="../admin/pengajuanPenelitian" :active="request()->is('admin/pengajuanPenelitian')">Data Pengajuan</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../admin/dataPenelitian" :active="request()->is('admin/dataPenelitian')">Data Penelitian</x-Nav-Link></li>
          <li><x-Nav-Link href="../admin/suratLulus" :active="request()->is('admin/suratLulus')">Buat Surat Lulus</x-Nav-Link></li>
        </div>
      </ul>
    </div>

    {{-- Bagian bawah: Logout --}}
    <div class="p-4 border-t   border-gray-600 hover:text-red-800 hover:bg-gray-300 transition-all duration-300 ease-in-out">
      <x-Nav-Link href="#" class="font-semibold" onclick="document.getElementById('logoutModal').classList.remove('hidden')" :active="false">
        <div class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
          </svg>
          <span>Keluar akun</span>
        </div>
      </x-Nav-Link>
    </div>

  </div>
</aside>


@elseif ($profil->role == 'Kepk')
{{-- Sidebar KEPK/Sekretaris --}}
<aside id="sidebar" class="w-full md:w-50 bg-gray-200 pt-16 h-auto md:h-screen shadow fixed md:max-h-full md:block hidden">
  <div class="flex flex-col justify-between h-full">

    {{-- Bagian atas: profil dan menu --}}
    <div>
      {{-- Profil (mobile) --}}
      <div class="w-full p-4 bg-gray-300 md:hidden md:w-auto md:mt-0 md:items-center">
        <div class="flex items-center space-x-2 justify-between">
          <div class="pl-4">
            @php
                $profil = Auth::user();
            @endphp
            <a href="../Kepk/profil" class="hover:text-blue-950">
                <p class="text-lg font-bold">Hai, {{ $profil->name }}</p>
                <p class="text-sm font-light">masuk profil</p>
            </a>
          </div>
          <a href="../Kepk/profil">
            <img 
              @if (!empty($profil->avatar_path))
                  src="{{ asset('public/' . $profil->avatar_path) }}"
              @else
                  src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
              @endif
              alt="Foto Profil" class="w-11 h-11 rounded-full" />
          </a>
        </div>
      </div>

      {{-- Menu Navigasi --}}
      <ul class="divide-y divide-gray-600 md:pt-2">
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../kepk/dashboard" :active="request()->is('kepk/dashboard')">Dasbor KEPK</x-Nav-Link></li>
          <li><x-Nav-Link href="../kepk/dataPenelitian" :active="request()->is('kepk/dataPenelitian')">Data Penelitian</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../kepk/telaahAwal" :active="request()->is('kepk/telaahAwal')">Telaah Awal</x-Nav-Link></li>
          <li><x-Nav-Link href="../kepk/telaahAkhir" :active="request()->is('kepk/telaahAkhir')">Telaah Akhir</x-Nav-Link></li>
        </div>
      </ul>
    </div>

    {{-- Bagian bawah: Logout --}}
    <div class="p-4 border-t border-gray-600 hover:text-red-800 hover:bg-gray-300 transition-all duration-300 ease-in-out">
      <x-Nav-Link href="#" class="font-semibold" onclick="document.getElementById('logoutModal').classList.remove('hidden')" :active="false">
        <div class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
          </svg>
          <span>Keluar akun</span>
        </div>
      </x-Nav-Link>
    </div>

  </div>
</aside>



@elseif($profil->role == 'Penguji')
{{-- Sidebar Penguji --}}
<aside id="sidebar" class="w-full md:w-50 bg-gray-200 pt-16 h-auto md:h-screen shadow fixed md:max-h-full md:block hidden">
  <div class="flex flex-col justify-between h-full">

    {{-- Bagian atas: Profil dan Menu --}}
    <div>
      {{-- Profil (mobile view) --}}
      <div class="w-full p-4 bg-gray-300 md:hidden md:w-auto md:mt-0 md:items-center">
        <div class="flex items-center space-x-2 justify-between">
          <div class="pl-4">
            @php
                $profil = Auth::user();
            @endphp
            <a href="../Penguji/profil" class="hover:text-blue-950">
              <p class="text-lg font-bold">Hai, {{ $profil->name }}</p>
              <p class="text-sm font-light">masuk profil</p>
            </a>
          </div>
          <a href="../Penguji/profil">
            <img 
              @if (!empty($profil->avatar_path))
                  src="{{ asset('public/' . $profil->avatar_path) }}"
              @else
                  src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
              @endif
              alt="Foto Profil" class="w-11 h-11 rounded-full" />
          </a>
        </div>
      </div>

      {{-- Menu Navigasi --}}
      <ul class="divide-y divide-gray-600 md:pt-2">
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../penguji/dashboard" :active="request()->is('penguji/dashboard')">Dasbor Penguji</x-Nav-Link></li>
          <li><x-Nav-Link href="../penguji/dataPenelitian" :active="request()->is('penguji/dataPenelitian')">Data Penelitian</x-Nav-Link></li>
        </div>
        <div class="max-md:divide-y py-1 divide-gray-600">
          <li><x-Nav-Link href="../penguji/telaahPenelitian" :active="request()->is('penguji/telaahPenelitian')">Telaah Penelitian</x-Nav-Link></li>
        </div>
      </ul>
    </div>

    {{-- Bagian bawah: Logout --}}
    <div class="p-4 border-t border-gray-600 hover:text-red-800 hover:bg-gray-300 transition-all duration-300 ease-in-out">
      <x-Nav-Link href="#" class="font-semibold"
        onclick="document.getElementById('logoutModal').classList.remove('hidden'); document.getElementById('logoutModal').classList.add('flex')"
        :active="false">
        <div class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
          </svg>
          <span>Keluar akun</span>
        </div>
      </x-Nav-Link>
    </div>

  </div>
</aside>

@endif

<!-- Modal Logout -->
<div id="logoutModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm bg-black/50 flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Keluar</h2>
    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari akun Anda?</p>

    <div class="flex justify-end space-x-3">
      <button onclick="document.getElementById('logoutModal').classList.add('hidden').classList.remove('flex')" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">
        Batal
      </button>
      
      <a href="../{{ $profil->role }}/logout">
        <button class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
          Keluar
        </button>
      </a>
        

    </div>
  </div>
</div>

<script>
  function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("hidden");
    }
</script>




