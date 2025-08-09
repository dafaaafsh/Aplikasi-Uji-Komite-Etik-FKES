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
    <form id="pengajuanForm" action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateAllFileInputs(event)">
      <div class="mb-6">
        <label class="block text-md font-semibold text-gray-700 mb-2">Pilih Metode Pengajuan</label>
        <div class="flex gap-6">
          <label class="inline-flex items-center">
            <input type="radio" name="submission_mode" value="upload" checked onclick="toggleSubmissionMode('upload')" class="form-radio text-blue-600" />
            <span class="ml-2">Upload Semua Dokumen (PDF)</span>
          </label>
          <label class="inline-flex items-center">
            <input type="radio" name="submission_mode" value="gdrive" onclick="toggleSubmissionMode('gdrive')" class="form-radio text-blue-600" />
            <span class="ml-2">Upload Link Google Drive</span>
          </label>
        </div>
        <p class="text-xs text-gray-500 mt-2">Pilih salah satu metode: upload seluruh dokumen PDF <span class="font-semibold">atau</span> cukup kirimkan satu link Google Drive berisi semua dokumen.</p>
      </div>
  <script>
    // Validasi semua file input sebelum submit form
    function validateAllFileInputs(e) {
      let valid = true;
      const form = document.getElementById('pengajuanForm');
      const fileInputs = form.querySelectorAll('input[type="file"]');
      fileInputs.forEach(input => {
        validateFileInput(input);
        const id = input.id;
        const error = document.getElementById('error-' + id);
        if (error && !error.classList.contains('hidden')) {
          valid = false;
        }
      });
      if (!valid) {
        e.preventDefault();
        // Scroll ke error pertama
        const firstError = form.querySelector('span.text-red-600:not(.hidden)');
        if (firstError) {
          firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
        return false;
      }
      showLoadingUpload(e);
      return true;
    }
  </script>
      @csrf

      <!-- Nomor Protokol -->
      <div>
        <label for="nomor_protokol" class="block text-sm font-medium text-gray-700">Nomor Protokol</label>
        <select id="nomor_protokol" name="nomor_protokol" required
          class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm h-10 focus:ring-blue-500 focus:border-blue-500 @error('nomor_protokol') border-red-500 @enderror">
          <option value="">-- Pilih Nomor Protokol --</option>
          @foreach ($protocols as $item)
            @if (empty($item->tanggal_pengajuan) && !empty($item->nomor_protokol))
              <option value="{{ $item->nomor_protokol }}" {{ old('nomor_protokol') == $item->nomor_protokol ? 'selected' : '' }}>{{ $item->nomor_protokol_asli }} 
              </option>
            @endif
          @endforeach
        </select>
        @error('nomor_protokol')
          <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
      </div>


      <!-- File Uploads (default) -->
      <div id="uploadFieldsSection">
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
          <label class="block text-md font-medium text-gray-700 mb-1" for="{{ $name }}">
            {{ $label }} (PDF)
            @if($name === 'sertifikat_gcp')
              <span class="ml-1 text-blue-600 text-xs font-semibold align-middle">(Opsional)</span>
            @else
              <span class="ml-1 text-red-500 text-xs font-semibold align-middle">(Wajib diisi)</span>
            @endif
          </label>
          <p class="text-xs text-gray-500 mb-1">
            <span class="block mb-1">
              <span class="font-semibold">Ketentuan:</span> File <span class="font-semibold text-blue-700">PDF</span>, maksimal <span class="font-semibold">10MB</span>
            </span>
          </p>
          <div class="relative">
            <input type="file" id="{{ $name }}" name="{{ $name }}" accept="application/pdf"
              class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg file:bg-blue-50 file:border-0 file:py-2 file:px-4 file:text-blue-600 file:font-semibold hover:file:bg-blue-100 @error($name) border-red-500 @enderror pr-10"
              onchange="showFileProgressAndPreview(this)" 
              @if($name !== 'sertifikat_gcp') @endif
              oninput="validateFileInput(this)"
              data-label="{{ $label }}"
              data-max="10485760"
            />
            <div class="w-full h-2 bg-gray-200 rounded mt-2 overflow-hidden" id="progressbar-{{ $name }}" style="display:none;">
              <div class="h-2 bg-blue-500 transition-all duration-300" style="width:0%"></div>
            </div>
            <div id="preview-{{ $name }}" class="mt-3 hidden"></div>
            <span class="text-xs text-red-600 mt-1 block hidden" id="error-{{ $name }}"></span>
            <span class="text-xs text-gray-500 mt-1 block hidden" id="size-{{ $name }}"></span>
          </div>
          @error($name)
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
          @enderror
        </div>
        @endforeach
      </div>

      <!-- Google Drive Link Section (hidden by default) -->
      <div id="gdriveSection" style="display:none;">
        <div>
          <label for="gdrive_link" class="block text-md font-medium text-gray-700 mb-1">
            Link Google Drive <span class="ml-1 text-red-500 text-xs font-semibold align-middle">(Wajib diisi jika memilih opsi ini)</span>
          </label>
          <p class="text-xs text-gray-500 mb-1">
            <span class="block mb-1">
              <span class="font-semibold">Ketentuan:</span> Link Google Drive harus dapat diakses publik (siapa saja yang memiliki link dapat melihat & mengunduh dokumen PDF yang diperlukan).
            </span>
            <span class="block">Pastikan seluruh dokumen sudah diunggah ke folder Google Drive dan <span class="font-semibold">izin akses sudah diatur</span>.</span>
          </p>
          <input type="url" id="gdrive_link" name="gdrive_link" class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm h-10 focus:ring-blue-500 focus:border-blue-500 @error('gdrive_link') border-red-500 @enderror" placeholder="https://drive.google.com/..." />
          <span class="text-xs text-red-600 mt-1 block hidden" id="error-gdrive_link"></span>
          @error('gdrive_link')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <!-- Submit -->
      <div class="text-right">
        <button id="submitBtn" type="submit"
          class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
          <span id="submitBtnText">Kirim Pengajuan</span>
          <svg id="loadingSpinner" class="w-5 h-5 ml-2 hidden animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
        </button>
      </div>
    </form>
  </div>


  <script>
    // Toggle between upload fields and gdrive link
    function toggleSubmissionMode(mode) {
      const uploadSection = document.getElementById('uploadFieldsSection');
      const gdriveSection = document.getElementById('gdriveSection');
      if (mode === 'gdrive') {
        uploadSection.style.display = 'none';
        gdriveSection.style.display = 'block';
      } else {
        uploadSection.style.display = 'block';
        gdriveSection.style.display = 'none';
      }
    }

    // Simulate per-field progress bar and show PDF preview on file select
    function showFileProgressAndPreview(input) {
      const id = input.id;
      const barWrap = document.getElementById('progressbar-' + id);
      const preview = document.getElementById('preview-' + id);
      const error = document.getElementById('error-' + id);
      if (!barWrap) return;
      const bar = barWrap.querySelector('div');
      bar.style.width = '0%';
      barWrap.style.display = 'block';
      if (preview) preview.classList.add('hidden');
      if (error) error.classList.add('hidden');
      // Show file size if selected
      const sizeInfo = document.getElementById('size-' + id);
      if (sizeInfo) {
        if (input.files && input.files[0]) {
          sizeInfo.textContent = 'Ukuran file: ' + formatBytes(input.files[0].size);
          sizeInfo.classList.remove('hidden');
        } else {
          sizeInfo.textContent = '';
          sizeInfo.classList.add('hidden');
        }
      }
      let progress = 0;
      bar.style.transition = 'none';
      function animate() {
        progress += Math.random() * 30 + 20;
        if (progress >= 100) progress = 100;
        bar.style.width = progress + '%';
        bar.style.transition = 'width 0.3s';
        if (progress < 100) {
          setTimeout(animate, 200);
        } else {
          setTimeout(() => { barWrap.style.display = 'none'; }, 600);
          // PDF preview & validation
          validateFileInput(input);
          if (input.files && input.files[0] && input.files[0].type === 'application/pdf') {
            const file = input.files[0];
            const url = URL.createObjectURL(file);
            if (preview) {
              preview.innerHTML = `<iframe src='${url}#toolbar=0&navpanes=0&scrollbar=0' class='w-full rounded border border-gray-200' style='height:340px;'></iframe>`;
              preview.classList.remove('hidden');
            }
          } else if (preview) {
            preview.innerHTML = '';
            preview.classList.add('hidden');
          }
        }
      }
      animate();
    }

    // Format bytes to readable size
    function formatBytes(bytes) {
      if (bytes === 0) return '0 B';
      const k = 1024;
      const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Client-side validation sesuai rules controller
    function validateFileInput(input) {
      const id = input.id;
      const error = document.getElementById('error-' + id);
      if (!error) return;
      error.textContent = '';
      error.classList.add('hidden');
      const file = input.files[0];
      const label = input.getAttribute('data-label') || 'File';
      const max = parseInt(input.getAttribute('data-max') || '10485760');
      // Show file size info
      const sizeInfo = document.getElementById('size-' + id);
      if (sizeInfo) {
        if (file) {
          sizeInfo.textContent = 'Ukuran file: ' + formatBytes(file.size);
          sizeInfo.classList.remove('hidden');
        } else {
          sizeInfo.textContent = '';
          sizeInfo.classList.add('hidden');
        }
      }
      if (!file) return;
      if (file.type !== 'application/pdf') {
        error.textContent = label + ' harus berupa file PDF';
        error.classList.remove('hidden');
        input.value = '';
        return;
      }
      if (file.size > max) {
        error.textContent = label + ' maksimal 10MB';
        error.classList.remove('hidden');
        input.value = '';
        return;
      }
    }

    // Validate GDrive link (simple)
    function validateGDriveLink() {
      const input = document.getElementById('gdrive_link');
      const error = document.getElementById('error-gdrive_link');
      if (!input) return true;
      error.textContent = '';
      error.classList.add('hidden');
      if (!input.value) {
        error.textContent = 'Link Google Drive wajib diisi.';
        error.classList.remove('hidden');
        return false;
      }
      // Simple pattern check
      if (!/^https:\/\/(drive|docs)\.google\.com\//.test(input.value)) {
        error.textContent = 'Link harus berupa URL Google Drive yang valid.';
        error.classList.remove('hidden');
        return false;
      }
      return true;
    }

    // Overwrite form validation to support dual mode
    function validateAllFileInputs(e) {
      const mode = document.querySelector('input[name="submission_mode"]:checked').value;
      let valid = true;
      if (mode === 'upload') {
        const form = document.getElementById('pengajuanForm');
        const fileInputs = form.querySelectorAll('#uploadFieldsSection input[type="file"]');
        fileInputs.forEach(input => {
          validateFileInput(input);
          const id = input.id;
          const error = document.getElementById('error-' + id);
          if (error && !error.classList.contains('hidden')) {
            valid = false;
          }
        });
        if (!valid) {
          e.preventDefault();
          // Scroll ke error pertama
          const firstError = form.querySelector('span.text-red-600:not(.hidden)');
          if (firstError) {
            firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
          }
          return false;
        }
        showLoadingUpload(e);
        return true;
      } else if (mode === 'gdrive') {
        // Only validate gdrive link
        if (!validateGDriveLink()) {
          e.preventDefault();
          const error = document.getElementById('error-gdrive_link');
          if (error) error.scrollIntoView({behavior: 'smooth', block: 'center'});
          return false;
        }
        showLoadingUpload(e);
        return true;
      }
      return true;
    }
  </script>

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
