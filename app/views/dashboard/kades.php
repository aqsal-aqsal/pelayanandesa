<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-700 to-slate-900 p-10 rounded-[32px] shadow-lg text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black mb-2">Selamat Datang, Bapak Kepala Desa!</h2>
                <p class="text-blue-100 opacity-80">Panel Monitoring dan Persetujuan Layanan Desa Astambul Kota.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-tie text-6xl text-white opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-file-signature"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Surat Perlu TTD</h3>
            <p class="text-3xl font-black text-slate-900"><?= $data['surat_perlu_ttd']; ?></p>
            <a href="<?= BASEURL; ?>/layanan/admin" class="mt-4 inline-flex items-center text-[10px] font-black text-blue-600 uppercase tracking-widest hover:gap-2 transition-all">
                Tinjau Sekarang <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-gift"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Program Aktif</h3>
            <p class="text-3xl font-black text-slate-900"><?= $data['program_aktif']; ?></p>
            <a href="<?= BASEURL; ?>/blt/admin" class="mt-4 inline-flex items-center text-[10px] font-black text-blue-600 uppercase tracking-widest hover:gap-2 transition-all">
                Kelola Bantuan <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Total Warga</h3>
            <p class="text-3xl font-black text-slate-900"><?= $data['total_warga']; ?></p>
        </div>

        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Total Pengaduan</h3>
            <p class="text-3xl font-black text-slate-900"><?= $data['total_pengaduan']; ?></p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Surat Trend -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-6">
                <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                Tren Pengajuan Surat per Bulan
            </h3>
            <canvas id="suratMonthlyChart" height="250"></canvas>
        </div>

        <!-- Surat Type Distribution -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-6">
                <i class="fas fa-chart-pie mr-2 text-purple-600"></i>
                Distribusi Jenis Surat Terbanyak
            </h3>
            <canvas id="suratTypeChart" height="250"></canvas>
        </div>
    </div>

    <!-- Average SAW per Program -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
        <h3 class="text-xl font-black text-slate-900 mb-6">
            <i class="fas fa-chart-bar mr-2 text-green-600"></i>
            Rata-rata Nilai Preferensi SAW per Program Bantuan
        </h3>
        <canvas id="bltAvgSAWChart" height="200"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Surat Monthly Trend Chart
const suratMonthlyCtx = document.getElementById('suratMonthlyChart').getContext('2d');
const suratMonthlyData = <?= json_encode($data['surat_monthly_trend']) ?>;
new Chart(suratMonthlyCtx, {
    type: 'line',
    data: {
        labels: suratMonthlyData.map(item => {
            const [year, month] = item.bulan.split('-');
            const date = new Date(year, month - 1);
            return date.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
        }),
        datasets: [{
            label: 'Jumlah Pengajuan Surat',
            data: suratMonthlyData.map(item => item.jumlah),
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
    }
});

// Surat Type Distribution Chart
const suratTypeCtx = document.getElementById('suratTypeChart').getContext('2d');
const suratTypeData = <?= json_encode($data['surat_type_dist']) ?>;
new Chart(suratTypeCtx, {
    type: 'doughnut',
    data: {
        labels: suratTypeData.map(item => item.nama_surat),
        datasets: [{
            data: suratTypeData.map(item => item.jumlah),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(234, 179, 8, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Average SAW per Program Chart
const bltAvgSAWCtx = document.getElementById('bltAvgSAWChart').getContext('2d');
const bltAvgSAWData = <?= json_encode($data['blt_avg_saw']) ?>;
new Chart(bltAvgSAWCtx, {
    type: 'bar',
    data: {
        labels: bltAvgSAWData.map(item => item.nama_program),
        datasets: [{
            label: 'Rata-rata Nilai Preferensi SAW',
            data: bltAvgSAWData.map(item => parseFloat(item.rata_rata_nilai || 0)),
            backgroundColor: 'rgba(34, 197, 94, 0.7)',
            borderRadius: 8,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true, max: 1 }
        }
    }
});
</script>

<?php $this->view('templates/footer', $data); ?>
