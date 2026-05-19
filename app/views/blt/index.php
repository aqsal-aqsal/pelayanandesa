<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
        <h2 class="text-3xl font-black text-slate-900 mb-2">Cek Status Bantuan (BLT)</h2>
        <p class="text-gray-500 mb-8">Gunakan NIK Anda untuk mengecek hasil seleksi bantuan sosial.</p>
        
        <form action="<?= BASEURL; ?>/blt/cek_hasil" method="POST" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="nik" placeholder="Masukkan 16 digit NIK Anda..." required maxlength="16" class="flex-1 px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                Cek Hasil Sekarang
            </button>
        </form>
    </div>

    <?php if(isset($data['hasil_saya']) && !empty($data['hasil_saya'])): ?>
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-blue-50/30">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <i class="fas fa-history mr-3 text-blue-500"></i> Riwayat Hasil Seleksi Anda
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Program Bantuan</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Skor Akhir</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Ranking</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($data['hasil_saya'] as $h): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $h['nama_program']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500"><?= $h['periode']; ?></td>
                                <td class="px-8 py-5 text-center font-black text-blue-600"><?= number_format($h['nilai_total'], 4); ?></td>
                                <td class="px-8 py-5 text-right">
                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg font-black text-xs">
                                        Peringkat <?= $h['ranking']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($data['programs'] as $p): ?>
            <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl transition-all duration-300">
                <div class="p-8 flex-1">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $p['status'] == 'aktif' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-gray-50 text-gray-400 border-gray-100'; ?>">
                            <?= $p['status']; ?>
                        </span>
                        <span class="text-xs font-bold text-gray-400"><?= $p['periode']; ?></span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-3"><?= $p['nama_program']; ?></h3>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">Sumber: <?= $p['sumber_dana']; ?></p>
                    
                    <div class="space-y-3 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kuota</span>
                            <span class="font-black text-slate-700"><?= $p['kuota_penerima']; ?> KPM</span>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                    <a href="<?= BASEURL; ?>/blt/detail/<?= $p['id_program']; ?>" class="block text-center w-full py-4 bg-white border border-gray-200 text-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
                        Lihat Perankingan SAW
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
