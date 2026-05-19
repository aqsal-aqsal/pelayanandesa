<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Hasil Seleksi SAW</h2>
        <p class="text-gray-600">Daftar peringkat calon penerima bantuan berdasarkan skor akhir.</p>
    </div>
    <a href="<?= BASEURL; ?>/blt" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Ranking</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">NIK</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Skor Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['hasil'])): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Hasil perhitungan belum tersedia.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['hasil'] as $h): ?>
                        <tr class="<?= $h['ranking'] <= 5 ? 'bg-blue-50/50' : ''; ?>">
                            <td class="px-6 py-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full <?= $h['ranking'] <= 3 ? 'bg-yellow-400 text-white font-bold' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?= $h['ranking']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono"><?= $h['nik']; ?></td>
                            <td class="px-6 py-4 font-medium text-gray-900"><?= $h['nama_lengkap']; ?></td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-lg font-bold text-blue-600"><?= number_format($h['nilai_total'], 4); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 bg-blue-50 p-6 rounded-xl border border-blue-100">
    <h4 class="font-bold text-blue-800 mb-2"><i class="fas fa-info-circle mr-2"></i> Mengenai Perhitungan SAW</h4>
    <p class="text-sm text-blue-700 leading-relaxed">
        Metode <strong>Simple Additive Weighting (SAW)</strong> memberikan skor akhir berdasarkan bobot setiap kriteria (Penghasilan, Tanggungan, Kondisi Rumah, dll). Skor tertinggi menunjukkan prioritas utama sebagai penerima bantuan secara objektif dan transparan.
    </p>
</div>

<?php $this->view('templates/footer', $data); ?>
