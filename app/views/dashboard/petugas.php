<?php $this->view('templates/header', $data); ?>

<div class="space-y-6">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Halo, <?= $data['user']['nik']; ?>!</h2>
        <p class="text-gray-600">Selamat datang di panel petugas. Anda dapat mengelola pengajuan surat dan pengaduan masyarakat di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">Perlu Tindakan</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Layanan Menunggu</h3>
            <p class="text-3xl font-black text-slate-900">5</p>
            <a href="<?= BASEURL; ?>/layanan/admin" class="mt-6 inline-flex items-center text-sm text-blue-600 font-bold hover:gap-2 transition-all">
                Kelola Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 group hover:border-blue-500 transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">Penting</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Pengaduan Masuk</h3>
            <p class="text-3xl font-black text-slate-900">3</p>
            <a href="<?= BASEURL; ?>/pengaduan/admin" class="mt-6 inline-flex items-center text-sm text-blue-600 font-bold hover:gap-2 transition-all">
                Lihat Semua <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
