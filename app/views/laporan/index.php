<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Laporan & Statistik</h2>
            <p class="text-gray-500">Monitoring kinerja pelayanan desa dan hasil seleksi bantuan.</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?= BASEURL; ?>/laporan/cetak_surat" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                <i class="fas fa-file-pdf mr-2"></i> CETAK LAPORAN SURAT
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-envelope-open-text text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_surat']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pengajuan Surat</div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_pengaduan']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pengaduan</div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-hand-holding-heart text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_program']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Program Bantuan</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Surat Stats -->
        <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-8">Status Pelayanan Surat</h3>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Selesai</span>
                        <span class="text-blue-600"><?= $data['stats_surat']['selesai']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['selesai'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Sedang Diproses</span>
                        <span class="text-amber-600"><?= $data['stats_surat']['proses']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['proses'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Ditolak</span>
                        <span class="text-rose-600"><?= $data['stats_surat']['ditolak']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['ditolak'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export BLT -->
        <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-8">Cetak Hasil Seleksi BLT</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Pilih program bantuan untuk mengunduh laporan hasil perhitungan perankingan SAW.</p>
            
            <div class="space-y-4">
                <?php 
                    $bltModel = $this->model('BltModel');
                    $programs = $bltModel->getPrograms();
                    foreach($programs as $p): 
                ?>
                    <div class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl hover:bg-blue-50 transition group">
                        <div>
                            <div class="font-bold text-slate-700"><?= $p['nama_program']; ?></div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1"><?= $p['periode']; ?></div>
                        </div>
                        <a href="<?= BASEURL; ?>/laporan/cetak_blt/<?= $p['id_program']; ?>" target="_blank" class="p-3 bg-white text-blue-600 rounded-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>