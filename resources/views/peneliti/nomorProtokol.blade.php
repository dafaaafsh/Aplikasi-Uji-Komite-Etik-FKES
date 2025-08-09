<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>
  <x-slot:protocols>{{ $protocols }}</x-slot>

  <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 p-5 rounded-xl shadow mb-8">
    <h3 class="font-semibold text-lg mb-2">Perhatian</h3>
    <ul class="space-y-2 text-sm list-disc pl-5">
      <li>Setelah mendaftar, segera lakukan pembayaran jasa layanan uji komite etik.</li>
      <li>Pastikan informasi lengkap dan benar. Nomor protokol hanya diajukan satu kali.</li>
      <li>Hubungi admin melalui kontak di halaman profil jika ada kendala.</li>
    </ul>    
  </div>

  {{-- Status pembayaran --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-red-500">
      <div class="flex gap-4">
        <div class="text-red-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-red-700">Perlu Dibayar</p>
          <p class="text-sm text-gray-700">Lakukan transaksi pada kolom <strong>Detail Pembayaran</strong>.</p>
        </div>
      </div>
      <span class="text-red-700 font-bold text-lg bg-red-100 rounded-full px-3 py-1">
        {{ $protocols->where('verified_pembayaran', null)->count() }}
      </span>
    </div>
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-green-500">
      <div class="flex gap-4">
        <div class="text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-green-700">Telah Dibayar</p>
          <p class="text-sm text-gray-700">Transaksi telah berhasil dilakukan.</p>
        </div>
      </div>
      <span class="text-green-700 font-bold text-lg bg-green-100 rounded-full px-3 py-1">
        {{ $protocols->whereNotNull('verified_pembayaran')->count() }}
      </span>
    </div>
  </div>
  
  {{-- Tabel --}}
  <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mt-8">
    <div class="px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-t-2xl">
      <h2 class="text-lg font-semibold">Tabel Penelitian Terdahulu</h2>
      <p class="text-sm text-sky-100">Menampilkan daftar penelitian yang telah diajukan di Uji Komite Etik Fakultas Kesehatan Universitas Nurul Jadid</p>
    </div>
  
    <div class="overflow-x-auto w-full">
      <table class="min-w-full text-sm text-gray-800 divide-y divide-gray-200">
        <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
          <tr>
            <th class="p-2 text-center">Nomor Protokol</th>
            <th class="p-2 text-center">Judul Penelitian</th>
            <th class="p-2 text-center">Subjek</th>
            <th class="p-2 text-center">Jenis Penelitian</th>
            <th class="p-2 text-center">Jenis Pengajuan</th>
            <th class="p-2 text-center">Status</th>
            <th class="p-2 text-center">Status Pembayaran</th>
            <th class="p-2 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-300">
          @forelse ($protocols as $item) 
            <tr class="odd:bg-white even:bg-gray-200 text-center">
              @if (!empty($item->nomor_protokol))
                <td class="px-6 py-4 text-blue-600 text-center font-medium">{{ $item->nomor_protokol_asli }}</td>
              @else
                <td class="px-6 py-4 text-gray-600 text-center italic font-medium">Belum Tersedia</td>
              @endif
              <td class="px-6 py-4">{{ Str::words($item->judul, 6) }}</td>
              <td class="px-6 py-4">{{ $item->subjek_penelitian }}</td>
              <td class="px-6 py-4">{{ $item->jenis_penelitian }}</td>
              <td class="px-6 py-4">{{ $item->jenis_pengajuan }}</td>
              
              <td class="p-3 text-center">
                @php
                  $statusColors = [
                    'Menunggu Pembayaran' => 'text-yellow-700',
                    'Diperiksa' => 'text-blue-800',
                    'Dikembalikan' => 'text-red-800',
                    'Diterima' => 'text-green-800'
                  ];
                  $statusClass = $statusColors[$item->status_pembayaran] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                  {{ $item->status_pembayaran }}
                </span>
              </td>
              <td class="px-6 py-4 
                @if ($item->status_pembayaran === 'Diterima') text-green-600  
                @else text-red-600 
                @endif "
                >
                @if ($item->status_pembayaran === 'Diterima') Dibayar
                @else 
                  @if (empty($item->tarif))
                    <span class="text-gray-500 italic">Belum ditentukan</span>
                    @else
                    @if ($item->status_pembayaran == 'Diperiksa')
                      <span class="text-blue-500">Diperiksa</span>
                    @else
                      <a onclick="openDetail({{$item->id}})" class="hover:underline">Perlu Dibayar</a>
                    @endif
                  @endif
                @endif
                <td class="px-6 py-4">
                  <div class="flex gap-3">
                    {{-- Tombol Upload Bukti Pembayaran --}}
                    @if (empty($item->verified_pembayaran) && !empty($item->tarif) && $item->status_pembayaran !== 'Diperiksa')
                    <button 
                      onclick="openUploadBukti({{ $item->id }})"
                      class="px-4 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm flex items-center gap-1"
                      data-id="{{ $item->id }}"
                      title="Upload Bukti Pembayaran"
                    >   
                      <svg xmlns="http://www.w3.org/2000/svg" 
                           fill="none" viewBox="0 0 24 24" 
                           stroke-width="1.5" stroke="currentColor" 
                           class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                      </svg>
                    </button>
                    @endif
                
                    {{-- Tombol Detail Protokol --}}
                    <button 
                      onclick="openDetail({{ $item->id }})"
                      class="px-4 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm flex items-center gap-1"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" 
                           fill="none" viewBox="0 0 24 24" 
                           stroke-width="1.5" stroke="currentColor" 
                           class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                      </svg>
                    </button>
                  </div>
                </td>
                
            </tr>
          @empty
            <tr>
              <td colspan="8"
              class="px-6 py-4 text-center text-md italic text-gray-400 font-semibold">
                Belum ada permohonan nomor yang pernah diajukan
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Form Daftar Nomor Protokol --}}
  <div class=" mx-auto bg-white p-8 mt-8 rounded-2xl shadow-lg">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Form Daftar Nomor Protokol</h2>
    @if ($errors->any())
      <div class="px-8 py-2 text-center bg-red-200 border border-red-700 text-red-700 rounded-3xl">
        <span class="text-md mb-4 ">Harap Lengkapi semua data yang dibutuhkan!</span>
      </div>
    @endif
    

    <form action="" method="POST" class=" mt-4 space-y-6">
      @csrf
      <!-- Nama Judul Penelitian -->
      <div>
        <label for="judul" class="block text-md font-medium text-gray-700">Nama Judul Penelitian</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
            class="px-4 border border-gray-600 mt-1 block w-full rounded-lg bg-white h-7 shadow-sm focus:ring-blue-500 focus:border-blue-500">
      </div>
  
      <!-- Subjek Penelitian -->
      <div>
        <label for="subjek" class="block text-md font-medium text-gray-700">Subjek Penelitian</label>
        <select id="subjek" name="subjek"
          class="px-3 border border-gray-600 mt-1 block w-full rounded-lg bg-white h-7 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">-- Pilih Subjek --</option>
          <option value="Manusia" {{ old('subjek') == 'Manusia' ? 'selected' : '' }}>Manusia</option>
          <option value="Data Sekunder" {{ old('subjek') == 'Data Sekunder' ? 'selected' : '' }}>Data Sekunder</option>
          <option value="In Vitro" {{ old('subjek') == 'In Vitro' ? 'selected' : '' }}>In Vitro</option>
        </select>
      </div>
    
    
      <!-- Jenis Penelitian -->
      <div>
        <label for="jenis_penelitian" class="block text-md font-medium text-gray-700">Jenis Penelitian</label>
        <select id="jenis_penelitian" name="jenis_penelitian" 
              class="mt-1 block w-full rounded-lg px-3 border border-gray-600 bg-white h-7 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          <option value="">-- Pilih Jenis --</option>
          <option value="Multicenter" {{ old('jenis_penelitian') == 'Multicenter' ? 'selected' : '' }}>Multicenter</option>
          <option value="Eksperimental Human" {{ old('jenis_penelitian') == 'Eksperimental Human' ? 'selected' : '' }}>Eksperimental Human</option>
          <option value="Eksperimental Non Human" {{ old('jenis_penelitian') == 'Eksperimental Non Human' ? 'selected' : '' }}>Eksperimental Non Human</option>
          <option value="Observasional Human" {{ old('jenis_penelitian') == 'Observasional Human' ? 'selected' : '' }}>Observasional Human</option>
          <option value="Observasional Non Human" {{ old('jenis_penelitian') == 'Observasional Non Human' ? 'selected' : '' }}>Observasional Non Human</option>
          <option value="In Vitro" {{ old('jenis_penelitian') == 'In Vitro' ? 'selected' : '' }}>In Vitro</option>
        </select>
      </div>
      
      <!-- Jenis Pengajuan -->
        <div>
          <label for="jenis_pengajuan" class="block text-md font-medium text-gray-700">Jenis Pengajuan</label>
          <select id="jenis_pengajuan" name="jenis_pengajuan" 
                  class="mt-1 block w-full rounded-lg px-3 border border-gray-600 bg-white h-7 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">-- Pilih Jenis --</option>
            <option value="Telaah Awal" {{ old('jenis_pengajuan') == 'Telaah Awal' ? 'selected' : '' }}>Telaah Awal</option>
            <option value="Pengiriman Ulang Untuk Telaah Ulang" {{ old('jenis_pengajuan') == 'Pengiriman Ulang Untuk Telaah Ulang' ? 'selected' : '' }}>Pengiriman Ulang Untuk Telaah Ulang</option>
            <option value="Amandemen Protokol" {{ old('jenis_pengajuan') == 'Amandemen Protokol' ? 'selected' : '' }}>Amandemen Protokol</option>
            <option value="Telaah Lanjutan Untuk Protokol Yang disetujui" {{ old('jenis_pengajuan') == 'Telaah Lanjutan Untuk Protokol Yang disetujui' ? 'selected' : '' }}>Telaah Lanjutan Untuk Protokol Yang Telah Disetujui</option>
            <option value="penghentian Studi" {{ old('jenis_pengajuan') == 'penghentian Studi' ? 'selected' : '' }}>Penghentian Studi (Jika Terjadi Penyimpangan)</option>
          </select>
        </div>

      <!-- Biaya Penelitian -->
      <div>
        <label for="biaya_penelitian" class="block text-md font-medium text-gray-700">Biaya Penelitian</label>
        <select id="biaya_penelitian" name="biaya_penelitian" 
                class="mt-1 block w-full rounded-lg px-3 border border-gray-600 bg-white h-8 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">-- Pilih Biaya --</option>
        <option value="Sponsor" {{ old('biaya_penelitian') == 'Sponsor' ? 'selected' : '' }}>Sponsor</option>
        <option value="Mandiri" {{ old('biaya_penelitian') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
        </select>
      </div>

      
      <!-- Checkbox Persetujuan -->
      <div class="flex items-start">
        <div class="flex items-center h-5">
           <input id="agreement" name="agreement" type="checkbox" 
            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        </div>
        <div class="ml-3 text-sm">
          <label for="agreement" class="font-medium text-gray-700">
              Saya menyetujui <button type="button" onclick="openTerms()" class="text-blue-600 hover:underline">Syarat dan Ketentuan</button>
          </label>
        </div>
      </div>
      
              <!-- Tombol Submit -->
        <div>
            <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Daftar
            </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Upload Bukti Pembayaran --}}
  <div id="modalUploadBukti" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
      
      <button onclick="closeUploadModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
  
      <h2 class="text-lg font-bold text-gray-800 mb-2">Upload Bukti Pembayaran</h2>

      <p class="text-sm mb-4 text-gray-600">Silahkan upload bukti pembayaran anda dengan extensi yang sesuai disini.</p>
  
      <form id="formUploadBukti" action="{{ route('peneliti.upload.bukti') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="protocol_id" id="upload_bukti_id">
  
        <div class="mb-4">
          <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">File Bukti (PDF, JPEG, JPG, PNG)</label>
          <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>
  
        <div class="flex justify-end">
          <button type="button" onclick="closeUploadModal()"
            class="px-4 py-2 mr-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            Batal
          </button>
          <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Upload
          </button>
        </div>
      </form>
    </div>
  </div>

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-200">
  <div class="bg-white w-[400px] p-6 rounded-lg shadow-xl relative">
    <button onclick="closeDetail()" class="absolute top-2 right-2 text-gray-500 hover:text-black">&times;</button>
    <h2 class="text-xl font-bold text-gray-800 mb-3">Detail Pembayaran</h2>
    
    <div id="modalContent">
      <p class="text-sm text-blue-700 mb-1"><strong>Nomor Protokol:</strong> <span id="nomor-protokol"></span></p>
      <p class="text-sm text-blue-700 mb-1"><strong>Judul Penelitian:</strong> <span id="judul-penelitian"></span></p>
      <br>
      <p class="text-sm text-gray-700 mb-1"><strong>Nama Peneliti:</strong> <span id="nama-peneliti"></span></p>
      <p class="text-sm text-gray-700 mb-1"><strong>Status Pembayaran:</strong> <span id="status-pembayaran"></span></p>
      <p class="text-sm text-gray-700 mb-1"><strong>Tanggal Pembayaran:</strong> <span id="tanggal-pembayaran"></span></p>
      <p class="text-sm text-gray-700 mb-1"><strong>Jumlah Pembayaran:</strong> <span id="tarif"></span></p>
    </div>

    <div class="mt-4" id="paymentInfo">
      <hr class="mt-6 mb-4 border-gray-500">
      <h2 class="text-xl font-bold text-gray-800 mb-3">Informasi Pembayaran</h2>
      <p class="text-sm text-gray-600 mb-4">Silakan transfer ke rekening berikut:</p>

      <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 text-left mb-4">
        <p class="text-sm text-gray-700 font-medium">Bank:</p>
        <p class="text-lg font-bold text-gray-900 mb-2">BNI</p>

        <p class="text-sm text-gray-700 font-medium">Nomor Virtual Account:</p>
        <p class="text-lg font-bold text-blue-700 tracking-wide" id="va"></p>

        <p class="text-sm text-gray-700 font-medium mt-3">Atas Nama:</p>
        <p class="text-lg font-semibold text-gray-900">Fakultas Kesehatan Universitas Nurul Jadid</p>
      </div>
    </div>
    

      <div class="flex justify-between mt-6">
        <button onclick="closeDetail()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
          Tutup
        </button>
      </div>

  </div>
