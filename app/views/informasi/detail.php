<?php $this->view('templates/header', $data); ?>

<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest">Informasi Desa</span>
                <span class="text-xs font-bold text-gray-400"><?= date('d M Y', strtotime($data['informasi']['tgl_publikasi'])); ?></span>
            </div>
            <a href="<?= BASEURL; ?>/informasi" class="px-6 py-3 bg-gray-50 text-gray-500 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> KEMBALI
            </a>
        </div>

        <h1 class="text-3xl font-black text-slate-900 mb-4"><?= $data['informasi']['judul']; ?></h1>

        <div class="flex items-center text-sm text-gray-500 mb-10">
            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-user text-gray-400 text-xs"></i>
            </div>
            <span class="font-bold text-slate-700"><?= $data['informasi']['nama_petugas']; ?></span>
        </div>

        <div class="prose prose-slate max-w-none text-gray-700 leading-relaxed">
            <?= nl2br($data['informasi']['konten']); ?>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
