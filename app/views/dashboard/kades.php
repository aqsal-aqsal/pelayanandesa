<?php $this->view('templates/header', $data); ?>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                <?= substr($data['user']['nik'], 0, 1); ?>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Kepala Desa</p>
                <p class="text-xs text-gray-500"><?= $data['user']['nik']; ?></p>
            </div>
        </div>
        
        <nav class="space-y-2">
            <a href="<?= BASEURL; ?>/dashboard/kades" class="flex items-center space-x-3 p-3 rounded-lg bg-blue-50 text-blue-600 font-medium">
                <i class="fas fa-chart-line"></i>
                <span>Statistik</span>
            </a>
            <a href="<?= BASEURL; ?>/layanan/admin" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-file-invoice"></i>
                <span>Data Layanan</span>
            </a>
            <a href="<?= BASEURL; ?>/pengaduan/admin" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Data Pengaduan</span>
            </a>
            <a href="<?= BASEURL; ?>/blt/admin" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-users"></i>
                <span>Data BLT (SAW)</span>
            </a>
            <hr class="my-4">
            <a href="<?= BASEURL; ?>/auth/logout" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Total Surat</p>
                <p class="text-2xl font-bold text-gray-900"><?= $data['total_surat']; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Total Pengaduan</p>
                <p class="text-2xl font-bold text-gray-900"><?= $data['total_pengaduan']; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Penerima BLT</p>
                <p class="text-2xl font-bold text-gray-900">120</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Warga Terdaftar</p>
                <p class="text-2xl font-bold text-gray-900">1.250</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Jumlah Surat per Bulan</h3>
                <canvas id="suratChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Status Pengaduan</h3>
                <canvas id="pengaduanChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Surat Chart
    const ctxSurat = document.getElementById('suratChart').getContext('2d');
    new Chart(ctxSurat, {
        type: 'line',
        data: {
            labels: <?= json_encode($data['chart_surat']['labels']); ?>,
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: <?= json_encode($data['chart_surat']['data']); ?>,
                borderColor: 'rgb(37, 99, 235)',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Pengaduan Chart
    const ctxPengaduan = document.getElementById('pengaduanChart').getContext('2d');
    new Chart(ctxPengaduan, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Diproses', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [45, 25, 15, 5],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(234, 179, 8)',
                    'rgb(59, 130, 246)',
                    'rgb(239, 68, 68)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<?php $this->view('templates/footer', $data); ?>
