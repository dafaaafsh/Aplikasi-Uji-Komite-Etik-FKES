<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>
    <p class="mt-2 text-gray-600 text-base">
        Halaman ini menampilkan seluruh pengajuan nomor protokol penelitian yang telah masuk ke dalam sistem. 
        Anda dapat melihat informasi penting seperti 
        <strong>judul penelitian</strong>, 
        <strong>nama peneliti</strong>, 
        <strong>status pembayaran</strong>, 
        <strong>bukti pembayaran</strong>
        serta melakukan tindakan lebih lanjut seperti 
        <strong>melihat detail</strong> atau <strong>menerbitkan nomor protokol</strong>.
    </p>

    {{-- tabel --}}
    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-4">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Daftar Nomor Protokol </h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah daftar semua pengajuan nomor protokol pada aplikasi Uji Komite Etik.
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.nomorProtokol') }}" class="flex flex-wrap items-end justify-between gap-4 p-4 bg-blue-100 text-sm">

            <div class="flex flex-col">
                <label for="search" class="text-xs font-semibold text-gray-700 mb-1">Cari Judul / Peneliti</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900 focus:outline-none"
                    placeholder="Ketik kata kunci...">
            </div>
        
            <div class="flex flex-col">
                <label for="nomor" class="text-xs font-semibold text-gray-700 mb-1">Nomor Protokol</label>
                <select name="nomor" id="nomor" onchange="this.form.submit()"
                    class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900">
                    <option value="">Semua</option>
                    <option value="Ada" {{ request('nomor') == 'Ada' ? 'selected' : '' }}>Ada</option>
                    <option value="Belum Ada" {{ request('nomor') == 'Belum Ada' ? 'selected' : '' }}>Belum Ada</option>
                </select>
            </div>
        
            <div class="flex flex-col">
                <label for="status" class="text-xs font-semibold text-gray-700 mb-1">Status Pembayaran</label>
                <select name="status" id="pembayaran" onchange="this.form.submit()"
                class="px-3 py-2 border border-gray-400 rounded focus:ring focus:ring-blue-900">
                    <option value="">Semua</option>
                    <option value="Telah Dibayar" {{ request('status') == 'Telah Dibayar' ? 'selected' : '' }}>Telah Dibayar</option>
                    <option value="Belum Dibayar" {{ request('status') == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                </select>
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
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Virtual Account</th>
                        <th class="px-4 py-4 text-center">Bukti Pembayaran</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>                    
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($protokol as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->peneliti->name }}</td>
                        <td class="px-2 py-3 text-center
                            @if(!empty($item->tarif)){
                                @if ($item->status_pembayaran == 'Diperiksa')
                                    text-yellow-600 font-semibold
                                @elseif ($item->status_pembayaran == 'Dikembalikan' || $item->status_pembayaran == 'Menunggu Pembayaran')
                                    text-red-600 font-semibold
                                @elseif ($item->status_pembayaran == 'Diterima')
                                    text-green-600 font-semibold
                                @endif
                            } @else {
                                text-gray-500 italic
                            } @endif
                        ">
                        @if ($item->tarif == null)
                        <button onclick="modaltarif({{ $item->id }})">
                            <span class="italic hover:text-gray-700 hover:underline">Belum ditentukan</span>
                        </button>
                        @else
                            {{ $item->status_pembayaran }}
                        @endif
                        </td>
                        <td class="px-2 py-3 text-center font-semibold">
                            @if ($item->tarif == null)
                            <button onclick="modaltarif({{ $item->id }})">
                                <span class="hover:text-gray-500 hover:underline">{{$item->va}}</span>
                            </button>
                            @else
                                <span class="hover:text-gray-700">{{$item->va}}</span>
                            @endif
                        </td>
                        <td class="px-2 py-3 text-center font-semibold">
                            <button onclick="openBukti({{ $item->id }})"
                            class="text-blue-700 hover:underline">
                                Lihat
                            </button>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 justify-center">
                                <button onclick="loadDetail({{ $item->id }})"
                                    class="py-2 px-4 rounded-xl text-white hover:bg-blue-600 bg-blue-500">
                                    Detail
                                </button>         
                                @if ($item->verified_pembayaran && empty($item->nomor_protokol))
                                <button type="button" onclick="modalNomor('{{ $item->id }}')" class="py-2 px-4 rounded-xl text-white hover:bg-green-700 bg-green-600">
                                    Nomor
                                </button>
                                @endif     
                            </div>
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

    {{-- modal tarif --}}
    <div id="modalTarif" class="fixed hidden inset-0 bg-black/70 bg-opacity-50 z-50 justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Isi Tarif Protokol</h2>
                <button onclick="tutupModalTarif()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            
            <form method="POST" action="{{route('admin.tarifProtokol.update')}}">
                @csrf
                <input type="hidden" name="id" id="tarif_id">

                <div class="mb-4">
                    <label for="tarif" class="block text-sm font-medium text-gray-700">Tarif Protokol</label>
                    <input type="number" name="tarif" id="tarif"
                        class="mt-1 block w-full px-4 py-1 border border-gray-600 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="tutupModalTarif()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal bukti --}}
    <div id="modalBukti" class="fixed hidden inset-0 bg-black/60 z-50 justify-center items-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Bukti Pembayaran</h3>
                <button onclick="closeBukti()" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            </div>

            <p>
                Berikut adalah <strong>bukti pembayaran</strong> dari protokol yang akan didaftarkan.
                Silakan tinjau status pembayaran terlebih dahulu untuk melanjutkan proses pendaftaran nomor protokol.
            </p>

            <br>

            <p class="flex gap-3 items-center mb-4 text-sm text-gray-800">
                <strong>Status Pembayaran :</strong>
                <span id="statpembayaran" class="font-semibold"></span>
            </p>
            <p class="flex gap-3 items-center mb-4 text-sm text-gray-800">
                <strong>Bukti Pembayaran :</strong>
                <a href="" id="path_link" class="text-blue-700 hover:underline">Lihat bukti pembayaran disini</a>
            </p>

            <div class="flex justify-between">
                <button onclick="closeBukti()"
                class="px-5 py-2 font-semibold text-white rounded-lg bg-gray-500 hover:bg-gray-600">
                    Batal
                </button>
                <div class="flex gap-3 justify-end" id="btn_konfirmasi">
                    <button 
                      onclick="tolakPembayaran()" 
                      class="px-5 py-2 font-semibold text-white rounded-lg bg-red-600 hover:bg-red-700">
                        Tolak
                    </button>
                    <button 
                      onclick="terimaPembayaran()" 
                      class="px-5 py-2 font-semibold text-white rounded-lg bg-green-600 hover:bg-green-700">
                        Terima
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div id="modalDetailProtokol" class="fixed hidden inset-0 bg-black/60 z-50 justify-center items-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Detail Protokol</h3>
                <button onclick="tutupModalDetail()" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            </div>
    
            <div id="detailContent" class="space-y-3 text-sm text-gray-800">
                <p><strong>Nomor Protokol:</strong> <span id="d_nomor"></span></p>
                <p><strong>Judul:</strong> <span id="d_judul"></span></p>
                <p><strong>Peneliti:</strong> <span id="d_peneliti"></span></p>
                
                <br>
                
                <p><strong>Subjek Penelitian:</strong> <span id="d_subjek"></span></p>
                <p><strong>Jenis Penelitian:</strong> <span id="d_jenis"></span></p>
                <p><strong>Jenis Pengajuan:</strong> <span id="d_jenis1"></span></p>
                <p><strong>Biaya Penelitian:</strong> <span id="d_biaya"></span></p>

                <br>

                <p><strong>Status Pembayaran:</strong> <span id="d_pembayaran"></span></p>
                <p><strong>Dibuat pada:</strong> <span id="d_created"></span></p>
                <p><strong>Terakhir diperbarui:</strong> <span id="d_updated"></span></p>
            </div>
    
            <div class="mt-6 text-right">
                <button onclick="tutupModalDetail()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tutup</button>
            </div>
        </div>
    </div>

    {{-- modal status --}}
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

    {{-- modal input nomor --}}
    <div id="modalNomor" class="fixed inset-0 bg-black/70 bg-opacity-50 z-50 hidden justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Isi Nomor Protokol</h2>
                <button onclick="tutupModalNomor()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            
            <form method="POST" action="{{ route('admin.nomorProtokol.update') }}">

                @csrf
                <input type="hidden" name="id" id="protokol_id">

                <div class="mb-4">
                    <label for="nomor_protokol" class="block text-sm font-medium text-gray-700">Nomor Protokol</label>
                    <input type="text" name="nomor_protokol" id="nomor_protokol"
                        class="mt-1 block w-full px-4 py-1 border border-gray-600 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="tutupModalNomor()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>

        let currentProtocolId = null;

        function openBukti(id) {
            currentProtocolId = id;
        
            fetch(`/admin/nomorProtokol/bukti/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('statpembayaran').textContent = data.status_pembayaran;
                
                    const pathLink = document.getElementById('path_link');
                    if (data.path_pembayaran) {
                        pathLink.href = data.path_pembayaran;
                        pathLink.textContent = 'Lihat bukti pembayaran di sini';
                        pathLink.classList.remove('text-gray-400');
                        pathLink.classList.add('text-blue-700', 'hover:underline');
                    } else {
                        pathLink.href = '#';
                        pathLink.textContent = 'Tidak ada file';
                        pathLink.classList.remove('text-blue-700', 'hover:underline');
                        pathLink.classList.add('text-gray-400');
                    }

                    const tombolKonfirmasi = document.getElementById('btn_konfirmasi');
                    tombolKonfirmasi.classList.remove('hidden')

                    if (data.verified_pembayaran) {
                        tombolKonfirmasi.classList.add('hidden')
                    }
                
                    document.getElementById('modalBukti').classList.remove('hidden');
                    document.getElementById('modalBukti').classList.add('flex');
                })
                .catch(error => {
                    console.error('Gagal mengambil data bukti:', error);
                    alert('Terjadi kesalahan saat mengambil data bukti pembayaran.');
                });
        }

        function closeBukti() {
            document.getElementById('modalBukti').classList.add('hidden');
            document.getElementById('modalBukti').classList.remove('flex');
            currentProtocolId = null;
        }

        function modaltarif(id) {
            document.getElementById('tarif_id').value = id;

            document.getElementById('modalTarif').classList.remove('hidden');
            document.getElementById('modalTarif').classList.add('flex');
        }

        function tutupModalTarif() {
            document.getElementById('modalTarif').classList.add('hidden');
            document.getElementById('modalTarif').classList.remove('flex');
        }
        
        function tolakPembayaran() {
            if (!currentProtocolId) return;
        
            fetch(`/admin/protokol/tolak-bukti/${currentProtocolId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  closeBukti();
                  location.reload();
              });
        }
        
        function terimaPembayaran() {
            if (!currentProtocolId) return;
        
            fetch(`/admin/protokol/terima-bukti/${currentProtocolId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  closeBukti();
                  location.reload();
                      });
        }

        function loadDetail(id) {
        fetch(`/admin/nomorProtokol/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('d_nomor').textContent = data.nomor_protokol ?? '-';
                document.getElementById('d_judul').textContent = data.judul ?? '-';
                document.getElementById('d_peneliti').textContent = data.peneliti ?? '-';

                
                document.getElementById('d_subjek').textContent = data.subjek ?? '-';
                document.getElementById('d_jenis').textContent = data.jenis_penelitian ?? '-';
                document.getElementById('d_jenis1').textContent = data.jenis_pengajuan ?? '-';
                document.getElementById('d_biaya').textContent = data.biaya ?? '-';

                document.getElementById('d_pembayaran').textContent = data.verified_pembayaran;
                document.getElementById('d_created').textContent = data.created_at;
                document.getElementById('d_updated').textContent = data.updated_at;

                document.getElementById('modalDetailProtokol').classList.remove('hidden');
                document.getElementById('modalDetailProtokol').classList.add('flex');
            })
            .catch(err => {
                alert("Gagal memuat detail.");
                console.error(err);
            });
        }

        function tutupModalDetail() {
            const modal = document.getElementById('modalDetailProtokol');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function modalNomor(id) {
            document.getElementById('modalNomor').classList.remove('hidden');
            document.getElementById('modalNomor').classList.add('flex');
            document.getElementById('protokol_id').value = id;
        }
    
        function tutupModalNomor() {
            document.getElementById('modalNomor').classList.add('hidden');
            document.getElementById('modalNomor').classList.remove('flex');
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