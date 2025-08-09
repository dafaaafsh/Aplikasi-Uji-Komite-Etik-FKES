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
    <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center gap-3 tracking-tight">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-sky-300 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 018 0v2m-4-6a4 4 0 100-8 4 4 0 000 8zm0 0v2m0 4v2m-4-2a4 4 0 018 0v2"/></svg>
        </span>
        <span>Statistik Status Telaah Penelitian</span>
    </h2>
    <div class="flex flex-col md:flex-row gap-8 items-center justify-between">
        <div class="w-full md:w-2/3 bg-gradient-to-br from-blue-50 to-white rounded-xl p-4 shadow-inner">
            <canvas id="telaahChart" height="140"></canvas>
        </div>
        <div class="w-full md:w-1/3 flex flex-col gap-3 mt-6 md:mt-0">
            @foreach(array_keys($chartData) as $i => $label)
                <div class="flex items-center gap-3 bg-white/80 border border-gray-200 rounded-lg px-4 py-2 shadow-sm hover:shadow-md transition">
                    <span class="inline-block w-4 h-4 rounded-full ring-2 ring-white shadow" style="background: {{ ['#3b82f6', '#facc15', '#3b82f6','#633d14','#279130'][$i%5] }}"></span>
                    <span class="font-semibold text-gray-700">{{ $label }}</span>
                    <span class="ml-auto text-lg text-blue-700 font-extrabold drop-shadow">{{ array_values($chartData)[$i] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>
    const ctx = document.getElementById('telaahChart').getContext('2d');
    const chartLabels = {!! json_encode(array_keys($chartData)) !!};
    const chartData = {!! json_encode(array_values($chartData)) !!};
    const chartColors = ['#3b82f6', '#facc15', '#3b82f6','#633d14','#279130'];
    const telaahChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Penelitian',
                data: chartData,
                backgroundColor: chartColors,
                borderRadius: 18,
                hoverBackgroundColor: chartColors.map(c => c+'cc'),
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.5,
                borderWidth: 2,
                borderColor: chartColors.map(c => c),
                shadowOffsetX: 2,
                shadowOffsetY: 2,
                shadowBlur: 8,
                shadowColor: 'rgba(59,130,246,0.15)'
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1400,
                easing: 'easeOutQuart'
            },
            layout: {
                padding: { top: 20, right: 20, left: 10, bottom: 10 }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 15 }, color: '#374151' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#e0e7ef', borderDash: [4,4] },
                    ticks: { precision: 0, font: { weight: 'bold', size: 15 }, color: '#374151' }
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#2563eb',
                    font: { weight: 'bold', size: 18 },
                    formatter: function(value) { return value > 0 ? value : ''; },
                    textStrokeColor: '#fff',
                    textStrokeWidth: 2,
                    shadowBlur: 4,
                    shadowColor: '#fff'
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        title: function(context) {
                            return 'Tahap: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.y + ' penelitian';
                        }
                    },
                    backgroundColor: '#fff',
                    titleColor: '#2563eb',
                    bodyColor: '#374151',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    padding: 14,
                    displayColors: false,
                    caretSize: 8,
                    cornerRadius: 8,
                    boxPadding: 6
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Interaktif: highlight bar saat hover, info elegan
    document.getElementById('telaahChart').onclick = function(evt) {
        const points = telaahChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
        if (points.length) {
            const idx = points[0].index;
            const label = chartLabels[idx];
            const value = chartData[idx];
            // Modal info elegan
            showElegantInfo(label, value);
        }
    };

    function showElegantInfo(label, value) {
        // Cek jika sudah ada modal, hapus dulu
        let modal = document.getElementById('chartInfoModal');
        if (modal) modal.remove();
        modal = document.createElement('div');
        modal.id = 'chartInfoModal';
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl px-8 py-6 max-w-xs w-full border-2 border-blue-200 animate-fadeIn">
                <div class="flex items-center gap-3 mb-2">
                    <span class="inline-block w-4 h-4 rounded-full" style="background: ${getColor(label)}"></span>
                    <span class="font-bold text-blue-700 text-lg">${label}</span>
                </div>
                <div class="text-4xl font-extrabold text-blue-600 text-center mb-2 drop-shadow">${value}</div>
                <div class="text-gray-500 text-center text-sm mb-4">Jumlah penelitian pada tahap ini</div>
                <button onclick="document.getElementById('chartInfoModal').remove()" class="w-full py-2 mt-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">Tutup</button>
            </div>
        `;
        document.body.appendChild(modal);
    }
    function getColor(label) {
        const map = {
            'Total Penelitian': '#3b82f6',
            'Telaah Awal': '#facc15',
            'Telaah Lanjutan': '#3b82f6',
            'Telaah Akhir': '#633d14',
            'Selesai': '#279130'
        };
        return map[label] || '#3b82f6';
    }
</script>
    
</x-Layout>
