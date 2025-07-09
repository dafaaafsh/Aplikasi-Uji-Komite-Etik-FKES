<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-4">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Daftar Penelitian Telaah Awal </h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah data semua penelitian yang telah 
                    <strong>didaftarkan</strong> 
                    pada sistem Uji Komite Etik. 
                    Anda dapat mencari berdasarkan judul penelitian, nama peneliti, atau nomor protokol.
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('kepk.telaahAwal') }}" class="flex flex-wrap items-end justify-between gap-4 p-4 bg-blue-100 text-sm">
            <div class="flex flex-col">
                <label for="search" class="text-xs font-semibold text-gray-700 mb-1">Cari Judul / Peneliti / No. Protokol</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="px-3 py-2 border xl:w-247 border-gray-400 rounded focus:ring focus:ring-blue-900 focus:outline-none"
                    placeholder="Ketik kata kunci...">
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
                        <th class="px-8 py-4 text-center">Detail</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($data as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-8 py-3 text-center font-semibold">
                            <button onclick="loadDetailData({{ $item->id }})"
                                class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Lihat
                            </button>                         
                        </td>
                        <td class="px-8 py-3">
                            <div class="flex gap-2 justify-center">
                                <button onclick="bukaModalExempted({{ $item->id }})"
                                    class="px-3 py-1 text-sm bg-green-600 hover:bg-green-700 text-white rounded">
                                    Exempted
                                </button>                                
                                <button onclick="openModalLanjutkan({{ $item->id }})"
                                    class="px-3 py-1 text-sm bg-yellow-600 hover:bg-yellow-700 text-white rounded">
                                    Lanjutkan
                                </button>                               
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8"
                        class="px-6 py-4 text-center text-md italic text-gray-400 font-semibold">
                          Belum ada penelitian pada telaah awal
                        </td>
                      </tr>
                    @endforelse
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

    {{-- Telaah Lanjutan --}}
    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-8">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Daftar Penelitian Telaah Lanjutan </h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah data semua penelitian yang telah dikategori 
                    <strong>
                        telaah lanjutan
                    </strong> untuk diperiksa oleh penguji pada sistem Uji Komite Etik. 
                    Anda dapat mencari berdasarkan judul penelitian, nama peneliti, atau nomor protokol.
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('kepk.telaahAwal') }}" class="flex flex-wrap items-end justify-between gap-4 p-4 bg-blue-100 text-sm">
            <div class="flex flex-col">
                <label for="search" class="text-xs font-semibold text-gray-700 mb-1">Cari Judul / Peneliti / No. Protokol</label>
                <input type="text" name="search1" id="search" value="{{ request('search') }}"
                    class="px-3 py-2 border xl:w-247 border-gray-400 rounded focus:ring focus:ring-blue-900 focus:outline-none"
                    placeholder="Ketik kata kunci...">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
            </div>
        </form>
        @if(request('search1'))
            <div class="px-6 py-2 bg-yellow-200 text-sm text-gray-700">
                <span class="font-semibold">Filter Aktif:</span>
                    Pencarian "<span class="text-blue-700">{{ request('search1') }}</span>"

                <span class="text-xs">- Tersedia {{ $data1->total() }} data</span>
            </div>
        @endif

        <div class="bg-white shadow-md overflow-auto">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-2 py-4 text-center">No. Protokol</th>
                        <th class="px-4 py-4 text-center">Judul</th>
                        <th class="px-4 py-4 text-center">Peneliti</th>
                        <th class="px-8 py-4 text-center">review</th>
                        <th class="px-8 py-4 text-center">Detail</th>
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($data1 as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-4 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-4 py-3 text-center font-semibold">
                            <button onclick="loadReview({{ $item->id }})"
                                class="flex items-center gap-1 px-3 py-1 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow">
                                Review
                            </button>                             
                        </td>
                        <td class="px-8 py-3 text-center font-semibold">
                            <button onclick="loadDetailData({{ $item->id }})"
                                class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                                Detail
                            </button>                       
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8"
                        class="px-6 py-4 text-center text-md italic text-gray-400 font-semibold">
                          Belum ada penelitian pada telaah lanjutan
                        </td>
                      </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-200 flex justify-between py-4 px-10 items-center text-sm bg-gradient-to-r from-gray-900 to-gray-700 text-white">
            <p>
                Menampilkan {{ $data1->firstItem() }} – {{ $data1->lastItem() }} dari {{ $data1->total() }} data
            </p>
            <div>
                {{ $data->links('pagination::tailwind') }}
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

    <div id="modalDetailPengajuan" class="fixed inset-0 z-50 hidden flex items-start justify-center bg-black/60 backdrop-blur-sm overflow-y-auto">
        <div class="flex items-start justify-center min-h-screen w-screen px-4 py-8">
          <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-8 relative border border-gray-300">

            <button onclick="closeModalDetail()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
      
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

    <div id="modalExempted" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Konfirmasi Penelitian Exempted</h2>
            <p class="text-gray-700 mb-4">
                Anda akan melanjutkan penelitian ini dan menetapkannya sebagai <span class="font-semibold text-green-600">kategori Exempted</span>.
                Silakan isi komentar dan unggah Lampiran Exempted.
            </p>

            <form action="{{ route('kepk.exempted') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="hidden" name="protokol_id" id="exemptedProtokolId">

                <div>
                    <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar</label>
                    <textarea name="komentar" id="komentar" rows="4" 
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label for="lampiran" class="block text-sm font-medium text-gray-700">Unggah lampiran exempted</label>
                    <input type="file" name="lampiran" id="lampiran" accept="application/pdf" 
                        class="mt-1 block w-full text-sm text-gray-700 file:bg-blue-100 file:border-none file:rounded-md file:px-3 file:py-2 file:text-sm file:text-blue-800 hover:file:bg-blue-200" />
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="tutupModalExempted()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalLanjutkan" class="fixed hidden inset-0 bg-black/70 z-50 justify-center items-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Lanjutkan</h3>
            <p class="text-gray-700 text-sm mb-6">
                Anda akan melanjutkan penelitian ini. Silakan pilih kategori review yang akan dilakukan.
            </p>

            <div class="flex gap-x-4 justify-between">
                <button type="button" onclick="tutupModalLanjutkan()" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md">Batal</button>
                <div class="flex gap-x-2">
                    <form method="POST" action="{{ route('kepk.expedited') }}" id="formLanjutkan">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_expedited">
                    
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md">expedited</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('kepk.fullboard') }}" id="formLanjutkan">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_fullboard">
                    
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">fullboard</button>
                        </div>
                    </form>
                </div>                
                
            </div>
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

    <script>
        function loadDetailData(id) {
            fetch(`/kepk/dataPenelitian/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('d_nama').textContent = data.nama ?? '-';
                    document.getElementById('d_email').textContent = data.email ?? '-';
                    document.getElementById('d_asal').textContent = data.asal ?? '-';
                    document.getElementById('d_institusi').textContent = data.institusi ?? '-';
                    document.getElementById('d_hp').textContent = data.hp ?? '-';
                    document.getElementById('d_status').textContent = data.status ?? '-';
                
                    document.getElementById('d_nomor_protokol').textContent = data.nomor_protokol ?? '-';
                    document.getElementById('d_judul').textContent = data.judul ?? '-';
                    document.getElementById('d_subjek').textContent = data.subjek ?? '-';
                    document.getElementById('d_jenis_penelitian').textContent = data.jenis_penelitian ?? '-';
                    document.getElementById('d_jenis_pengajuan').textContent = data.jenis_pengajuan ?? '-';
                    document.getElementById('d_biaya').textContent = data.biaya ?? '-';
                    document.getElementById('d_tanggal').textContent = data.tanggal_pengajuan ?? '-';
                    document.getElementById('d_kategori').textContent = data.kategori ?? '-';
                
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

        function closeModalDetail() {
            const modal = document.getElementById('modalDetailPengajuan');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function bukaModalExempted(protokolId) {
            document.getElementById('exemptedProtokolId').value = protokolId;
            document.getElementById('modalExempted').classList.remove('hidden');
        }

        function tutupModalExempted() {
            document.getElementById('modalExempted').classList.add('hidden');
        }

        function openModalLanjutkan(id){
            document.getElementById('modalLanjutkan').classList.remove('hidden');
            document.getElementById('modalLanjutkan').classList.add('flex');
            document.getElementById('id_expedited').value = id;
            document.getElementById('id_fullboard').value = id;
        }

        function tutupModalLanjutkan() {
            document.getElementById('modalLanjutkan').classList.add('hidden');
            document.getElementById('modalLanjutkan').classList.remove('flex');
        }

        function loadReview(protocolId) {
          fetch(`/kepk/telaahAkhir/review/${protocolId}`)
            .then(res => res.json())
            .then(data => openModalReviewList(data))
            .catch(err => {
              alert('Gagal mengambil data review');
              console.error(err);
            });
        }

        function openModalReviewList(reviews) {
          const container = document.getElementById('review_list');
          container.innerHTML = '';

          if (reviews.length === 0) {
            container.innerHTML = `
              <div class="text-center text-gray-500 italic">Tidak ada review tersedia.</div>
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
      
          document.getElementById('modalReview').classList.remove('hidden');
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

        function closeModalReview() {
          document.getElementById('modalReview').classList.add('hidden');
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