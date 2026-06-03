<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
        <h2 class="text-3xl font-black text-slate-900 mb-2">Informasi Publik Desa</h2>
        <p class="text-gray-500">Berita, pengumuman, dan transparansi pelayanan Desa Astambul Kota.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php if(empty($data['informasi'])): ?>
            <div class="col-span-full bg-white p-20 rounded-[32px] text-center border border-gray-100">
                <p class="text-gray-400 italic">Belum ada informasi publik yang diterbitkan.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['informasi'] as $i): ?>
                <a href="<?= BASEURL; ?>/informasi/detail/<?= $i['id_informasi']; ?>" class="block bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <?php if($i['file_lampiran']): ?>
                        <div class="h-48 overflow-hidden">
                            <img src="<?= BASEURL; ?>/assets/img/informasi/<?= $i['file_lampiran']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="<?= $i['judul']; ?>">
                        </div>
                    <?php endif; ?>
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest">Berita Desa</span>
                            <span class="text-xs font-bold text-gray-400"><?= date('d M Y', strtotime($i['tgl_publikasi'])); ?></span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4"><?= $i['judul']; ?></h3>
                        <div class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                            <?= $i['konten']; ?>
                        </div>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-400 text-xs"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-600"><?= $i['nama_petugas']; ?></span>
                            </div>
                            <span class="text-blue-600 font-black text-[10px] uppercase tracking-widest">Baca Selengkapnya</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
