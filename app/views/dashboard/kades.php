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
</div>

<?php $this->view('templates/footer', $data); ?>
