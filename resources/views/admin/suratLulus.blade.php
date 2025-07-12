<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <section class="mb-12">
        <div class=" px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <h2 class="text-xl font-semibold">Daftar Protokol Diterima KEPK</h2>
            <p class="text-sm text-sky-100">Berikut daftar protokol yang telah disetujui dan dinyatakan layak etik oleh KEPK.</p>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                <thead class="text-center bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">No. Protokol</th>
                        <th class="px-4 py-3">Judul Protokol</th>
                        <th class="px-4 py-3">Peneliti</th>
                        <th class="px-4 py-3">Tanggal Diterima</th>
                        <th class="px-4 py-3">Status Surat</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 bg-white divide-y divide-gray-100">
                    @forelse($protokols as $index => $protokol)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $protokol->nomor_protokol_asli }}</td>
                            <td class="px-4 py-3">{{ $protokol->judul }}</td>
                            <td class="px-4 py-3">{{ $protokol->peneliti->name }}</td>
                            <td class="px-4 py-3">{{ $protokol->putusan->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                @if($protokol->putusan->path)
                                    <a href="#"
                                       class="text-green-600 hover:underline">
                                        Telah Upload
                                    </a>
                                @else
                                    <span class="text-gray-500">Belum ada</span>
                                @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="italic font-semibold px-4 py-4 text-center text-gray-500">Belum ada penelitian yang selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION: FORM -->
    <section class="bg-white border border-gray-200 p-8 rounded-xl shadow-md max-w-5xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Buat Surat Keterangan Layak Etik</h2>
        <p class="text-sm text-gray-500 mb-6">Isi data berikut untuk membuat surat resmi keterangan layak etik bagi peneliti.</p>

        <form action="{{ route('admin.surat-lulus.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                    <input type="text" id="nomor_surat" name="nomor_surat" required value="{{ old('nomor_surat') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="protokol_id" class="block text-sm font-medium text-gray-700">Pilih Protokol</label>
                    <select name="protokol_id" id="protokol_id" required
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih Protokol --</option>
                        @foreach($protokols as $protokol)
                            <option value="{{ $protokol->id }}" {{ old('protokol_id') == $protokol->id ? 'selected' : '' }}>
                                {{ $protokol->nomor_protokol_asli }} - {{ $protokol->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="nama_peneliti" class="block text-sm font-medium text-gray-700">Nama Peneliti</label>
                    <input type="text" name="nama_peneliti" id="nama_peneliti" required value="{{ old('nama_peneliti') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="institusi" class="block text-sm font-medium text-gray-700">Institusi/Instansi</label>
                    <input type="text" name="institusi" id="institusi" required value="{{ old('institusi') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="judul_penelitian" class="block text-sm font-medium text-gray-700">Judul Penelitian</label>
                    <input type="text" name="judul_penelitian" id="judul_penelitian" required value="{{ old('judul_penelitian') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="nomor_protokol" class="block text-sm font-medium text-gray-700">Nomor Protokol</label>
                    <input type="text" name="nomor_protokol" id="nomor_protokol" required value="{{ old('nomor_protokol') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>

                <div>
                    <label for="tanggal_persetujuan" class="block text-sm font-medium text-gray-700">Tanggal Persetujuan</label>
                    <input type="date" name="tanggal_persetujuan" id="tanggal_persetujuan" required value="{{ old('tanggal_persetujuan') }}"
                        class="w-full mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition duration-200">
                    Simpan & Buat Surat
                </button>
            </div>
        </form>
    </section>

    <script>
    document.getElementById('protokol_id').addEventListener('change', function () {
        const protokolId = this.value;
        if (!protokolId) return;

        fetch(`/admin/protokol/${protokolId}/data`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('nama_peneliti').value = data.nama_peneliti || '';
                document.getElementById('institusi').value = data.institusi || '';
                document.getElementById('judul_penelitian').value = data.judul_penelitian || '';
                document.getElementById('nomor_protokol').value = data.nomor_protokol || '';
                document.getElementById('tanggal_persetujuan').value = data.tanggal_persetujuan || '';
            })
            .catch(error => console.error('Gagal mengambil data protokol:', error));
    });
    </script>

</x-Layout>
