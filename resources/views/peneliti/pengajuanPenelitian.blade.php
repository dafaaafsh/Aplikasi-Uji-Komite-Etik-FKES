<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>

  <!-- Informasi Penting -->
  <div class="bg-blue-50 border border-blue-300 text-blue-800 p-5 rounded-xl shadow mb-8">
    <h3 class="text-base font-semibold text-blue-800 mb-1">Keterangan</h3>
      <p class="text-sm text-gray-800 leading-relaxed">
        Anda dapat mengajukan penelitian berdasarkan <span class="font-semibold">Nomor Protokol</span> 
        yang telah disetujui sebelumnya, dengan mengunggah seluruh dokumen pendukung dalam format 
        <span class="font-semibold text-red-600">PDF</span>.
        
        <span class="font-semibold text-blue-700">Setiap nomor protokol hanya dapat digunakan satu kali</span> 
        untuk satu penelitian. Pastikan seluruh dokumen lengkap dan sesuai sebelum mengirimkan pengajuan.
        
        Setelah pengajuan berhasil dikirimkan, Anda dapat memantau statusnya melalui menu 
        <span class="font-semibold">"Penelitian Saya"</span> pada sidebar aplikasi.
      </p>
  </div>

  {{-- Status Pengajuan --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
    <!-- Belum Diajukan -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-yellow-500">
      <div class="flex gap-4">
        <div class="text-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-yellow-700">Belum Diajukan</p>
          <p class="text-sm text-gray-700">Lakukan pengajuan dokumen penelitian anda pada form <strong>Pengajuan Penelitian</strong>.</p>
        </div>
      </div>
      <span class="text-yellow-700 font-bold text-lg bg-yellow-100 rounded-full px-3 py-1">
        {{ $protocols->where('tanggal_pengajuan', null)->count() }}
      </span>
    </div>
  
    <!-- Telah Diajukan -->
    <div class="flex items-start justify-between p-5 bg-white rounded-xl shadow border-l-4 border-green-500">
      <div class="flex gap-4">
        <div class="text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <div>
          <p class="font-bold text-green-700">Telah Diajukan</p>
          <p class="text-sm text-gray-700">Pengajuan dokumen penelitian anda telah selesai diajukan.</p>
        </div>
      </div>
      <span class="text-green-700 font-bold text-lg bg-green-100 rounded-full px-3 py-1">
        {{ $protocols->whereNotNull('tanggal_pengajuan')->count() }}
      </span>
    </div>
  </div>

  <!-- Tabel Nomor Protokol -->
  <div class="mt-10 bg-white rounded-2xl shadow-lg overflow-auto border border-gray-200">
    <div class="px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-t-2xl">
      <h2 class="text-lg font-semibold">Tabel Protokol Saya</h2>
      <p class="text-sm text-sky-100">Menampilkan daftar nomor protokol yang telah dibayar oleh anda di Uji Komite Etik Fakultas Kesehatan Universitas Nurul Jadid</p>
    </div>
    <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200">
      <table class="min-w-full text-sm text-gray-800 divide-y divide-gray-200">
        <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
          <tr>
            <th class="px-6 py-3 text-center">Nomor Protokol</th>
            <th class="px-6 py-3 text-center">Judul Penelitian</th>
            <th class="px-6 py-3 text-center">Status Pengajuan</th>
            <th class="px-6 py-3 text-center">Tanggal Diajukan</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-300">
          @forelse ($protocols as $item)
          <tr class="odd:bg-white even:bg-gray-200">
            <td class="px-10 py-4 text-blue-600 font-medium whitespace-nowrap">{{ $item->nomor_protokol_asli }}</td>
            <td class="px-6 py-4">{{ Str::words($item->judul, 6) }}</td>
            <td class="px-6 py-4 text-center">
              <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $item->tanggal_pengajuan ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $item->tanggal_pengajuan ? 'Telah Diajukan' : 'Belum Diajukan' }}
              </span>
            </td>
            <td class="px-6 py-4 text-center {{ $item->tanggal_pengajuan ? '' : 'text-gray-500 italic' }}">
              {{ $item->tanggal_pengajuan 
                ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('D, j F Y') 
                : 'Belum Diajukan' }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8"
            class="px-6 py-4 text-center text-md italic text-gray-400 font-semibold">
              Belum ada nomor protokol yang terdaftar
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

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

  <!-- Form Pengajuan -->
  <div class="mt-12 bg-white rounded-xl shadow-xl p-8 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Form Pengajuan Penelitian</h2>
    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Nomor Protokol -->
      <div>
        <label for="nomor_protokol" class="block text-sm font-medium text-gray-700">Nomor Protokol</label>
        <select id="nomor_protokol" name="nomor_protokol" required
          class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm h-10 focus:ring-blue-500 focus:border-blue-500">
          <option value="">-- Pilih Nomor Protokol --</option>
          @foreach ($protocols as $item)
            @if (empty($item->tanggal_pengajuan) && !empty($item->nomor_protokol))
              <option value="{{ $item->nomor_protokol }}">{{ $item->nomor_protokol_asli }} 
              </option>
            @endif
          @endforeach
        </select>
      </div>

      <!-- File Uploads -->
      @php
      $fields = [
        'surat_permohonan' => 'Surat Permohonan Uji Kaji Etik Penelitian',
        'surat_institusi' => 'Surat Keterangan dari Institusi',
        'protokol_etik' => 'Protokol Etik Penelitian',
        'informed_consent' => 'Informed Consent / Penjelasan Sebelum Penelitian',
        'proposal_penelitian' => 'Proposal Penelitian Lengkap + Instrumen',
        'sertifikat_gcp' => 'Sertifikat Good Clinical Practice (Opsional)',
        'cv' => 'Curriculum Vitae (CV)'
      ];
      @endphp

      @foreach ($fields as $name => $label)
      <div>
        <label class="block text-sm font-medium text-gray-700">{{ $label }} (PDF)</label>
        <input type="file" name="{{ $name }}" accept="application/pdf"
          {{ $name !== 'sertifikat_gcp' ? '' : '' }}
          class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg file:bg-blue-50 file:border-0 file:py-2 file:px-4 file:text-blue-600 file:font-semibold hover:file:bg-blue-100" />
      </div>
      @endforeach

      <!-- Submit -->
      <div class="text-right">
        <button type="submit"
          class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
          Kirim Pengajuan
        </button>
      </div>
    </form>
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
  </script>
</x-Layout>
