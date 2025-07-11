<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>

  <div class="mx-3 mt-1 p-3 bg-white rounded-lg shadow-md">
    
      <!-- Informasi Dasar -->
      <div class="mb-6 border-b pb-4 border-gray-500">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Dasar</h3>
        <div class="flex justify-between">
          <div class="flex items-center space-x-4">
            <img 
              @if (!empty($user->avatar_path))
                src="{{ asset("public/". $user->avatar_path )}}"
              @else
                src="https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4="
              @endif
              alt="Foto Profil" class="w-24 h-24  rounded-full" />
            <div>
                <p class="text-lg font-semibold text-gray-700 flex gap-1">
                    <span>{{ $user['name'] }}</span>
                        
                    @if (!empty($user->email_verified_at))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 mt-1 text-green-800">
                            <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mt-1 text-red-700">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </p>
                <div class="flex">
                    <p class="text-sm text-gray-500">{{ $user['email'] }}</p>
                </div>
                <p class="text-sm text-gray-500">Status: <span class="font-medium text-blue-600">{{ $user->status_peneliti }}</span></p>
            </div>
          </div>
          <div>
            <button onclick="openModalAvatar()" class="px-2 py-2 mt-3 mr-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Ganti Foto Profil</button>
          </div>
        </div>
        
      </div>

      @if ($errors->any())
        <div id="modalError" class="fixed flex inset-0 bg-black/70 bg-opacity-50 z-50 justify-center items-center">
            <div class="bg-red-100 border border-red-800 rounded-lg shadow-lg w-full max-w-md p-6 h-fit max-h-md">

                  <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                      <strong>Gagal Mendaftarkan Akun!</strong> 
                      <span>Periksa kembali input Anda:</span>
                      <ul class="mt-2 list-disc list-inside text-sm">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
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
    
      <form action="{{ route('kepk.profil.update') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="id"   value="{{ $user->id }}">
    
        <!-- Data Identitas -->
        <div class="border-b pb-4 border-gray-500">
          <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Identitas</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
              <input type="text" value="{{ $user->name }}" name="nama"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600">Email</label>
              <input type="email" value="{{ $user->email }}" disabled class="mt-1 block w-full text-gray-400 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600">Nomor HP</label>
              <input type="text" value="{{ $user->nomor_hp }}" name="hp"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600">Alamat</label>
              <textarea rows="3" name="alamat"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $user->alamat }}</textarea>
            </div>
          </div>
        </div>
  
        <!-- Afiliasi Peneliti -->
        <div class="pb-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 mt-4">Afiliasi Peneliti</h3>
          @if (empty($user->institusi)||empty($user->status_peneliti)||empty($user->asal_peneliti))
            <p class="text-sm text-red-600 bg-red-100 border border-red-300 p-3 rounded mb-4">
              <strong>Perhatian:</strong> Data afiliasi seperti <em>Institusi</em>, <em>Asal Peneliti</em>, dan <em>Status Peneliti</em> hanya dapat diisi satu kali.
              Setelah disimpan, data ini tidak dapat diubah kembali. Mohon periksa kembali sebelum mengisi dan menyimpan.
            </p>
          @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">Institusi</label>
                <input type="text" value="{{ $user->institusi }}" name="institusi" @if (!empty($user->institusi))
                    Disabled
                @endif
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>
          
            <div>
                <label class="block text-sm font-medium text-gray-600">Status Peneliti</label>
                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @if (!empty($user->status_peneliti))
                        <option selected disabled class="text-gray-400 bg-gray-100" value="{{ $user->status_peneliti }}">
                            {{ $user->status_peneliti }}    
                        </option>     
                    @else
                        <option selected value="">-- Pilih --</option>
                        <option value="Mahasiswa (S1)">Mahasiswa (S1)</option>
                        <option value="Mahasiswa (S2)">Mahasiswa (S2)</option>
                        <option value="Mahasiswa (S3)">Mahasiswa (S3)</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Peneliti Umum">Peneliti Umum</option>
                    @endif
                </select>
            </div>
          
            <div>
              <label class="block text-sm font-medium text-gray-600">Asal Peneliti</label>
              <select name="asal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                  @if (!empty($user->asal_peneliti))
                      <option selected disabled class="text-gray-400 bg-gray-100 value="{{ $user->asal_peneliti }}">{{ $user->asal_peneliti }}</option>
                  @else
                      <option selected value="">-- Pilih --</option>
                      <option value="UNUJA">UNUJA</option>
                      <option value="Eksternal">Eksternal</option>
                  @endif
              </select>
            </div>
          </div>
        </div>


        <!-- Tombol Simpan -->
        <div class="pt-4">
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

    <!-- Form Ganti Password -->
<div class="mx-3 mt-10 bg-white p-6 rounded-lg shadow-md pt-8">
  <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-700 pb-2">Ganti Password</h3>
  
  <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-600">Password Lama</label>
      <input type="password" name="current_password" required
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600">Password Baru</label>
      <input type="password" name="new_password" required
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600">Konfirmasi Password Baru</label>
      <input type="password" name="new_password_confirmation" required
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
    </div>

    <div>
      <button type="submit"
              class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
        Simpan Password Baru
      </button>
    </div>
  </form>
</div>

<!-- Modal Avatar -->
<div id="modalAvatar" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
    
    <h2 class="text-lg font-semibold text-gray-800 text-center mb-4">Ganti Foto Profil</h2>
    
    <form action="{{ route('kepk.profil.uploadAvatar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <input 
        type="file" 
        name="avatar" 
        accept="image/*" 
        class="block w-full text-sm text-gray-700 file:bg-gray-500 file:text-white file:py-2 file:px-4 file:rounded-lg file:border-0 file:cursor-pointer file:transition hover:file:bg-gray-600"
      >
      
      <div class="flex justify-end gap-3 pt-2">
        <button 
          type="button" 
          onclick="closeModalAvatar()" 
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition"
        >
          Batal
        </button>
        <button 
          type="submit" 
          class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
        >
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>



<script>
  function tutupModalError() {
    document.getElementById('modalError').classList.add('hidden');
    document.getElementById('modalError').classList.remove('flex');
  }

  function tutupModalSuccess() {
    const modal = document.getElementById('modalSuccess');
    if (modal) modal.classList.add('hidden');
  }

  function openModalAvatar(){
    const modal = document.getElementById('modalAvatar');
    modal.classList.add('block', 'flex');
    modal.classList.remove('hidden')
  }
  function closeModalAvatar(){
    const modal = document.getElementById('modalAvatar');
    modal.classList.remove('block', 'flex');
    modal.classList.add('hidden')
  }
</script>
    


</x-Layout>