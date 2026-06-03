<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 rounded-3xl shadow-lg text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, <?= $data['user']['nik']; ?>!</h2>
                <p class="text-blue-100 text-lg">Panel Administrasi Pelayanan Desa Astambul Kota</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-shield text-6xl text-blue-500 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Surat Masuk -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Surat Masuk</h3>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900"><?= $data['total_surat_masuk']; ?></span>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Menunggu</span>
            </div>
        </div>

        <!-- Aduan Masuk -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Aduan Masuk</h3>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900"><?= $data['total_aduan_masuk']; ?></span>
                <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded">Baru</span>
            </div>
        </div>

        <!-- Total Warga -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Total Warga</h3>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900"><?= $data['total_warga']; ?></span>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded">Terdaftar</span>
            </div>
        </div>

        <!-- Program Bantuan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Program Bantuan</h3>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900"><?= $data['total_program']; ?></span>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded">Aktif</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i> Akses Cepat
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= BASEURL; ?>/layanan/admin" class="p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition group">
                    <i class="fas fa-tasks mb-2 group-hover:scale-110 transition"></i>
                    <p class="text-sm font-semibold">Verifikasi Surat</p>
                </a>
                <a href="<?= BASEURL; ?>/pengaduan/admin" class="p-4 bg-gray-50 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition group">
                    <i class="fas fa-bullhorn mb-2 group-hover:scale-110 transition"></i>
                    <p class="text-sm font-semibold">Verifikasi Aduan</p>
                </a>
                <a href="<?= BASEURL; ?>/warga/admin" class="p-4 bg-gray-50 rounded-xl hover:bg-green-50 hover:text-green-600 transition group">
                    <i class="fas fa-user-plus mb-2 group-hover:scale-110 transition"></i>
                    <p class="text-sm font-semibold">Tambah Warga</p>
                </a>
                <a href="<?= BASEURL; ?>/informasi/admin" class="p-4 bg-gray-50 rounded-xl hover:bg-purple-50 hover:text-purple-600 transition group">
                    <i class="fas fa-plus-circle mb-2 group-hover:scale-110 transition"></i>
                    <p class="text-sm font-semibold">Buat Berita</p>
                </a>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-clock text-blue-500 mr-2"></i> Informasi Sistem
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Versi Sistem</span>
                    <span class="text-sm font-bold">v1.0.4-beta</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Status Server</span>
                    <span class="flex items-center text-sm font-bold text-green-600">
                        <span class="w-2 h-2 bg-green-600 rounded-full mr-2 animate-pulse"></span> Online
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Waktu Server</span>
                    <span class="text-sm font-bold"><?= date('d M Y H:i'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
