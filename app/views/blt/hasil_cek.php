<?php $this->view('templates/header', $data); ?>

<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Hasil Pencarian</h2>
            <p class="text-gray-500">Menampilkan hasil seleksi bantuan untuk NIK: <span class="font-bold text-blue-600"><?= $data['nik_dicari']; ?></span></p>
        </div>
        <a href="<?= BASEURL; ?>/blt" class="px-6 py-3 bg-gray-50 text-gray-500 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> KEMBALI
        </a>
    </div>

    <?php if(empty($data['hasil'])): ?>
        <div class="bg-white p-20 rounded-[32px] shadow-sm border border-gray-100 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-gray-300 text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Data Tidak Ditemukan</h3>
            <p class="text-gray-500">NIK Anda belum terdaftar dalam program bantuan manapun atau seleksi belum selesai.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Program Bantuan</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Skor Akhir</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Ranking</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($data['hasil'] as $h): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-700"><?= $h['nama_program']; ?></div>
                                    <div class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest">Nama: <?= $h['nama_lengkap']; ?></div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-500"><?= $h['periode']; ?></td>
                                <td class="px-8 py-6 text-center">
                                    <span class="font-black text-blue-600 text-lg"><?= number_format($h['nilai_total'], 4); ?></span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="inline-block px-5 py-2 bg-blue-600 text-white rounded-xl font-black text-xs shadow-lg shadow-blue-100">
                                        PERINGKAT <?= $h['ranking']; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="bg-blue-50 p-8 rounded-[32px] border border-blue-100 flex items-start space-x-4">
            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
            <div>
                <h4 class="font-bold text-blue-900 mb-1 text-sm uppercase tracking-widest">Catatan Penting</h4>
                <p class="text-blue-700 text-xs leading-relaxed">
                    Hasil ini berdasarkan perhitungan algoritma SAW (Simple Additive Weighting). 
                    Penerima bantuan akan ditetapkan oleh Kepala Desa berdasarkan kuota yang tersedia dari peringkat teratas.
                    Silakan hubungi petugas desa untuk informasi penyaluran lebih lanjut.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $this->view('templates/footer', $data); ?>