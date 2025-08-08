<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>
    <p class="mt-2 text-gray-600 text-base">
        Kelola seluruh data pengguna sistem di halaman ini.
        <br>
        Anda dapat <strong class="font-semibold text-gray-800">menambahkan</strong>, 
        <strong class="font-semibold text-gray-800">mengedit</strong>, 
        <strong class="font-semibold text-gray-800">menghapus</strong> akun pengguna sesuai dengan kebutuhan dan peran masing-masing.
    </p>
    <div class="bg-white shadow-md rounded-2xl overflow-hidden my-4">
        <div class="flex px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white justify-between rounded-t-2xl gap-x-10">
            <div>
                <h2 class="text-lg font-semibold">Daftar Pengguna</h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah daftar semua pengguna aplikasi Uji Komite Etik.
                </p>
            </div>
            <div class="mt-2">
                <button type="button" onclick="bukaModalTambah()" class="px-4 py-2 bg-green-700 hover:bg-green-800 flex text-md text-white rounded-xl gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-md md:block hidden"> Tambah Pengguna</span>
                </button>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-2xl overflow-auto">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-10 py-4 text-center">Nama Pengguna</th>
                        <th class="px-4 py-4 text-center">Email</th>
                        <th class="px-4 py-4 text-center">Status Email</th>
                        <th class="px-4 py-4 text-center">Status KTP</th>
                        <th class="px-2 py-4 text-center">
                            <form method="GET" action="" class="flex items-center justify-end gap-2">
                                <label for="role" class="">Role </label>
                                <select name="role" id="role" onchange="this.form.submit()" class="px-1 py-1 border border-gray-500 rounded-xl text-sm focus:ring focus:ring-blue-900">
                                    <option value="" {{ request('role') === '' ? 'selected' : '' }}>Semua</option>
                                    <option value="Peneliti" {{ request('role') === 'Peneliti' ? 'selected' : '' }}>Peneliti</option>
                                    <option value="Admin" {{ request('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Penguji" {{ request('role') === 'Penguji' ? 'selected' : '' }}>Penguji</option>
                                    <option value="Kepk">Kepk</option>
                                </select>
                            </form>
                        </th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($pengguna as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="px-10 py-3 text-center font-semibold text-blue-700">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->email }}</td>
                        <td class="px-4 py-3 text-center">
                            @if (!empty($item->email_verified_at))
                                <div class="flex justify-center">
                                    <span class="px-2">Telah Terverifikasi</span>
                                    <div>                                    
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-green-800">
                                            <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                          </svg>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-center">
                                    <span class="px-2">Belum Terverifikasi</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-red-700">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <!-- Status KTP -->
                        <td class="px-4 py-3 text-center">
                            @if (!empty($item->ktp_path))
                                @if (!empty($item->ktp_verified_at))
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>Sudah Diverifikasi</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle></svg>Belum Diverifikasi</span>
                                    <br>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Belum Upload</span>
                            @endif
                        </td>
                        <td class="px-2 py-3 text-center font-semibold">{{ $item->role }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.users.detail', $item->id) }}" class="px-3 py-1 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded">Lihat Detail</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div id="modalTambahPengguna" class="fixed hidden inset-0 z-50 bg-black/60 justify-center items-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Pengguna</h3>
            <button onclick="tutupModalTambah()" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" id="formTambahUser">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 w-full rounded-md border-gray-600 border shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 w-full rounded-md border-gray-600 border shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full rounded-md border-gray-600 border shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" required
                    class="mt-1 w-full rounded-md border-gray-600 border shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Role --</option>
                    <option value="Admin">Admin</option>
                    <option value="Penguji">Penguji</option>
                    <option value="Kepk">Kepk</option>
                    <option value="Peneliti">Peneliti</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="tutupModalTambah()" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-md">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md">
                    Simpan
                </button>
            </div>
        </form>
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


    <script>
        const modalTambah = document.getElementById('modalTambahPengguna');
    
        function bukaModalTambah() {
            modalTambah.classList.remove('hidden');
            modalTambah.classList.add('flex');
        }
    
        function tutupModalTambah() {
            modalTambah.classList.remove('flex');
            modalTambah.classList.add('hidden');
        }

        function bukaModalEdit(id, name, email, role) {
            document.getElementById('modalEditPengguna').classList.remove('hidden');
            document.getElementById('modalEditPengguna').classList.add('flex');

            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
        }

        function tutupModalEdit() {
            document.getElementById('modalEditPengguna').classList.add('hidden');
            document.getElementById('modalEditPengguna').classList.remove('flex');
        }

        function bukaModalHapus(id) {
            document.getElementById('modalHapusPengguna').classList.remove('hidden');
            document.getElementById('modalHapusPengguna').classList.add('flex');
            document.getElementById('hapus_user_id').value = id;
        }

        function tutupModalHapus() {
            document.getElementById('modalHapusPengguna').classList.add('hidden');
            document.getElementById('modalHapusPengguna').classList.remove('flex');
        }

        function tutupModalError() {
            document.getElementById('modalError').classList.add('hidden');
            document.getElementById('modalError').classList.remove('flex');
        }

        function tutupModalSuccess() {
            const modal = document.getElementById('modalSuccess');
            if (modal) modal.classList.add('hidden');
        }

        // Function to open the KTP verification modal
        function bukaModalVerifKtp(id, name, ktpPath) {
            const modal = document.getElementById('modalVerifKtp');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('verif_ktp_user_id').value = id;
            document.getElementById('verifKtpUserName').textContent = name;
            let preview = '';
            if (ktpPath && ktpPath.endsWith('.pdf')) {
                preview = `<a href='/private/${ktpPath}' target='_blank' class='text-blue-600 underline'>Lihat File PDF</a>`;
            } else if (ktpPath) {
                preview = `<img src='/private/${ktpPath}' alt='KTP' class='rounded shadow max-h-48'>`;
            } else {
                preview = `<span class='text-gray-400'>Tidak ada file KTP</span>`;
            }
            document.getElementById('verifKtpPreview').innerHTML = preview;
        }
        function tutupModalVerifKtp() {
            const modal = document.getElementById('modalVerifKtp');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
    


</x-Layout>