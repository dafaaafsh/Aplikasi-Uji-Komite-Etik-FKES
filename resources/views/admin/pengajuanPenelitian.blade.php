<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>
    <p class="mt-2 text-gray-600 text-base">
        Halaman ini menampilkan daftar pengajuan nomor protokol penelitian. 
        Admin dapat memeriksa kelengkapan dokumen, melihat detail pengajuan, serta menentukan apakah dokumen dapat 
        <strong>diteruskan ke KEPK</strong> atau <strong>dikembalikan untuk revisi oleh peneliti</strong>.
    </p>
    
    

    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-4">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Penelitian Masuk</h2>
                <p class="text-sm text-sky-100 mt-1">
                    Mohon pastikan setiap dokumen telah sesuai dengan ketentuan yang berlaku sebelum mengirimkan ke tahap berikutnya. 
                    Pengembalian dokumen hanya dilakukan apabila terdapat kekurangan atau ketidaksesuaian.
                </p>
            </div>
        </div> 

        <div class="bg-white shadow-md overflow-auto">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-2 py-4 text-center">No. Protokol</th>
                        <th class="px-4 py-4 text-center">Judul</th>
                        <th class="px-4 py-4 text-center">Peneliti</th>
                        <th class="px-4 py-4 text-center">Detail</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($needConfirmed as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="loadDetailPengajuan({{ $item->id }})"
                                class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Detail
                            </button>
                        </td>
                        <td class="px-2 py-3 text-center font-semibold">
                            <div class="flex gap-2 justify-center">
                                <button type="button"
                                    onclick="bukaModalKembalikan('{{ $item->id }}')"
                                    class="px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded">Kembalikan
                                </button>  
                                <button type="button"
                                    onclick="bukaModalLanjutkan('{{ $item->id }}')"
                                    class="px-3 py-1 text-sm text-white bg-green-600 hover:bg-green-700 rounded">Lanjutkan
                                </button>                                                                                      
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8"
                        class="px-6 py-4 bg-gray-100 text-center text-md italic text-gray-400 font-semibold">
                          Belum ada pengajuan data terbaru
                        </td>
                      </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-200 flex justify-between py-4 px-10 items-center text-sm bg-gradient-to-r from-gray-900 to-gray-700 text-white">
            <p>
                Menampilkan {{ $needConfirmed->firstItem() }} – {{ $needConfirmed->lastItem() }} dari {{ $needConfirmed->total() }} data
            </p>
            <div>
                {{ $needConfirmed->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-8">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Semua Penelitian</h2>
                <p class="text-sm text-sky-100 mt-1">
                    Di bawah ini adalah rekapitulasi seluruh pengajuan yang pernah masuk, baik yang telah diperiksa maupun yang belum.
                    Gunakan fitur pencarian atau filter untuk memudahkan pelacakan dokumen berdasarkan status atau kata kunci tertentu.
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.pengajuanPenelitian') }}" class="flex flex-wrap items-end justify-between gap-4 p-4 bg-blue-100 text-sm">
            <div class="flex gap-x-6">
                <div class="flex flex-col">
                    <label for="search" class="text-xs font-semibold text-gray-700 mb-1">Cari Judul / Peneliti / No. Protokol</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900 focus:outline-none"
                        placeholder="Ketik kata kunci...">
                </div>

            
                <div class="flex flex-col">
                    <label for="status" class="text-xs font-semibold text-gray-700 mb-1">Status Pengajuan</label>
                    <select name="status" id="pengajuan" onchange="this.form.submit()"
                    class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900">
                        <option value="">Semua</option>
                        <option value="Telah Diperiksa" {{ request('status') == 'Telah Diperiksa' ? 'selected' : '' }}>Telah Diperiksa</option>
                        <option value="Perlu Diperiksa" {{ request('status') == 'Perlu Diperiksa' ? 'selected' : '' }}>Perlu Diperiksa</option>
                    </select>
                </div>
            </div>
            
        
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
            </div>
        </form>   
        @if(request('search') || request('status') || request('nomor'))
            <div class="px-6 py-2 bg-yellow-200 text-sm text-gray-700">
                <span class="font-semibold">Filter Aktif:</span>
                @if(request('search'))
                    Pencarian "<span class="text-blue-700">{{ request('search') }}</span>"
                @endif
                @if(request('status'))
                    | Status: <span class="text-blue-700">{{ request('status') }}</span>
                @endif
                @if(request('nomor'))
                    | No Protokol: <span class="text-blue-700">{{ request('nomor') }}</span>
                @endif

                <span class="text-xs">- Tersedia {{ $protokol->total() }} data</span>
            </div>
        @endif    

        <div class="bg-white shadow-md overflow-auto">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-2 py-4 text-center">No. Protokol</th>
                        <th class="px-4 py-4 text-center">Judul</th>
                        <th class="px-4 py-4 text-center">Peneliti</th>
                        <th class="px-4 py-4 text-center">Status Pengajuan</th>
                        <th class="px-4 py-4 text-center">Detail</th>   
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($protokol as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-2 py-3 text-center font-semibold">
                            @if ($item->status_penelitian == 'Diperiksa')
                                <span class="px-2 py-1 bg-yellow-600 text-white rounded-full text-xs">Perlu Diperiksa</span>
                            @else
                                <span class="px-2 py-1 bg-blue-700 text-white rounded-full text-xs">Telah Diperiksa</span>
                            @endif

                        </td>
                        <td class="px-4 py-3">
                            <button onclick="loadDetailPengajuan({{ $item->id }})"
                                class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-gray-200 flex justify-between py-4 px-10 items-center text-sm bg-gradient-to-r from-gray-900 to-gray-700 text-white">
            <p>
                Menampilkan {{ $protokol->firstItem() }} – {{ $protokol->lastItem() }} dari {{ $protokol->total() }} data
            </p>
            <div>
                {{ $protokol->links('pagination::tailwind') }}
            </div>
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

    {{-- modal detail --}}
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
          </div>
        </div>
    </div>
      

    {{-- modal kembalikan --}}
    <div id="modalKembalikan" class="fixed hidden inset-0 bg-black/60 z-50 justify-center items-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Kembalikan</h3>
            <p class="text-gray-700 text-sm mb-4">
                Apakah Anda yakin ingin mengembalikan pengajuan penelitian ini? Tindakan ini tidak dapat dibatalkan.
            </p>
    
            <form method="POST" action="{{ route('admin.kembalikan') }}" id="formKembalikan">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id_kembalikan">
    
                <div class="mb-4">
                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                    <textarea name="komentar" id="komentar" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-red-100 focus:outline-none text-sm" placeholder="Tuliskan alasan pengembalian..."></textarea>
                </div>
    
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="tutupModalKembalikan()" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">Kembalikan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal Lanjutkan --}}
    <div id="modalLanjutkan" class="fixed hidden inset-0 bg-black/60 z-50 justify-center items-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Lanjutkan</h3>
            <p class="text-gray-700 text-sm mb-6">
                Apakah Anda yakin ingin melanjutkan pengajuan penelitian ini? Tindakan ini tidak dapat dibatalkan.
            </p>
    
            <form method="POST" action="{{ route('admin.lanjutkan') }}" id="formLanjutkan">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id_lanjutkan">
    
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="tutupModalLanjutkan()" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function loadDetailPengajuan(id) {
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

        function bukaModalKembalikan(id) {
            document.getElementById('modalKembalikan').classList.remove('hidden');
            document.getElementById('modalKembalikan').classList.add('flex');
            document.getElementById('id_kembalikan').value = id;
        }

        function tutupModalKembalikan() {
            document.getElementById('modalKembalikan').classList.add('hidden');
            document.getElementById('modalKembalikan').classList.remove('flex');
        }

        function bukaModalLanjutkan(id) {
            document.getElementById('modalLanjutkan').classList.remove('hidden');
            document.getElementById('modalLanjutkan').classList.add('flex');
            document.getElementById('id_lanjutkan').value = id;
        }

        function tutupModalLanjutkan() {
            document.getElementById('modalLanjutkan').classList.add('hidden');
            document.getElementById('modalLanjutkan').classList.remove('flex');
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