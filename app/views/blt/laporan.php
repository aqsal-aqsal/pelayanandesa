<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-xl font-black text-slate-900 mb-2">Program: <?= htmlspecialchars((string)($data['program']['nama_program'] ?? '-')) ?></h2>
            <p class="text-gray-500">Periode: <?= htmlspecialchars((string)($data['program']['periode'] ?? '-')) ?></p>
        </div>
        <div class="flex gap-3">
            <a href="<?= BASEURL; ?>/blt/admin" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> KEMBALI
            </a>
        </div>
    </div>

    <!-- Kriteria & Bobot -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-10">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Kriteria & Bobot yang Digunakan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Kriteria</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bobot (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1; foreach ($data['kriteria'] as $k): ?>
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-sm font-mono"><?= $no++ ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-700"><?= htmlspecialchars((string)($k['nama_kriteria'] ?? '-')) ?></td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= ($k['tipe_kriteria'] ?? '') === 'benefit' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-rose-50 text-rose-600 border-rose-100' ?>">
                                <?= htmlspecialchars((string)($k['tipe_kriteria'] ?? '-')) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-700"><?= number_format((float)($k['bobot'] ?? 0), 2) ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hasil Perhitungan Detail -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-10">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Detail Perhitungan Setiap Calon Penerima</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ranking</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                        <?php foreach ($data['kriteria'] as $k): ?>
                            <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest" colspan="3">
                                <?= htmlspecialchars((string)($k['nama_kriteria'] ?? '-')) ?> (<?= htmlspecialchars((string)($k['bobot'] ?? 0)) ?>%)
                            </th>
                        <?php endforeach; ?>
                        <th class="px-4 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Skor</th>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest"></th>
                        <th class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest"></th>
                        <th class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest"></th>
                        <?php foreach ($data['kriteria'] as $k): ?>
                            <th class="px-4 py-2 text-[10px] font-bold text-blue-400 uppercase tracking-widest">Nilai Asli</th>
                            <th class="px-4 py-2 text-[10px] font-bold text-amber-400 uppercase tracking-widest">Normalisasi</th>
                            <th class="px-4 py-2 text-[10px] font-bold text-green-400 uppercase tracking-widest">Terbobot</th>
                        <?php endforeach; ?>
                        <th class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($data['detailed_saw'] as $ds): ?>
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-4 py-4 text-sm">
                            <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider bg-blue-50 text-blue-600 border-blue-100">
                                <?= htmlspecialchars((string)($ds['ranking'] ?? '-')) ?>
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm font-mono"><?= htmlspecialchars((string)($ds['nik'] ?? '-')) ?></td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-700"><?= htmlspecialchars((string)($ds['nama_lengkap'] ?? '-')) ?></td>
                        <?php foreach ($ds['kriteria'] as $dk): ?>
                            <td class="px-4 py-4 text-sm text-gray-600"><?= number_format((float)($dk['nilai_asli'] ?? 0), 3) ?></td>
                            <td class="px-4 py-4 text-sm text-gray-600"><?= htmlspecialchars((string)($dk['nilai_normalisasi'] ?? '0.0000')) ?></td>
                            <td class="px-4 py-4 text-sm text-gray-600"><?= htmlspecialchars((string)($dk['nilai_terbobot'] ?? '0.0000')) ?></td>
                        <?php endforeach; ?>
                        <td class="px-4 py-4 text-sm font-bold text-slate-800"><?= htmlspecialchars((string)($ds['nilai_total'] ?? '0.0000')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Final Ranking -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-10">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Ranking Akhir & Status Penerima</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ranking</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Skor</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($data['hasil_saw'] as $hs): ?>
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider bg-blue-50 text-blue-600 border-blue-100">
                                <?= htmlspecialchars((string)($hs['ranking'] ?? '-')) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-mono"><?= htmlspecialchars((string)($hs['nik'] ?? '-')) ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-700"><?= htmlspecialchars((string)($hs['nama_lengkap'] ?? '-')) ?></td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-700"><?= number_format((float)($hs['nilai_total'] ?? 0), 4) ?></td>
                        <td class="px-6 py-4 text-sm">
                            <?php 
                            $status = $hs['status'] ?? '-';
                            $statusClass = match($status) {
                                'terpilih' => 'bg-green-50 text-green-600 border-green-100',
                                'tidak_terpilih' => 'bg-gray-50 text-gray-600 border-gray-100',
                                'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'diusulkan' => 'bg-blue-50 text-blue-600 border-blue-100',
                                default => 'bg-gray-50 text-gray-600 border-gray-100'
                            };
                            ?>
                            <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $statusClass ?>">
                                <?= htmlspecialchars((string)$status) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
