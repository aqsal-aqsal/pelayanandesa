<?php $this->view('templates/header', $data); ?>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                <?= substr($data['user']['nik'], 0, 1); ?>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Petugas Desa</p>
                <p class="text-xs text-gray-500"><?= $data['user']['nik']; ?></p>
            </div>
        </div>
        
        <nav class="space-y-2">
            <a href="<?= BASEURL; ?>/dashboard/petugas" class="flex items-center space-x-3 p-3 rounded-lg bg-green-50 text-green-600 font-medium">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
            <a href="<?= BASEURL; ?>/layanan/admin" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-file-invoice"></i>
                <span>Kelola Layanan</span>
            </a>
            <a href="<?= BASEURL; ?>/pengaduan/admin" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Kelola Pengaduan</span>
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
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Halo, <?= $data['user']['nik']; ?>!</h2>
            <p class="text-gray-600">Selamat datang di panel petugas. Anda dapat mengelola pengajuan surat dan pengaduan masyarakat di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Layanan Menunggu</h3>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">Baru</span>
                </div>
                <p class="text-3xl font-bold text-blue-600">5</p>
                <a href="<?= BASEURL; ?>/layanan/admin" class="mt-4 inline-block text-sm text-blue-600 font-medium hover:underline">Lihat Semua &rarr;</a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pengaduan Masuk</h3>
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">Perlu Respon</span>
                </div>
                <p class="text-3xl font-bold text-yellow-600">3</p>
                <a href="<?= BASEURL; ?>/pengaduan/admin" class="mt-4 inline-block text-sm text-blue-600 font-medium hover:underline">Lihat Semua &rarr;</a>
            </div>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
