<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="max-w-6xl mx-auto mt-8 bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-6 mb-6">
            <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : 'https://media.istockphoto.com/id/1330286085/vector/male-avatar-icon.jpg?s=612x612&w=is&k=20&c=U9zDXcxk0pkE6Yz0MtNOwW1LG1Njkzglx7Wtp16-ho4=' }}" alt="Avatar" class="w-24 h-24 rounded-full border shadow">
            <div>
                <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-500">Role: <span class="font-semibold text-blue-600">{{ $user->role }}</span></p>
                <p class="text-sm text-gray-500">Status Email: 
                    @if ($user->email_verified_at)
                        <span class="text-green-700 font-semibold">Terverifikasi</span>
                    @else
                        <span class="text-red-700 font-semibold">Belum Verifikasi</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Status KTP</h3>
            <div class="flex items-center gap-4">
                @if ($user->ktp_path)
                    <div>
                        @if (Str::endsWith($user->ktp_path, '.pdf'))
                            <a href="/private/{{ $user->ktp_path }}" target="_blank" class="text-blue-600 underline">Lihat File PDF</a>
                        @else
                            <img src="/private/{{ $user->ktp_path }}" alt="KTP" class="w-40 rounded border shadow">
                        @endif
                    </div>
                    <div>
                        @if ($user->ktp_verified_at)
                            <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>Sudah Diverifikasi</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle></svg>Belum Diverifikasi</span>
                            <div class="flex gap-2 mt-2">
                                <!-- Verifikasi KTP -->
                                <form action="{{ route('admin.updateUser') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <input type="hidden" name="name" value="{{ $user->name }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                    <input type="hidden" name="verif_ktp" value="1">
                                    <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Verifikasi KTP</button>
                                </form>
                                <!-- Kembalikan KTP (open modal) -->
                                <button type="button" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs" data-modal-target="#modalKembalikanKTP">Kembalikan KTP</button>
                            </div>
                        @endif
                    </div>
                @else
                    <span class="text-xs text-gray-400">Belum Upload</span>
                @endif
            </div>
        </div>

        <!-- Modal Kembalikan KTP -->
        <div id="modalKembalikanKTP" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <h3 class="text-lg font-bold mb-4 text-red-700">Kembalikan KTP</h3>
                <form action="{{ route('admin.updateUser') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <input type="hidden" name="kembalikan_ktp" value="1">
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Alasan pengembalian</label>
                        <textarea name="alasan" class="w-full border rounded px-3 py-2" required placeholder="Tulis alasan pengembalian KTP..."></textarea>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded" onclick="closeModal('modalKembalikanKTP')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Kembalikan</button>
                    </div>
                </form>
                <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700" onclick="closeModal('modalKembalikanKTP')">&times;</button>
            </div>
        </div>
        <div class="mb-6">
            <h3 class="font-semibold text-blue-800 mb-3 text-lg flex items-center gap-2 tracking-wide">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#e0e7ff"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M8 16h8M8 8h8" /></svg>
                Informasi Tambahan Pengguna
            </h3>
            <div class="overflow-hidden rounded-xl shadow border border-blue-200 bg-gradient-to-br from-blue-50 to-white">
                <dl class="divide-y divide-blue-100">
                    <div class="flex flex-col md:flex-row md:items-center md:gap-0 gap-1 px-6 py-3">
                        <dt class="w-48 font-semibold text-blue-700">Nomor Handphone</dt>
                        <dd class="flex-1 text-gray-900">{{ $user->nomor_hp ?? '-' }}</dd>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-0 gap-1 px-6 py-3">
                        <dt class="w-48 font-semibold text-blue-700">Alamat</dt>
                        <dd class="flex-1 text-gray-900">{{ $user->alamat ?? '-' }}</dd>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-0 gap-1 px-6 py-3">
                        <dt class="w-48 font-semibold text-blue-700">Institusi</dt>
                        <dd class="flex-1 text-gray-900">{{ $user->institusi ?? '-' }}</dd>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-0 gap-1 px-6 py-3">
                        <dt class="w-48 font-semibold text-blue-700">Status Peneliti</dt>
                        <dd class="flex-1 text-gray-900">{{ $user->status_peneliti ?? '-' }}</dd>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-0 gap-1 px-6 py-3">
                        <dt class="w-48 font-semibold text-blue-700">Asal Peneliti</dt>
                        <dd class="flex-1 text-gray-900">{{ $user->asal_peneliti ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-6">
            <div class="flex gap-2">
                <!-- Edit User Button -->
                <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" data-modal-target="#modalEditUser">Edit</button>
                <!-- Delete User Button -->
                <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded" data-modal-target="#modalDeleteUser">Hapus</button>
            </div>
            <a href="{{ route('admin.kelolaUser') }}" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded">Kembali</a>
        </div>

        <!-- Modal Edit User -->
        <div id="modalEditUser" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <h3 class="text-lg font-bold mb-4 text-blue-700">Edit Data User</h3>
                <form action="{{ route('admin.updateUser') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Role</label>
                        <select name="role" class="w-full border rounded px-3 py-2" required>
                            <option value="Admin" @if($user->role=='Admin') selected @endif>Admin</option>
                            <option value="Penguji" @if($user->role=='Penguji') selected @endif>Penguji</option>
                            <option value="Kepk" @if($user->role=='Kepk') selected @endif>Kepk</option>
                            <option value="Peneliti" @if($user->role=='Peneliti') selected @endif>Peneliti</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded" onclick="closeModal('modalEditUser')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Simpan</button>
                    </div>
                </form>
                <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700" onclick="closeModal('modalEditUser')">&times;</button>
            </div>
        </div>

        <!-- Modal Delete User -->
        <div id="modalDeleteUser" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <h3 class="text-lg font-bold mb-4 text-red-700">Hapus User</h3>
                <p class="mb-4">Apakah Anda yakin ingin menghapus user <span class="font-semibold">{{ $user->name }}</span>?</p>
                <form action="{{ route('admin.destroyUser') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded" onclick="closeModal('modalDeleteUser')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Hapus</button>
                    </div>
                </form>
                <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700" onclick="closeModal('modalDeleteUser')">&times;</button>
            </div>
        </div>

        <script>
        // Modal logic
        document.querySelectorAll('[data-modal-target]').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-modal-target');
                document.querySelector(target).classList.remove('hidden');
            });
        });
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        </script>
    </div>
</x-Layout>
