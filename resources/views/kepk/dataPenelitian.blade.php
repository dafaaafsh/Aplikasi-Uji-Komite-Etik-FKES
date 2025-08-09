<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-4">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Daftar Penelitian </h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah data semua penelitian yang telah didaftarkan pada sistem Uji Komite Etik. 
                    Anda dapat mencari berdasarkan judul penelitian, nama peneliti, atau nomor protokol.
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('kepk.dataPenelitian') }}" class="flex flex-wrap items-end justify-between gap-4 p-4 bg-blue-100 text-sm">

            <div class="flex gap-6">
                <div class="flex flex-col">
                    <label for="search" class="text-xs font-semibold text-gray-700 mb-1">Cari Judul / Peneliti / No. Protokol</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900 focus:outline-none"
                        placeholder="Ketik kata kunci...">
                </div>
                <div class="flex flex-col">
                    <label for="status" class="text-xs font-semibold text-gray-700 mb-1">Status Telaah</label>
                    <select name="status" id="telaah" onchange="this.form.submit()"
                    class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900">
                        <option value="">Semua</option>
                        <option value="TelaahAwal" {{ request('status') == 'TelaahAwal' ? 'selected' : '' }}>Telaah Awal</option>
                        <option value="TelaahLanjutan" {{ request('status') == 'TelaahLanjutan' ? 'selected' : '' }}>Telaah Lanjutan</option>
                        <option value="TelaahAkhir" {{ request('status') == 'TelaahAkhir' ? 'selected' : '' }}>Telaah Akhir</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>
            
        
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
            </div>
        </form>
        @if(request('search') || request('status'))
            <div class="px-6 py-2 bg-yellow-200 text-sm text-gray-700">
                <span class="font-semibold">Filter Aktif:</span>
                @if(request('search'))
                    Pencarian "<span class="text-blue-700">{{ request('search') }}</span>"
                @endif
                @if(request('status'))
                    | Status: <span class="text-blue-700">{{ request('status') }}</span>
                @endif

                <span class="text-xs">- Tersedia {{ $data->total() }} data</span>
            </div>
        @endif

        <div class="bg-white shadow-md overflow-auto">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-2 py-4 text-center">No. Protokol</th>
                        <th class="px-4 py-4 text-center">Judul</th>
                        <th class="px-4 py-4 text-center">Peneliti</th>
                        <th class="px-4 py-4 text-center">Status Telaah</th>
                        <th class="px-4 py-4 text-center">Detail</th>
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($data as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-2 py-3 text-center font-semibold">
                            @if ($item->status_telaah === 'Telaah Awal')
                                <span class="px-2 py-1 bg-yellow-500 text-white rounded-full text-xs">{{ $item->status_telaah }}</span>
                            @elseif($item->status_telaah === "Telaah Lanjutan")
                                <span class="px-2 py-1 bg-blue-600 text-white rounded-full text-xs">{{ $item->status_telaah }}</span>
                            @elseif($item->status_telaah === "Telaah Akhir")
                                <span class="px-2 py-1 bg-amber-800 text-white rounded-full text-xs">{{ $item->status_telaah }}</span>
                            @elseif ($item->status_telaah === "Selesai")
                                <span class="px-2 py-1 bg-green-600 text-white rounded-full text-xs">{{ $item->status_telaah }}</span>    
                            @endif

                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 justify-center">
                                <button onclick="loadDetailData({{ $item->id }})"
                                    class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Lihat
                                </button>                            
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-gray-200 flex justify-between py-4 px-10 items-center text-sm bg-gradient-to-r from-gray-900 to-gray-700 text-white">
            <p>
                Menampilkan {{ $data->firstItem() }} – {{ $data->lastItem() }} dari {{ $data->total() }} data
            </p>
            <div>
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div id="modalDetailPengajuan" class="fixed inset-0 z-50 hidden flex items-start justify-center bg-black/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex items-start justify-center min-h-screen px-4 py-8">
          <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-8 relative border border-gray-300">

            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
      
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Protokol Penelitian</h2>
      
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
              <div>
                <p class="font-semibold">Klasifikasi penelitian</p>
                <p id="d_kategori">-</p>
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
          </div>
        </div>
    </div>

    <script>
        function loadDetailData(id) {
            fetch(`/kepk/telaahAkhir/${id}`)
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
                    document.getElementById('d_kategori').textContent = data.kategori ?? '-';

                    // Tampilkan hanya link Google Drive jika ada, jika tidak tampilkan struktur file seperti biasa
                    let gdrive_link = data.gdrive_link;
                    let gdriveRow = document.getElementById('gdrive-link-row');
                    let gdriveAnchor = document.getElementById('gdrive-link-anchor');
                    if (!gdriveRow) {
                        // Tambahkan baris Google Drive link secara dinamis jika belum ada
                        const docContainer = document.querySelector('.mt-8 .space-y-3');
                        if (docContainer) {
                            gdriveRow = document.createElement('div');
                            gdriveRow.id = 'gdrive-link-row';
                            gdriveRow.className = 'flex items-center justify-between border border-gray-200 rounded-lg px-4 py-2 bg-green-50';
                            gdriveAnchor = document.createElement('a');
                            gdriveAnchor.id = 'gdrive-link-anchor';
                            gdriveAnchor.target = '_blank';
                            gdriveAnchor.className = 'text-green-700 font-semibold break-all';
                            gdriveRow.innerHTML = '<span class="font-medium text-gray-800">Google Drive Link</span>';
                            gdriveRow.appendChild(gdriveAnchor);
                            docContainer.prepend(gdriveRow);
                        }
                    }
                    if (gdriveRow && gdriveAnchor) {
                        if (gdrive_link) {
                            gdriveAnchor.href = gdrive_link;
                            gdriveAnchor.textContent = gdrive_link;
                            gdriveRow.classList.remove('hidden');
                            // Sembunyikan semua baris file PDF
                            ['surat_permohonan', 'surat_institusi', 'protokol_etik', 'informed_consent', 'proposal_penelitian', 'sertifikat_gcp', 'cv'].forEach(field => {
                                const linkElem = document.getElementById(`link-${field}`);
                                if (linkElem) linkElem.parentElement.classList.add('hidden');
                            });
                        } else {
                            if (gdriveRow) gdriveRow.classList.add('hidden');
                            // Tampilkan file-file PDF yang tersedia (struktur tidak berubah)
                            ['surat_permohonan', 'surat_institusi', 'protokol_etik', 'informed_consent', 'proposal_penelitian', 'sertifikat_gcp', 'cv'].forEach(field => {
                                const linkElem = document.getElementById(`link-${field}`);
                                if (linkElem) {
                                    if (data[field]) {
                                        linkElem.href = data[field];
                                        linkElem.classList.remove('hidden');
                                        linkElem.parentElement.classList.remove('hidden');
                                    } else {
                                        linkElem.classList.add('hidden');
                                        linkElem.parentElement.classList.add('hidden');
                                    }
                                }
                            });
                        }
                    }

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

        function closeModal() {
            const modal = document.getElementById('modalDetailPengajuan');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</x-Layout>