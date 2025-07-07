<x-Layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="bg-yellow-100 border-yellow-600 border shadow-md rounded-xl p-4">
        <h2 class="text-yellow-800 font-semibold">Selamat Datang KEPK/Sekretaris</h2>
        <p class="text-yellow-800 text-sm">
        Halaman ini menampilkan <span class="font-semibold">statistik tahapan telaah</span> terhadap seluruh pengajuan penelitian yang sedang diproses oleh Komite Etik Penelitian Kesehatan (KEPK). 
        <br class="hidden sm:block">
        Anda dapat memantau jumlah penelitian yang berada pada tahap <strong>Telaah Awal</strong>, <strong>Telaah Lanjutan</strong>, dan <strong>Telaah Akhir</strong> dalam bentuk grafik visual untuk mempermudah pengambilan keputusan.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mt-2">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Status Telaah Penelitian</h2>
        <canvas id="telaahChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('telaahChart').getContext('2d');
        const telaahChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($chartData)) !!},
                datasets: [{
                    label: 'Jumlah Penelitian',
                    data: {!! json_encode(array_values($chartData)) !!},
                    backgroundColor: ['#3b82f6', '#facc15', '#3b82f6','#633d14','#279130'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    
</x-Layout>
