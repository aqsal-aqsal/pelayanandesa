<?php $this->view('templates/header', $data); ?>

<div class="max-w-7xl mx-auto space-y-8">
    <div class="bg-white p-8 md:p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Ranking Akhir &amp; Status Penerima</h2>
            <p class="text-gray-500">
                Program <span class="font-bold text-blue-600"><?= htmlspecialchars((string) ($data['program']['nama_program'] ?? '-')) ?></span>
                periode <?= htmlspecialchars((string) ($data['program']['periode'] ?? '-')) ?>.
            </p>
        </div>
        <a href="<?= BASEURL; ?>/blt" class="inline-flex items-center justify-center px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($data['hasil'])): ?>
            <div class="px-8 py-20 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-list-ol text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Ranking Belum Tersedia</h3>
                <p class="text-gray-500">Perhitungan SAW untuk program ini belum dipublikasikan.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/60">
                        <tr>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.24em]">Ranking</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.24em]">NIK</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.24em]">Nama Lengkap</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.24em] text-right">Total Skor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($data['hasil'] as $h): ?>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center justify-center min-w-[40px] h-8 px-3 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 font-black text-sm">
                                        <?= htmlspecialchars((string) ($h['ranking'] ?? '-')) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-base text-slate-800">
                                    <?= htmlspecialchars((string) ($h['nik'] ?? '-')) ?>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xl font-semibold text-slate-800">
                                        <?= htmlspecialchars((string) ($h['nama_lengkap'] ?? '-')) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-xl font-black text-slate-800">
                                        <?= number_format((float) ($h['nilai_total'] ?? 0), 4) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
