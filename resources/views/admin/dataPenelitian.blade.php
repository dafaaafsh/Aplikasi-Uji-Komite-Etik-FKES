<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>

  <div class="p-6">

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

    <!-- Filter & Search -->
        <div class=" px-6 py-4 bg-gradient-to-r flex from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
      <div class="flex gap-2 items-center">
        <label class="font-medium">Status:</label>
        <select id="statusFilter" class="border rounded-md px-3 py-1 text-sm">
          <option value="">Semua</option>
          <option value="Diperiksa">Diperiksa</option>
          <option value="Ditelaah">Ditelaah</option>
          <option value="Selesai">Selesai</option>
          <option value="Dikembalikan">Dikembalikan</option>
        </select>
      </div>
      <input type="text" id="searchInput" placeholder="Cari Judul / Peneliti / No. Protokol" 
        class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full md:w-1/3" />
    </div>

    <!-- Tabel Data Penelitian -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-700 font-semibold">
          <tr>
            <th class="px-4 py-2">No</th>
            <th class="px-4 py-2">No. Protokol</th>
            <th class="px-4 py-2">Judul</th>
            <th class="px-4 py-2">Peneliti</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Telaah</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="monitoringTable">
          @forelse($protocols as $index => $protokol)
          <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ $loop->iteration }}</td>
            <td class="px-4 py-2">{{ $protokol->nomor_protokol_asli }}</td>
            <td class="px-4 py-2">{{ Str::limit($protokol->judul, 40) }}</td>
            <td class="px-4 py-2">{{ $protokol->peneliti->name ?? '-' }}</td>
            <td class="px-4 py-2">
              <span class="px-2 py-1 rounded-full text-xs font-medium 
                @if($protokol->status_penelitian == 'Diperiksa') bg-yellow-100 text-yellow-800 
                @elseif($protokol->status_penelitian == 'Ditelaah') bg-blue-100 text-blue-800 
                @elseif($protokol->status_penelitian == 'Selesai') bg-green-100 text-green-800 
                @else bg-red-100 text-red-800 @endif">
                {{ $protokol->status_penelitian }}
              </span>
            </td>
            <td class="px-4 py-2">
              <span class="px-2 py-1 rounded-full text-xs font-medium 
                @if($protokol->status_telaah == 'Telaah Awal') bg-yellow-100 text-yellow-800 
                @elseif($protokol->status_telaah == 'Telaah Lanjutan') bg-blue-100 text-blue-800 
                @elseif($protokol->status_telaah == 'Telaah Akhir') bg-purple-100 text-purple-800 
                @elseif($protokol->status_telaah == 'Selesai') bg-green-100 text-green-800 
                @else bg-red-100 text-red-800 @endif">
                {{ $protokol->status_telaah }}
              </span>
            </td>
            <td class="px-4 py-2">{{ $protokol->created_at->format('d M Y') }}</td>
            <td class="px-4 py-2 text-center flex gap-1">
                <button onclick="loadDetailData({{ $protokol->id }})"
                    class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Detail
                </button>
                @if ($protokol->putusan->path)
                  <a href="{{ asset('private/protokol/'.$protokol->nomor_protokol.'/'.$protokol->putusan->path) }}" target="_blank"
                    class="px-3 py-1 text-sm bg-yellow-600 hover:bg-yellow-700 text-white rounded">
                    Surat
                  </a>
                @else
                  <form action="{{ route('admin.uploadSuratLulus', $protokol->id) }}" method="POST" enctype="multipart/form-data" class="inline">
                    @csrf
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="file" name="surat_lulus" accept="application/pdf" class="hidden" onchange="this.form.submit()">
                        <span class="px-3 py-1 text-sm bg-green-600 hover:bg-green-700 text-white rounded">Upload</span>
                    </label>
                </form>
                @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="italic font-semibold px-4 py-4 text-center text-gray-500">
              Belum ada penelitian yang terdaftar.
            </td>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $protocols->links() }}
    </div>
  </div>

  <div id="modalDetailPengajuan" class="fixed inset-0 z-50 hidden flex items-start justify-center bg-black/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex items-start justify-center min-h-screen px-4 py-8">
          <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-8 relative border border-gray-300">

            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
      
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pengajuan Penelitian</h2>
      
            <!-- Info Peneliti -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
              <div>
                <p class="font-semibold">Nama Peneliti</p>
                <p id="d_nama" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Email</p>
                <p id="d_email">-</p>
              </div>
              <div>
                <p class="font-semibold">Nomor HP</p>
                <p id="d_hp">-</p>
              </div>
              <div>
                <p class="font-semibold">Institusi</p>
                <p id="d_institusi">-</p>
              </div>
              <div>
                <p class="font-semibold">Alamat</p>
                <p id="d_asal">-</p>
              </div>
              <div>
                <p class="font-semibold">Status Peneliti</p>
                <p id="d_status">-</p>
              </div>
            </div>
      
            <hr class="my-6 border-gray-300">
      
            <!-- Info Penelitian -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
              <div>
                <p class="font-semibold">Nomor Protokol</p>
                <p id="d_nomor_protokol" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Judul Penelitian</p>
                <p id="d_judul">-</p>
              </div>
              <div>
                <p class="font-semibold">Subjek Penelitian</p>
                <p id="d_subjek">-</p>
              </div>
              <div>
                <p class="font-semibold">Jenis Penelitian</p>
                <p id="d_jenis_penelitian">-</p>
              </div>
              <div>
                <p class="font-semibold">Jenis Pengajuan</p>
                <p id="d_jenis_pengajuan">-</p>
              </div>
              <div>
                <p class="font-semibold">Biaya Penelitian</p>
                <p id="d_biaya">-</p>
              </div>
              <div>
                <p class="font-semibold">Tanggal Pengajuan</p>
                <p id="d_tanggal">-</p>
              </div>
            </div>
      
            <hr class="my-6 border-gray-300">
      
            <!-- Dokumen -->
            <div class="mt-8">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Terkait</h3>
              <div class="space-y-3 text-sm text-gray-700 max-h-[40vh] overflow-y-auto pr-1">
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
              </div>
            </div>

            {{-- keputusan --}}
            <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-4">Hasil keputusan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
              <div>
                <p class="font-semibold">Hasil Keputusan</p>
                <p id="d_hasil_keputusan" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Tanggal Keputusan</p>
                <p id="d_tanggal_keputusan" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Penerimaan</p>
                <p id="d_penerimaan" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Catatan</p>
                <p id="d_catatan" class="text-gray-900">-</p>
              </div>
              <div>
                <p class="font-semibold">Lampiran Keputusan</p>
                  <a id="d_lampiran" href="#" target="_blank"
                    class="text-blue-600 hover:underline">Lihat</a>
              </div>
            </div>
          </div>
        </div>


  </div>


    <script>
        function loadDetailData(id) {
            fetch(`/admin/pengajuanPenelitian/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('d_nama').textContent = data.nama ?? '-';
                    document.getElementById('d_email').textContent = data.email ?? '-';
                    document.getElementById('d_asal').textContent = data.asal ?? '-';
                    document.getElementById('d_institusi').textContent = data.institusi ?? '-';
                    document.getElementById('d_hp').textContent = data.hp ?? '-';
                    document.getElementById('d_status').textContent = data.status ?? '-';
                
                    document.getElementById('d_nomor_protokol').textContent = data.nomor_protokol_asli ?? '-';
                    document.getElementById('d_judul').textContent = data.judul ?? '-';
                    document.getElementById('d_subjek').textContent = data.subjek ?? '-';
                    document.getElementById('d_jenis_penelitian').textContent = data.jenis_penelitian ?? '-';
                    document.getElementById('d_jenis_pengajuan').textContent = data.jenis_pengajuan ?? '-';
                    document.getElementById('d_biaya').textContent = data.biaya ?? '-';
                    document.getElementById('d_tanggal').textContent = data.tanggal_pengajuan ?? '-';

                    document.getElementById('d_hasil_keputusan').textContent = data.hasil_akhir ?? '-';
                    document.getElementById('d_tanggal_keputusan').textContent = data.tanggal_keputusan ?? '-';
                    document.getElementById('d_penerimaan').textContent = data.penerimaan ?? '-';
                    document.getElementById('d_catatan').textContent = data.komentar ?? '-';
                    const lampiranLink = document.getElementById('d_lampiran');
                    if (data.lampiran_keputusan) {
                        lampiranLink.href = data.lampiran_keputusan;
                        lampiranLink.classList.remove('hidden');
                    } else {
                        lampiranLink.href = '#';
                        lampiranLink.classList.add('hidden');
                    }

                    if(data.hasil_akhir === 'Diterima') {
                        document.getElementById('d_hasil_keputusan').classList.add('text-green-600', 'font-semibold');
                    }else if(data.hasil_akhir === 'Ditolak') {
                        document.getElementById('d_hasil_keputusan').classList.add('text-red-600', 'font-semibold');
                    } else {
                        document.getElementById('d_hasil_keputusan').classList.add('text-gray-600');
                    }
                
                    const dokumenFields = [
                        'surat_permohonan',
                        'surat_institusi',
                        'protokol_etik',
                        'informed_consent',
                        'proposal_penelitian',
                        'sertifikat_gcp',
                        'cv'
                    ];
                
                    dokumenFields.forEach(key => {
                        const link = document.getElementById('link-' + key);
                        if (data[key]) {
                            link.href = data[key];
                            link.classList.remove('hidden');
                        } else {
                            link.href = '#';
                            link.classList.add('hidden');
                        }
                    });
                
                    const modal = document.getElementById('modalDetailPengajuan');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                })
                .catch(err => {
                    alert('Gagal memuat data detail.');
                    console.error(err);
                });
        }

        function closeModal() {
            const modal = document.getElementById('modalDetailPengajuan');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
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
