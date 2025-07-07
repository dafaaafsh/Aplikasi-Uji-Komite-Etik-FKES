<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="p-6 space-y-6">
  
      {{-- Ringkasan --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-blue-400 shadow p-4 rounded-xl text-center">
          <div class="text-white font-semibold">Total Protokol</div>
          <div class="text-3xl text-white font-semibold">{{ $protokol->count() }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-600 to-green-400 shadow p-4 rounded-xl text-center">
          <div class="text-white font-semibold">Selesai Review</div>
          <div class="text-3xl text-white font-semibold">
            {{ $review->count()}}
          </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-600 to-yellow-400 shadow p-4 rounded-xl text-center">
          <div class="text-white font-semibold">Menunggu Review</div>
          <div class="text-3xl text-white font-semibold">
            {{ $protokol->count() - $review->count() }}
          </div>
        </div>
      </div>

  
      {{-- Tabel Protokol --}}
      <div class="bg-white shadow rounded-xl overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead class="bg-gray-100 text-gray-600">
            <tr>
              <th class="py-3 px-4">Nomor Protokol</th>
              <th class="py-3 px-4">Judul Protokol</th>
              <th class="py-3 px-4">Tanggal Masuk</th>
              <th class="py-3 px-4">Status Review</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse ($protokol as $protocol)
            <tr>
              <td class="py-3 px-4 text-blue-700 font-semibold">{{ $protocol->nomor_protokol_asli }}</td>
              <td class="py-3 px-4">{{ $protocol->judul }}</td>
              <td class="py-3 px-4">{{ $protocol->updated_at->translatedFormat('d F Y') }}</td>
              <td class="py-3 px-4">
                @if (in_array($protocol->id, $reviewProtokolIds))
                  <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Selesai</span>
                @else
                  <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Menunggu</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="py-4 px-4 text-center text-gray-500 italic">Tidak ada protokol.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </x-Layout>
  