</div>

{{-- Modal Ketentuan --}}
<div id="termsModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm bg-black/40 items-center justify-center transition-opacity duration-300">
  <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-2xl relative">
    <button onclick="closeTerms()" aria-label="Tutup"
            class="absolute top-3 right-4 text-gray-400 hover:text-black text-2xl font-bold">&times;</button>
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Syarat dan Ketentuan</h2>
    <p class="text-sm text-gray-700 leading-relaxed mb-6">
      Dengan ini saya berjanji untuk menjaga terbebas dari konflik kepentingan dan melakukan tugas saya secara objektif,
      melindungi integritas penelitian ilmiah, melindungi semua manusia subyek penelitian dan mematuhi tanggung jawab etik sebagai peneliti.
    </p>
    <div class="text-right">
      <button onclick="closeTerms()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
        Saya Mengerti
      </button>
    </div>
  </div>
</div>

{{-- Modal Status --}}
@if ($errors->any())
  <div id="modalError" class="fixed flex inset-0 bg-black/70 bg-opacity-50 z-50 justify-center items-center">
    <div class="bg-red-100 border border-red-800 rounded-lg shadow-lg w-full max-w-md p-6 h-fit max-h-md">
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
          <strong>Gagal menyimpan!</strong> Periksa kembali input Anda:
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

  <script>

      function openUploadBukti(id) {
        document.getElementById('upload_bukti_id').value = id;
        document.getElementById('modalUploadBukti').classList.remove('hidden');
      }
    
      function closeUploadModal() {
        document.getElementById('modalUploadBukti').classList.add('hidden');
        document.getElementById('formUploadBukti').reset();
      }

      function openDetail(id) {
        fetch(`/peneliti/protokol/${id}`)  
          .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data');
            return response.json();
          })
          .then(data => {
            document.getElementById('nomor-protokol').textContent = data.nomor_protokol_asli || '-';
            document.getElementById('judul-penelitian').textContent = data.judul || 'Tidak ada data';
            document.getElementById('nama-peneliti').textContent = data.nama || 'Tidak ada data';
            document.getElementById('status-pembayaran').textContent = data.status_pembayaran || 'Tidak ada data';
            document.getElementById('tanggal-pembayaran').textContent = data.pembayaran ?? '-';
            document.getElementById('va').textContent = data.va ?? '-';
            if (data.tarif === null || data.tarif === 0) {
              data.tarif = 'Belum ditentukan';
            }
            else {
              data.tarif = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.tarif);
              document.getElementById('tarif').textContent = data.tarif;
            }

            if (data.status_pembayaran === 'Diterima') {
              document.getElementById('paymentInfo').classList.add('hidden');
            } else {
              document.getElementById('paymentInfo').classList.remove('hidden');
            }

            // Tampilkan modal
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
          })
          .catch(error => {
            console.error('Terjadi kesalahan:', error);
            alert('Gagal memuat detail. Coba lagi nanti.');
          });
      }

      function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
      }

      function openTerms() {
        document.getElementById('termsModal').classList.remove('hidden')
        document.getElementById('termsModal').classList.add('flex')
        document.body.classList.add('overflow-hidden');
      }

      function closeTerms() {
        document.getElementById('termsModal').classList.add('hidden')
        document.getElementById('termsModal').classList.remove('flex')
        document.body.classList.remove('overflow-hidden');
      }

      function openQr() {
        document.getElementById('modalQRCode').classList.remove('hidden')
        document.getElementById('modalQRCode').classList.add('flex')
        document.body.classList.add('overflow-hidden');
      }

      function closeQr() {
        document.getElementById('modalQRCode').classList.add('hidden')
        document.getElementById('modalQRCode').classList.remove('flex')
        document.body.classList.remove('overflow-hidden');
      }

      function tutupModalError() {
          document.getElementById('modalError').classList.add('hidden');
          document.getElementById('modalError').classList.remove('flex');
      }

      function tutupModalSuccess() {
          const modal = document.getElementById('modalSuccess');
          if (modal) modal.classList.add('hidden');
      }
  
  </script>
</x-Layout>