<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>

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

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
    <!-- Diperiksa -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-yellow-400">
      <div class="flex gap-4">
        <div class="text-yellow-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-yellow-600">Diperiksa</p>
          <p class="text-sm text-gray-700">Dokumen sedang diverifikasi oleh administrator.</p>
        </div>
      </div>
      <span class="text-yellow-700 font-bold text-lg bg-yellow-100 rounded-full px-3 py-1">
        {{ $protocols->where('status_penelitian', 'Diperiksa')->count() }}
      </span>
    </div>
  
    <!-- Ditelaah -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-blue-500">
      <div class="flex gap-4">
        <div class="text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 116 3.6" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-blue-700">Ditelaah</p>
          <p class="text-sm text-gray-700">Proposal sedang ditinjau oleh tim etik internal.</p>
        </div>
      </div>
      <span class="text-blue-700 font-bold text-lg bg-blue-100 rounded-full px-3 py-1">
        {{ $protocols->where('status_penelitian', 'Ditelaah')->count() }}
      </span>
    </div>
  
    <!-- Dikembalikan -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-red-500">
      <div class="flex gap-4">
        <div class="text-red-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-red-700">Dikembalikan</p>
          <p class="text-sm text-gray-700">Lengkapi data melalui <strong>Edit Data</strong>.</p>
        </div>
      </div>
      <span class="text-red-700 font-bold text-lg bg-red-100 rounded-full px-3 py-1">
        {{ $protocols->where('status_penelitian', 'Dikembalikan')->count() }}
      </span>
    </div>
  
    <!-- Selesai -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-green-500">
      <div class="flex gap-4">
        <div class="text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-green-700">Selesai</p>
          <p class="text-sm text-gray-700">Proposal telah dinyatakan selesai dan valid.</p>
        </div>
      </div>
      <span class="text-green-700 font-bold text-lg bg-green-100 rounded-full px-3 py-1">
        {{ $protocols->where('status_penelitian', 'Selesai')->count() }}
      </span>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg overflow-auto border border-gray-200">
    <div class="px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-t-2xl">
      <h2 class="text-lg font-semibold">Tabel Penelitian Saya</h2>
      <p class="text-sm text-sky-100">Menampilkan daftar penelitian yang telah anda ajukan di Uji Komite Etik Fakultas Kesehatan Universitas Nurul Jadid</p>
    </div>
  <div class="bg-white rounded-xl shadow-xl overflow-auto">
    <table id="penelitianTable" class="min-w-full text-sm text-gray-800 divide-y divide-gray-200">
      <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
        <tr>
          <th class="p-3 font-semibold">Nomor Protokol</th>
          <th class="p-3 font-semibold">Judul Penelitian</th>
          <th class="p-3 font-semibold">Peneliti Utama</th>
          <th class="p-3 font-semibold">Tanggal Pengajuan</th>
          <th class="p-3 font-semibold">Status</th>
          <th class="p-3 font-semibold">Klasifikasi</th>
          <th class="p-3 font-semibold">Hasil</th>
          <th class="p-3 font-semibold">Detail</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($protocols as $item)
        <tr class="hover:bg-yellow-100 transition-all duration-150 ease-in-out @if(in_array($item->status_penelitian, ['Ditolak', 'Dikembalikan'])) text-red-600 @endif">
          <td class="p-3 font-mono font-bold text-center text-blue-900">{{ $item->nomor_protokol_asli}}</td>
          <td class="p-3">{{ Str::words($item->judul, 10) }}</td>
          <td class="p-3">{{ $item->peneliti->name }}</td>
          <td class="p-3 text-center">{{ $item->created_at->translatedFormat('D, j F Y') }}</td>
          <td class="p-3 text-center">
            @php
              $statusColors = [
                'Diperiksa' => 'bg-yellow-100 text-yellow-800',
                'Ditelaah' => 'bg-blue-100 text-blue-800',
                'Dikembalikan' => 'bg-red-100 text-red-800',
                'Selesai' => 'bg-green-100 text-green-800'
              ];
              $statusClass = $statusColors[$item->status_penelitian] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
              {{ $item->status_penelitian }}
            </span>
          </td>
          
          <td class="p-3 text-center">
            @php
              $klasifikasiColors = [
                'Exempted' => 'bg-purple-100 text-purple-800',
                'Expedited' => 'bg-indigo-100 text-indigo-800',
                'Fullboard' => 'bg-pink-100 text-pink-800',
              ];
              $klasifikasiClass = $klasifikasiColors[$item->kategori_review] ?? 'italic text-gray-800';
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $klasifikasiClass }}">
              {{ $item->kategori_review }}
            </span>
          </td>

          <td class="p-3 text-center">
            @php
                $hasilColors = [
                    'Diterima' => 'bg-green-100 text-green-800',
                    'Ditolak' => 'bg-red-100 text-red-800',
                ];
                $hasil = optional($item->putusan)->hasil_akhir;
                $hasilClass = $hasilColors[$hasil] ?? 'italic text-gray-800';
            @endphp
        
            @if ($hasil)
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $hasilClass }}">
                    {{ $hasil }}
                </span>
            @else
                <span class="px-3 py-1 rounded-full text-sm font-semibold italic text-gray-700">
                    Belum ada hasil
                </span>
            @endif
          </td>        
          
          <td class="p-3 text-center">
            <button
              onclick="fetchDetailProtokol({{ $item->id }})"
              class="bg-blue-700 hover:bg-blue-500 text-white px-4 py-1 rounded-lg shadow text-sm">
              Lihat
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8"
          class="px-6 py-4 text-center text-md italic text-gray-400 font-semibold">
            Belum ada penelitian yang diajukan
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    </div>
  </div>

  <div id="detailModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm overflow-y-auto">
    <div class="flex items-start justify-center min-h-screen px-4 py-8">
      <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8 relative border border-gray-300">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">
          &times;
        </button>
  
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Proposal Penelitian</h2>
  
        <!-- Info Umum -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
          <div>
            <span class="block font-medium text-gray-500">Nomor Protokol</span>
            <span id="detail-nomor-asli" class="text-base font-semibold"></span>
            <span id="detail-nomor" class="hidden text-base font-semibold"></span>
          </div>
          <div>
            <span class="block font-medium text-gray-500">Judul Penelitian</span>
            <span id="detail-judul" class="text-base font-semibold"></span>
          </div>
          <div>
            <span class="block font-medium text-gray-500">Peneliti Utama</span>
            <span id="detail-peneliti" class="text-base font-semibold"></span>
          </div>
          <div>
            <span class="block font-medium text-gray-500">Tanggal Pengajuan</span>
            <span id="detail-tanggal" class="text-base font-semibold"></span>
          </div>
          <div>
            <span class="block font-medium text-gray-500">Status</span>
            <span id="detail-status" class="px-3 py-1 rounded-full text-sm font-semibold inline-block mt-1"></span>
          </div>
          <div>
            <span class="block font-medium text-gray-500">Klasifikasi</span>
            <span id="detail-klasifikasi" class="text-base font-semibold"></span>
          </div>
        </div>

        <div id="alasan-box" class="hidden mt-10">
          <div class="relative rounded-2xl border border-red-400 bg-gray-300/70 backdrop-blur-md shadow-xl p-6">
            <div class="absolute -top-3 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
              DIKEMBALIKAN
            </div>
            <div class="flex items-start gap-4">
              <div class="pt-1">
                <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 
                       10-10S17.52 2 12 2zm.75 14.25a.75.75 0 00-1.5 0v1.5a.75.75 
                       0 001.5 0v-1.5zm0-9a.75.75 0 00-1.5 0v6a.75.75 0 001.5 0v-6z" />
                </svg>
              </div>
              <div>
                <h4 class="text-base font-semibold text-red-700 mb-1">Komentar Admin</h4>
                <p id="detail-alasan" class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                </p>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Dokumen -->
        <div class="mt-10">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Terkait</h3>
          <div id="dokumenTerkaitBox" class="space-y-3 text-sm text-gray-700 max-h-[40vh] overflow-y-auto pr-1">
            @php
              $dokumenList = [
                'surat_permohonan' => 'Surat Permohonan',
                'surat_institusi' => 'Surat Institusi',
                'protokol_etik' => 'Protokol Etik',
                'informed_consent' => 'Informed Consent',
                'proposal_penelitian' => 'Proposal Penelitian',
                'sertifikat_gcp' => 'Sertifikat GCP',
                'cv' => 'Curriculum Vitae (CV)'
              ];
            @endphp

            @foreach ($dokumenList as $key => $label)
              <div class="flex items-center justify-between border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50 transition">
                <span class="font-medium text-gray-800">{{ $label }}</span>
                <a id="link-{{ $key }}" href="#" target="_blank"
                   class="text-blue-600 hover:underline hidden">Lihat File</a>
              </div>
            @endforeach

            <!-- Tempatkan link Google Drive jika ada -->
            <div id="gdrive-link-row" class="flex items-center justify-between border border-blue-200 rounded-lg px-4 py-2 bg-blue-50 hidden">
              <span class="font-medium text-blue-800">Link Google Drive (semua dokumen)</span>
              <a id="gdrive-link-anchor" href="#" target="_blank" class="text-blue-700 font-semibold underline break-all"></a>
            </div>
          </div>
        </div>
  
        <!-- Tombol Aksi -->
        <div class="mt-10 flex justify-end gap-4">
          <button onclick="openEditModal()" id="btn-edit"
            class="px-5 py-2 text-sm rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 shadow-lg">Edit Data</button>
          <button id="btn-review"
            class="px-5 py-2 text-sm rounded-lg text-white bg-teal-500 hover:bg-teal-600 shadow-lg">Lihat Review</button>
          <button id="btn-hasil"
              class="px-4 py-2 text-sm rounded-lg text-white bg-green-600 hover:bg-green-700 shadow">Lihat Hasil
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="editDokumenModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm bg-black/50 flex items-center justify-center overflow-auto px-4 py-8">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-300 relative">
      <form action="{{ route('update.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        @csrf
        <div class="mb-4">
          <h2 class="text-2xl font-bold text-gray-800">Edit Dokumen Penelitian</h2>
          <p class="text-sm text-gray-500 mt-1">Unggah kembali dokumen yang ingin diperbarui. Format harus PDF.</p>
        </div>
  
        <div>
          <label for="nomor_protokol" class="block text-sm font-medium text-gray-700">Nomor Protokol</label>
          <input type="hidden" name="nomor_protokol" id="nomor_protokol" readonly
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
          <input type="text" name="nomor_protokol_asli" id="nomor_protokol_asli" readonly
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
        </div>
  
        @php
          $fields = [
            'surat_permohonan' => ['label' => 'Surat Permohonan Uji Kaji Etik', 'icon' => 'document-text'],
            'surat_institusi' => ['label' => 'Surat Keterangan Institusi', 'icon' => 'building-office'],
            'protokol_etik' => ['label' => 'Protokol Etik Penelitian', 'icon' => 'clipboard-document'],
            'informed_consent' => ['label' => 'Informed Consent', 'icon' => 'pencil-square'],
            'proposal_penelitian' => ['label' => 'Proposal & Instrumen', 'icon' => 'archive-box'],
            'sertifikat_gcp' => ['label' => 'Sertifikat GCP (Opsional)', 'icon' => 'academic-cap'],
            'cv' => ['label' => 'Curriculum Vitae (CV)', 'icon' => 'user-circle'],
          ];
        @endphp
  
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          @foreach ($fields as $name => $field)
          <div>
            <label class="block text-sm font-medium text-gray-700 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                @switch($field['icon'])
                  @case('document-text')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M4 6h16" />
                    @break
                  @case('building-office')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16" />
                    @break
                  @case('clipboard-document')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 2h6a1 1 0 011 1v2H8V3a1 1 0 011-1zM4 6h16v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                    @break
                  @case('pencil-square')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8-3-3-8 8v3z" />
                    @break
                  @case('archive-box')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M4 6h16M4 18h16" />
                    @break
                  @case('academic-cap')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
                    @break
                  @case('user-circle')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4zM12 12a4 4 0 100-8 4 4 0 000 8z" />
                    @break
                @endswitch
              </svg>
              {{ $field['label'] }}
            </label>
            <input type="file" name="{{ $name }}" accept="application/pdf"
              class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg file:bg-blue-50 file:border-0 file:py-2 file:px-4 file:text-blue-600 file:font-semibold hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          </div>
          @endforeach
        </div>
  
        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
          <button type="button" onclick="document.getElementById('editDokumenModal').classList.add('hidden')"
            class="text-gray-600 hover:text-gray-800 text-sm font-medium px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300">
            Batal
          </button>
  
          <button type="submit"
            class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="modalReview" class="fixed py-15 inset-0 z-50 hidden bg-black/60 backdrop-blur-sm overflow-y-auto flex items-center justify-center">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-8 relative border border-gray-300 mx-4 my-auto">
        <button onclick="closeModalReview()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Review Penelitian</h2>
        <div id="review_list" class="space-y-6">
            {{-- konten review --}}
        </div>
    </div>
  </div>

  <div id="modalKeputusan" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl p-8 relative border border-gray-300">
      <button onclick="closeModalKeputusan()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
      
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Hasil Keputusan Akhir</h2>
  
      <div id="keputusanContent" class="space-y-4 text-gray-700 text-sm">
        <!-- Konten hasil keputusan -->
      </div>
  
      <div class="mt-6 text-right">
        <button onclick="closeModalKeputusan()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
          Tutup
        </button>
      </div>
    </div>
  </div>
  

  <script>
    function fetchDetailProtokol(id) {
      fetch(`/peneliti/penelitian/detail/${id}`)
        .then(response => {
          if (!response.ok) throw new Error('Gagal mengambil data');
          return response.json();
        })
        .then(async data => {
          // Ambil dokumen gdrive jika ada
          let gdrive_link = null;
          try {
            const res = await fetch(`/peneliti/penelitian/gdrive-link/${id}`);
            if (res.ok) {
              const d = await res.json();
              if (d && d.gdrive_link) gdrive_link = d.gdrive_link;
            }
          } catch {}
          data.gdrive_link = gdrive_link;
          showDetailModal(data);
        })
        .catch(error => alert(error));
    }

    /**
     * Menampilkan modal detail penelitian.
     * Jika mode Google Drive link, hanya tampilkan link dan sembunyikan file PDF.
     * Jika mode file upload, tampilkan daftar file PDF yang tersedia.
     * Tombol Edit Data hanya muncul jika mode file dan status Diperiksa/Dikembalikan.
     */
    function showDetailModal(data) {
      document.getElementById('detailModal').classList.remove('hidden');

      document.getElementById('detail-nomor-asli').textContent = data.nomor_protokol_asli ?? '-';
      document.getElementById('detail-nomor').textContent = data.nomor_protokol ?? '-';
      document.getElementById('detail-judul').textContent = data.judul_penelitian ?? '-';
      document.getElementById('detail-peneliti').textContent = data.peneliti_utama ?? '-';
      document.getElementById('detail-tanggal').textContent = new Date(data.tanggal_pengajuan).toLocaleDateString('id-ID');
      document.getElementById('detail-status').textContent = data.status ?? '-';
      document.getElementById('detail-klasifikasi').textContent = data.klasifikasi ?? '-';

      const colorStat = document.getElementById('detail-status');
      if(data.status == 'Diperiksa'){
        colorStat.classList.add('bg-yellow-200','text-yellow-700');
      } else if (data.status == 'Ditelaah') {
        colorStat.classList.add('bg-blue-200','text-blue-700');
      } else if(data.status == 'Dikembalikan'){
        colorStat.classList.add('bg-red-200','text-red-700');
      } else if(data.status == 'Selesai'){
        colorStat.classList.add('bg-green-200','text-green-700');
      } else {
        colorStat.classList.add('bg-gray-200','text-gray-700');    
      }
      

      const btnEdit = document.getElementById('btn-edit');
      // Jika mode Google Drive link, tombol edit hanya muncul untuk mengganti link saja
      if (data.gdrive_link) {
        btnEdit.classList.remove('hidden');
        btnEdit.textContent = 'Ganti Link Google Drive';
        btnEdit.onclick = function() {
          openEditGDriveModal(data);
        };
      } else if (data.status === 'Diperiksa' || data.status === 'Dikembalikan') {
        btnEdit.classList.remove('hidden');
        btnEdit.textContent = 'Edit Data';
        btnEdit.onclick = function() {
          openEditModal();
        };
      } else {
        btnEdit.classList.add('hidden');
      }

      // Modal khusus untuk edit link Google Drive
      if (!document.getElementById('editGDriveModal')) {
        const modal = document.createElement('div');
        modal.id = 'editGDriveModal';
        modal.className = 'fixed inset-0 z-50 hidden backdrop-blur-sm bg-black/50 flex items-center justify-center overflow-auto px-4 py-8';
        modal.innerHTML = `
          <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-gray-300 relative p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Ganti Link Google Drive</h2>
            <form id="formEditGDrive" class="space-y-6" action="/peneliti/pengajuanPenelitian/updateGDriveLink" method="POST">
              @csrf
              <div>
                <label for="gdrive_link_input" class="block text-sm font-medium text-gray-700">Link Google Drive</label>
                <input type="url" name="gdrive_link" id="gdrive_link_input" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" pattern="https://(drive|docs)\.google\.com/.*" />
              </div>
              <div id="edit-gdrive-error" class="text-red-600 text-xs mb-2 hidden"></div>
              <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('editGDriveModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800 text-sm font-medium px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300">Batal</button>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow focus:outline-none focus:ring-2 focus:ring-blue-400">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        `;
        document.body.appendChild(modal);
      }

      window.openEditGDriveModal = function(data) {
        const modal = document.getElementById('editGDriveModal');
        modal.classList.remove('hidden');
        document.getElementById('gdrive_link_input').value = data.gdrive_link || '';
        document.getElementById('edit-gdrive-error').classList.add('hidden');
        const form = document.getElementById('formEditGDrive');
        // Pastikan meta csrf-token ada sebelum akses getAttribute
        let csrfToken = '';
        const metaCsrf = document.querySelector('meta[name="csrf-token"]');
        if (metaCsrf) {
          csrfToken = metaCsrf.getAttribute('content');
        }
        form.onsubmit = function(e) {
          e.preventDefault();
          const gdrive_link = document.getElementById('gdrive_link_input').value;
          const errorDiv = document.getElementById('edit-gdrive-error');
          errorDiv.classList.add('hidden');
          // Validasi sederhana di sisi klien
          if (!/^https:\/\/(drive|docs)\.google\.com\//.test(gdrive_link)) {
            errorDiv.textContent = 'Link harus berupa URL Google Drive yang valid';
            errorDiv.classList.remove('hidden');
            return;
          }
          // Kirim ke endpoint updateGDriveLink (bukan updateDocument)
          fetch('/peneliti/pengajuanPenelitian/updateGDriveLink', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
            },
            body: JSON.stringify({
              protocol_id: data.id,
              gdrive_link
            })
          })
          .then(res => res.json())
          .then(resp => {
            if (resp.success) {
              alert('Link Google Drive berhasil diperbarui!');
              modal.classList.add('hidden');
              location.reload();
            } else {
              errorDiv.textContent = resp.message || 'Gagal memperbarui link.';
              errorDiv.classList.remove('hidden');
            }
          })
          .catch(() => {
            errorDiv.textContent = 'Gagal memperbarui link.';
            errorDiv.classList.remove('hidden');
          });
        };
      };

      if (data.komentar) {
          document.getElementById('detail-alasan').textContent = data.komentar;
          document.getElementById('alasan-box').classList.remove('hidden');
      } else {
          document.getElementById('alasan-box').classList.add('hidden');
      }


      /**
       * Tampilkan dokumen:
       * - Jika ada link Google Drive, tampilkan hanya baris link Google Drive dan sembunyikan semua baris file PDF.
       * - Jika tidak ada link Google Drive, tampilkan file-file PDF yang tersedia, baris lain disembunyikan.
       */
      const gdriveRow = document.getElementById('gdrive-link-row');
      const gdriveAnchor = document.getElementById('gdrive-link-anchor');
      if (data.gdrive_link) {
        gdriveAnchor.href = data.gdrive_link;
        gdriveAnchor.textContent = data.gdrive_link;
        gdriveRow.classList.remove('hidden');
        // Sembunyikan semua baris file PDF
        ['surat_permohonan', 'surat_institusi', 'protokol_etik', 'informed_consent', 'proposal_penelitian', 'sertifikat_gcp', 'cv'].forEach(field => {
          const linkElem = document.getElementById(`link-${field}`);
          if (linkElem) linkElem.parentElement.classList.add('hidden');
        });
      } else {
        gdriveRow.classList.add('hidden');
        // Tampilkan file-file PDF yang tersedia
        ['surat_permohonan', 'surat_institusi', 'protokol_etik', 'informed_consent', 'proposal_penelitian', 'sertifikat_gcp', 'cv'].forEach(field => {
          const linkElem = document.getElementById(`link-${field}`);
          if (data[field]) {
            linkElem.href = data[field];
            linkElem.textContent = "Lihat File";
            linkElem.classList.remove('hidden');
            linkElem.parentElement.classList.remove('hidden');
          } else {
            linkElem.classList.add('hidden');
            linkElem.parentElement.classList.add('hidden');
          }
        });
      }

      const reviewButton = document.getElementById('btn-review');
      reviewButton.removeAttribute('onclick');
      reviewButton.onclick = () => loadReview(data.id);

      const hasilButton = document.getElementById('btn-hasil');
      hasilButton.removeAttribute('onclick');
      hasilButton.onclick = () => loadHasil(data.id);
    }

    function closeModal() {
      document.getElementById('detailModal').classList.add('hidden');
    }

    function openEditModal() {
      const nomorProtokolAsli = document.getElementById('detail-nomor-asli').textContent;
      const nomorProtokol = document.getElementById('detail-nomor').textContent;

      document.getElementById('nomor_protokol_asli').value = nomorProtokolAsli.trim();
      document.getElementById('nomor_protokol').value = nomorProtokol.trim();
      
      document.getElementById('editDokumenModal').classList.remove('hidden');
    }

    function tutupModalError() {
        document.getElementById('modalError').classList.add('hidden');
        document.getElementById('modalError').classList.remove('flex');
    }
    
    function tutupModalSuccess() {
        const modal = document.getElementById('modalSuccess');
        if (modal) modal.classList.add('hidden');
    }

    function loadReview(protocolId) {
          fetch(`/peneliti/penelitian/review/${protocolId}`)
            .then(res => res.json())
            .then(data => openModalReviewList(data))
            .catch(err => {
              alert('Gagal mengambil data review');
              console.error(err);
            });
    }

    function getBadgeColor(hasil) {
          const result = hasil.toLowerCase();
          if (result.includes("diterima")) {
            return { bg: 'bg-green-100', text: 'text-green-700' };
          } else {
            return { bg: 'bg-red-100', text: 'text-red-700' };
          }
        }

        function getColorCatatan(catatan){
            const result = catatan.toLowerCase();
          if (result.includes("tidak ada catatan")) {
            return { text: 'text-gray-400 italic' };
          } else {
            return { text: 'text-gray-800' };
          }
    }

    function openModalReviewList(reviews) {
          const container = document.getElementById('review_list');
          document.getElementById('modalReview').classList.remove('hidden');
          container.innerHTML = '';

          if (reviews.length === 0) {
            container.innerHTML = `
              <div class="text-center text-gray-500 italic">
                <svg class="mx-auto mb-2 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4h6v4m-3 4a9 9 0 100-18 9 9 0 000 18z" />
                </svg>
                Tidak ada review tersedia.
              </div>
            `;
            return;
          }
      
          reviews.forEach((review, i) => {
            const color = getBadgeColor(review.hasil);
            const colorCatatan = getColorCatatan(review.catatan);
        
            const item = document.createElement('div');
            item.className = 'bg-gray-100 hover:shadow-xl transition-all ease-in-out duration-700 ease-in-out shadow-md border border-gray-500 rounded-xl p-6 space-y-4';
        
            item.innerHTML = `
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">${review.nama}</h3>
                  <p class="text-sm text-gray-500">Ditinjau pada ${review.tanggal}</p>
                </div>
                <span class="inline-block text-sm px-3 py-1 rounded-full font-medium ${color.bg} ${color.text}">
                  ${review.hasil}
                </span>
              </div>
          
              <div>
                <p class="text-sm text-gray-600 mb-1 font-semibold">Catatan Reviewer:</p>
                <div class="bg-white ${colorCatatan.text} border border-gray-500 rounded-md p-4 text-sm leading-relaxed whitespace-pre-line">${review.catatan}
                </div>
              </div>
            `;
          
              container.appendChild(item);
            });
    }

    function closeModalReview() {
        document.getElementById('modalReview').classList.add('hidden');
    }

    function loadHasil(id) {
      fetch(`/peneliti/penelitian/keputusan/${id}`)
        .then(res => res.json())
        .then(data => showKeputusanModal(data))
        .catch(err => {
          alert('Gagal memuat hasil keputusan.');
          console.error(err);
        });
    }
    
    function showKeputusanModal(data) {
      const container = document.getElementById('keputusanContent');
      container.innerHTML = '';

      if (!data || !data.hasil_akhir) {
        container.innerHTML = `
          <div class="text-center text-gray-500 italic">
            <svg class="mx-auto mb-2 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4h6v4m-3 4a9 9 0 100-18 9 9 0 000 18z" />
            </svg>
            Belum ada keputusan akhir untuk protokol ini.
          </div>
        `;
      } else {
        container.innerHTML = `
          <div class="bg-gray-50 rounded-xl border border-gray-300 p-4">
            <p><strong>Hasil Keputusan:</strong></p>
            <div class="mt-2 px-3 py-2 rounded-lg font-semibold text-white 
              ${data.hasil_akhir === 'Diterima' ? 'bg-green-600' : 'bg-red-600'}">
              ${data.hasil_akhir}
            </div>
          </div>
        
          <div>
            <p class="font-medium text-gray-600 mt-4">Tanggal Keputusan:</p>
            <p>${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
          </div>
        
          <div>
            <p class="font-medium text-gray-600 mt-4">Komentar Tambahan:</p>
            <p class="whitespace-pre-line text-gray-600">${data.catatan ?? 'Tidak ada catatan tambahan.'}</p>
          </div>

          <div class="flex items-center justify-between border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50 transition">
            <span class="font-medium text-gray-800">Surat Lulus Etik</span>
            ${data.path ? 
              `<a href="${data.path}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>` : 
              `<span class="text-gray-500 italic">Belum ada file</span>`
            }
          </div>
        `;
      }
    
      document.getElementById('modalKeputusan').classList.remove('hidden');
    }

    function closeModalKeputusan() {
      document.getElementById('modalKeputusan').classList.add('hidden');
    }


  </script>
</x-Layout>
