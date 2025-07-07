<x-Layout>
  <x-slot:title>{{ $title }}</x-slot>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <div class="bg-gradient-to-r from-blue-50 to-white p-6 rounded-xl shadow mb-6">
    <p class="text-gray-600 text-sm leading-relaxed">
      Halaman ini menampilkan seluruh data pengajuan penelitian yang telah dikumpulkan oleh peneliti.
      Anda dapat melakukan pencarian berdasarkan <span class="font-semibold text-blue-700">judul</span>,
      <span class="font-semibold text-blue-700">peneliti</span>, atau <span class="font-semibold text-blue-700">nomor protokol</span>,
      serta memfilter data berdasarkan <strong>klasifikasi review</strong> seperti
      <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md text-xs font-medium">Expedited</span>,
      <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium">Fullboard</span>, atau
      <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-md text-xs font-medium">Exempt</span>.
    </p>
  </div>

  {{-- grafik --}}
  <div class="bg-gradient-to-br from-blue-100 to-yellow-200 rounded-2xl shadow-lg p-6 mb-8">
    <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5H2v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9H8V7zM14 3a1 1 0 011-1h2a1 1 0 011 1v13h-4V3z" />
      </svg>
      Grafik Jumlah Penelitian Terdaftar
    </h2>
    <canvas id="chartPenelitian" height="100"></canvas>
  </div>

  
  {{-- pencarian --}}
  <div class="mb-6">
    <label for="searchInput" class="block text-sm font-medium text-gray-700 mb-2">Cari Penelitian</label>
    <div class="relative">
      <input
        id="searchInput"
        onkeyup="filterTable()"
        type="text"
        placeholder="Ketik judul, peneliti, atau nomor protokol..."
        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition"
      />  
      <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
        </svg>
      </div>
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
  
  <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
    <div class="px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-t-2xl">
      <h2 class="text-lg font-semibold">Tabel Penelitian Terdahulu</h2>
      <p class="text-sm text-sky-100">Menampilkan daftar penelitian yang telah diajukan di Uji Komite Etik Fakultas Kesehatan Universitas Nurul Jadid</p>
    </div>
    
    <div class="overflow-auto">
      <table id="penelitianTable" class="min-w-full text-sm text-gray-800 divide-y divide-gray-200">
        <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
          <tr>
            <th class="p-3 text-center">Nomor Protokol</th>
            <th class="p-3 text-center">Judul Penelitian</th>
            <th class="p-3 text-center">Peneliti Utama</th>
            <th class="p-3 text-center">Tanggal Pengajuan</th>
            <th class="p-3 text-center">Klasifikasi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach ($protocols as $index => $item)
            <tr class="hover:bg-yellow-100 transition-all duration-150">
              <td class="p-3 font-mono font-bold text-blue-900">{{ $item->nomor_protokol_asli }}</td>
              <td class="p-3">{{ Str::words($item->judul, 10) }}</td>
              <td class="p-3">{{ $item->peneliti->name }}</td>
              <td class="p-3 text-sm text-gray-600">
                {{ $item->created_at->translatedFormat('D, j F Y') }}
              </td>
              <td class="p-3">
                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                  @if($item->kategori_review === 'Expedited') bg-yellow-100 text-yellow-800
                  @elseif($item->kategori_review === 'Exempted') bg-green-100 text-green-800
                  @elseif($item->kategori_review === 'Fullboard') bg-blue-100 text-blue-800
                  @else bg-stone-100 text-stone-800 @endif">
                  {{ $item->kategori_review ?? 'Belum diklasifikasikan' }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="bg-gray-200 flex justify-between py-4 px-10 items-center mt-4 text-sm text-gray-600">
      <p>
          Menampilkan {{ $protocols->firstItem() }} – {{ $protocols->lastItem() }} dari {{ $protocols->total() }} data
      </p>
      <div>
          {{ $protocols->links('pagination::tailwind') }}
      </div>
    </div>
  </div>
  

  <script>
    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#penelitianTable tbody tr");
      rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const match = Array.from(cells).some(cell =>
          cell.textContent.toLowerCase().includes(input)
        );
        row.style.display = match ? "" : "none";
      });
    }

    const ctx = document.getElementById('chartPenelitian').getContext('2d');
  
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          @foreach ($chartData as $item)
            '{{ \Carbon\Carbon::create()->month($item->month)->translatedFormat('F') }}',
          @endforeach
        ],
        datasets: [{
          label: 'Jumlah Penelitian',
          data: [
            @foreach ($chartData as $item)
              {{ $item->total }},
            @endforeach
          ],
          backgroundColor: '#0b5394',
          hoverBackgroundColor: '#073763',
          borderWidth: 1,
          borderRadius: 5,
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: (tooltipItem) => `${tooltipItem.raw} penelitian`
            }
          }
        }
      }
    });

    function tutupModalSuccess() {
      const modal = document.getElementById('modalSuccess');
      if (modal) modal.classList.add('hidden');
  }
  </script>
</x-Layout>