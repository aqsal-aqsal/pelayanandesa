<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
        <h2 class="text-3xl font-black text-slate-900 mb-2">Cek Status Bantuan (BLT)</h2>
        <p class="text-gray-500 mb-8">Gunakan NIK Anda untuk mengecek hasil seleksi bantuan sosial.</p>

        <form action="<?= BASEURL; ?>/blt/cek_hasil" method="POST" class="flex flex-col md:flex-row gap-4">
            <input
                type="text"
                name="nik"
                placeholder="Masukkan 16 digit NIK Anda..."
                value="<?= htmlspecialchars((string) ($data['nik_dicari'] ?? '')) ?>"
                required
                maxlength="16"
                class="flex-1 px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
            <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                Cek Hasil Sekarang
            </button>
        </form>
    </div>

    <?php if (($data['status_cek'] ?? null) === 'lolos'): ?>
        <div class="bg-emerald-50 border border-emerald-100 p-8 rounded-[32px]">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="space-y-3">
                    <h3 class="text-2xl font-black text-emerald-900">Selamat, Anda mendapatkan program BLT</h3>
                    <p class="text-emerald-800 leading-relaxed">
                        NIK <span class="font-bold"><?= htmlspecialchars((string) ($data['nik_dicari'] ?? '-')) ?></span>
                        terdaftar sebagai penerima bantuan pada program berikut:
                    </p>
                    <div class="space-y-3">
                        <?php foreach ($data['program_lolos'] as $program): ?>
                            <div class="bg-white/80 border border-emerald-100 rounded-2xl px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <div class="font-black text-slate-800"><?= htmlspecialchars((string) ($program['nama_program'] ?? '-')) ?></div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Periode <?= htmlspecialchars((string) ($program['periode'] ?? '-')) ?> |
                                        Skor Akhir <?= number_format((float) ($program['nilai_total'] ?? 0), 4) ?> |
                                        Ranking <?= htmlspecialchars((string) ($program['ranking'] ?? '-')) ?>
                                    </div>
                                </div>
                                <a href="<?= BASEURL; ?>/blt/peringkat/<?= htmlspecialchars((string) ($program['id_program'] ?? '')) ?>" class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition whitespace-nowrap">
                                    Lihat Perangkingan SAW
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (($data['status_cek'] ?? null) === 'tidak_lolos'): ?>
        <div class="bg-rose-50 border border-rose-100 p-8 rounded-[32px]">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-2xl font-black text-rose-900">Maaf, Anda tidak masuk kriteria</h3>
                    <p class="text-rose-800 leading-relaxed">
                        NIK <span class="font-bold"><?= htmlspecialchars((string) ($data['nik_dicari'] ?? '-')) ?></span>
                        belum terdaftar sebagai penerima program BLT yang sedang dilaksanakan.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $this->view('templates/footer', $data); ?>
