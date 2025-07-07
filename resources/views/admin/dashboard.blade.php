<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Deskripsi Halaman --}}
    <p class="mt-2 text-gray-600 text-base">
        Hari ini: <span class="font-medium text-gray-800">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span><br>
        Selamat datang kembali, <span class="font-semibold text-gray-800">Admin</span>.  
        Pantau statistik pengajuan dan status pembayaran secara real-time di bawah ini.
    </p>

    <div class="max-w-6xl mx-auto px-6 py-10 space-y-12">
        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            {{-- Total Protokol --}}
            <div class="p-6 rounded-2xl shadow-md bg-gradient-to-br from-blue-200 to-blue-700 hover:shadow-lg transition duration-300 flex items-center gap-4">
                <div class="bg-blue-500 p-3 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-4-4H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Protokol</p>
                    <h2 class="text-2xl font-bold text-blue-900">{{ $data['protokol'] }}</h2>
                </div>
            </div>
        
            {{-- Penelitian Diajukan --}}
            <div class="p-6 rounded-2xl shadow-md bg-gradient-to-br from-yellow-100 to-yellow-300 hover:shadow-lg transition duration-300 flex items-center gap-4">
                <div class="bg-yellow-500 p-3 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 2h12m-6 2v14m-4 0h8a2 2 0 002-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Penelitian Diajukan</p>
                    <h2 class="text-2xl font-bold text-yellow-700">{{ $data['penelitian'] }}</h2>
                </div>
            </div>
        
            {{-- Telah Dibayar --}}
            <div class="p-6 rounded-2xl shadow-md bg-gradient-to-br from-blue-300 to-yellow-300 hover:shadow-lg transition duration-300 flex items-center gap-4">
                <div class="bg-blue-900 p-3 rounded-full shadow-md">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-2 0-3.5 1-3.5 2.5S10 13 12 13s3.5 1 3.5 2.5S14 18 12 18m0-14v2m0 14v2" />

                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Telah Dibayar</p>
                    <h2 class="text-2xl font-bold text-blue-900">{{ $data['verified_pembayaran'] }}</h2>
                </div>
            </div>
        </div>
        
        {{-- Progress Bar --}}
        <div class="bg-white p-6 rounded-2xl shadow flex items-center gap-6">
            {{-- Icon --}}
            <div class="bg-yellow-100 p-4 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-2 0-3.5 1-3.5 2.5S10 13 12 13s3.5 1 3.5 2.5S14 18 12 18m0-14v2m0 14v2" />
                </svg>
            </div>
        
            <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                    <p class="text-gray-700 font-medium">Status Pembayaran</p>
                    <span class="text-yellow-700 text-sm font-semibold">
                        {{ round(($data['verified_pembayaran'] / max($data['protokol'],1)) * 100, 2) }}%
                    </span>
                </div>
                {{-- Progress Bar --}}
                <span class="text-yellow-600 text-sm font-semibold">
                    {{ round(($data['verified_pembayaran'] / max($data['protokol'],1)) * 100, 2) }}%
                </span>
                
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-300 to-yellow-500 h-4 transition-all duration-700"
                         style="width: {{ round(($data['verified_pembayaran'] / max($data['protokol'],1)) * 100, 2) }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Dari total {{ $data['protokol'] }} protokol, {{ $data['verified_pembayaran'] }} telah dibayar.
                </p>
            </div>
        </div>

        {{-- Chart --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Card Statistik Pengajuan --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-900">
                <div class="flex items-center mb-4">
                    {{-- Icon --}}
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 17v-2a4 4 0 0 1 8 0v2m1 4H6a2 2 0 0 1-2-2v-1a2 2 0 0 1 2-2h1m10 0h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-blue-700">Statistik Pengajuan</h2>
                </div>
                <canvas id="statpengajuan" class="w-full h-50"></canvas>
            </div>
        
            {{-- Card Statistik Pembayaran --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    {{-- Icon --}}
                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8c-2 0-3.5 1-3.5 2.5S10 13 12 13s3.5 1 3.5 2.5S14 18 12 18m0-14v2m0 14v2" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-yellow-700">Statistik Pembayaran</h2>
                </div>
                <canvas id="statTelahDibayar" class="w-full h-50"></canvas>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="bg-white shadow-md rounded-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-t-2xl">
                <h2 class="text-lg font-semibold">Pengajuan Terbaru</h2>
                <p class="text-sm text-sky-100">
                    Berikut adalah daftar penelitian yang diajukan semenjak tanggal 
                    <strong>
                        {{ \Carbon\Carbon::now()->subDays(7)->translatedFormat('l, d F Y') }}
                    </strong>
                    (1 minggu yang lalu).
                </p>
            </div>
            <div class="overflow-x-auto w-full">
            <table class="min-w-full table-auto text-sm text-gray-800 divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center">No. Protokol</th>
                        <th class="px-4 py-3 text-center">Judul</th>
                        <th class="px-4 py-3 text-center">Nama Peneliti</th>
                        <th class="px-4 py-3 text-center">Tanggal Pembayaran</th>
                        <th class="px-4 py-3 text-center">Status Pengajuan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @if ($baru->isEmpty())
                        <div class="px-6 py-4 text-gray-600 text-md text-center">
                            Tidak ada data pengajuan baru dalam 7 hari terakhir.
                        </div>
                    @else
                    @foreach ($baru as $item)
                    <tr class="odd:bg-white even:bg-gray-200">
                        <td class="text-center px-4 py-4 font-semibold text-blue-700">{{ $item->nomor_protokol_asli }}</td>
                        <td class="text-center px-4 py-4">{{ $item->judul }}</td>
                        <td class="text-center px-4 py-4">{{ $item->peneliti->name }}</td>
                        <td class="text-center px-4 py-4">
                            @if ($item->verified_pembayaran)
                                <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ \Carbon\Carbon::parse($item->verified_pembayaran)->translatedFormat('l, d F Y') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">
                                    Belum Transaksi
                                </span>
                            @endif
                        </td>
                        <td class="text-center px-4 py-4">
                            @if ($item->tanggal_pengajuan)
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">
                                    Telah Diajukan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">
                                    Belum Diajukan
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif 
                </tbody>
            </table>
            </div>
        </div>

    </div>


    <script>
        const ctx = document.getElementById('statpengajuan').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Protokol Terdaftar', 'Penelitian Diajukan'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $data['protokol'] }}, {{ $data['penelitian'] }}],
                    backgroundColor: ['#1E3A8A', '#FBBF24'],                    
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Jumlah Pengajuan dan Protokol',
                        font: { size: 16 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        const ctx1 = document.getElementById('statTelahDibayar').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Belum Dibayar', 'Sudah Dibayar'],
                datasets: [{
                    data: [{{ $data['protokol'] - $data['verified_pembayaran'] }}, {{ $data['verified_pembayaran'] }}],
                    backgroundColor: ['#d4d4d4', '#FBBF24'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#4B5563' }
                    },
                    title: {
                        display: true,
                        text: 'Status Pembayaran',
                        font: { size: 16 }
                    }
                }
            }
        });
    </script>
</x-Layout>
