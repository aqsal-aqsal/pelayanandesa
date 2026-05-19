<?php $this->view('templates/header', $data); ?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-4 right-4 text-gray-300 group-hover:text-emerald-500 transition">
            <i class="fas fa-ellipsis-v"></i>
        </div>
        <p class="text-sm font-semibold text-gray-500 mb-4">Total Surat Diajukan</p>
        <div class="flex items-end justify-between">
            <div>
                <h3 class="text-4xl font-bold text-slate-900 mb-2"><?= $data['total_surat']; ?></h3>
                <p class="text-xs font-bold text-emerald-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 40% <span class="text-gray-400 font-normal ml-1">vs last month</span>
                </p>
            </div>
            <div class="w-24 h-12">
                <canvas id="miniChart1"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-4 right-4 text-gray-300 group-hover:text-rose-500 transition">
            <i class="fas fa-ellipsis-v"></i>
        </div>
        <p class="text-sm font-semibold text-gray-500 mb-4">Pengaduan Selesai</p>
        <div class="flex items-end justify-between">
            <div>
                <h3 class="text-4xl font-bold text-slate-900 mb-2">1,210</h3>
                <p class="text-xs font-bold text-rose-500 flex items-center">
                    <i class="fas fa-arrow-down mr-1"></i> 10% <span class="text-gray-400 font-normal ml-1">vs last month</span>
                </p>
            </div>
            <div class="w-24 h-12">
                <canvas id="miniChart2"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-4 right-4 text-gray-300 group-hover:text-emerald-500 transition">
            <i class="fas fa-ellipsis-v"></i>
        </div>
        <p class="text-sm font-semibold text-gray-500 mb-4">Permintaan Verifikasi</p>
        <div class="flex items-end justify-between">
            <div>
                <h3 class="text-4xl font-bold text-slate-900 mb-2">316</h3>
                <p class="text-xs font-bold text-emerald-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 20% <span class="text-gray-400 font-normal ml-1">vs last month</span>
                </p>
            </div>
            <div class="w-24 h-12">
                <canvas id="miniChart3"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Section: Pengajuan Terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Daftar Pengajuan Terbaru</h3>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" placeholder="Search" class="pl-8 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Warga</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <!-- Data will come from backend, this is matching UI ref -->
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">A</div>
                            <span class="text-sm font-medium text-slate-700">Ahmad Sahid</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">Surat Keterangan Usaha</td>
                    <td class="px-6 py-4 text-sm text-gray-500">24 Januari 2026</td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-gray-400 hover:text-blue-600 transition mx-2"><i class="fas fa-edit text-xs"></i></button>
                        <button class="text-gray-400 hover:text-rose-600 transition mx-2"><i class="fas fa-trash text-xs"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/30">
        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50">Selanjutnya</button>
        </div>
        <span class="text-xs text-gray-400">Halaman 1 dari 10</span>
    </div>
</div>

<script>
    // Mock Mini Charts
    const createMiniChart = (id, color) => {
        new Chart(document.getElementById(id), {
            type: 'line',
            data: {
                labels: [1,2,3,4,5,6],
                datasets: [{
                    data: [10, 25, 15, 30, 20, 35],
                    borderColor: color,
                    borderWidth: 2,
                    pointRadius: 0,
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    };

    createMiniChart('miniChart1', '#10B981');
    createMiniChart('miniChart2', '#F43F5E');
    createMiniChart('miniChart3', '#10B981');
</script>

<?php $this->view('templates/footer', $data); ?>
