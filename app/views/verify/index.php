<?php $this->view('templates/header', $data); ?>

<?php
$surat = $data['surat'] ?? null;
$logoUrl = null;
if (!empty($surat['qr_logo_kades'])) {
    $logoUrl = BASEURL . '/assets/uploads/' . rawurlencode($surat['qr_logo_kades']);
}
?>

<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-black text-slate-900">Sistem Verifikasi Surat</h2>
        <p class="mt-3 text-gray-600">Scan QR Code pada surat atau masukkan token untuk mengecek keaslian dokumen secara publik.</p>
    </div>

    <div class="bg-slate-950 text-white rounded-[32px] shadow-2xl overflow-hidden border border-slate-800">
        <?php if ($surat): ?>
            <div class="h-2 bg-emerald-500"></div>
            <div class="p-8 md:p-10 space-y-8">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/15 text-emerald-400 flex items-center justify-center mx-auto mb-5 text-3xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black">Sertifikat Terverifikasi</h3>
                    <p class="text-slate-300 mt-3 max-w-2xl mx-auto">Dokumen ini telah melalui proses verifikasi digital dan terdaftar dalam database resmi website desa.</p>
                    <div class="mt-5 flex flex-wrap justify-center gap-3 text-xs">
                        <span class="px-3 py-2 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
                            <i class="fas fa-link mr-2 text-emerald-400"></i>Tanda tangan digital terverifikasi
                        </span>
                        <span class="px-3 py-2 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
                            <i class="fas fa-database mr-2 text-cyan-400"></i>Terdaftar dalam database
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-slate-900/70 border border-slate-800 rounded-3xl p-6">
                        <h4 class="text-lg font-bold text-white mb-5">Proses Verifikasi Sertifikat</h4>
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="text-cyan-400 font-black text-lg">1</div>
                                <div>
                                    <div class="font-semibold text-slate-100">Pemindaian QR Code</div>
                                    <div class="text-sm text-slate-400">QR pada surat diidentifikasi dan diarahkan ke halaman verifikasi publik desa.</div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-cyan-400 font-black text-lg">2</div>
                                <div>
                                    <div class="font-semibold text-slate-100">Pencocokan Data</div>
                                    <div class="text-sm text-slate-400">Sistem membandingkan token QR dengan dokumen yang tersimpan dalam database resmi.</div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-cyan-400 font-black text-lg">3</div>
                                <div>
                                    <div class="font-semibold text-slate-100">Konfirmasi Keaslian</div>
                                    <div class="text-sm text-slate-400">Detail surat, pemilik, penerbit, dan tanggal terbit ditampilkan sebagai bukti verifikasi.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-b from-emerald-500/20 to-slate-900 border border-emerald-500/20 rounded-3xl p-6 text-center">
                        <?php if ($logoUrl): ?>
                            <img src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo Verifikator" class="w-20 h-20 object-contain mx-auto mb-5">
                        <?php else: ?>
                            <div class="w-20 h-20 rounded-full bg-emerald-500/15 text-emerald-400 flex items-center justify-center mx-auto mb-5 text-3xl">
                                <i class="fas fa-shield-check"></i>
                            </div>
                        <?php endif; ?>
                        <div class="text-xl font-black">Terverifikasi</div>
                        <p class="text-sm text-slate-300 mt-2">Dokumen sah dan tercatat pada sistem verifikasi desa.</p>
                        <div class="mt-5 px-4 py-3 rounded-2xl bg-emerald-500 text-slate-950 font-black text-sm">VALID</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-900/70 border border-slate-800 rounded-3xl p-6">
                        <h4 class="text-lg font-bold mb-5">Detail Sertifikat</h4>
                        <div class="space-y-4">
                            <div class="rounded-2xl border border-slate-800 px-4 py-3">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">Nomor Surat</div>
                                <div class="text-slate-100 font-semibold mt-1"><?= htmlspecialchars((string) ($surat['no_surat'] ?? '-')) ?></div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 px-4 py-3">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">Tanggal Terbit</div>
                                <div class="text-slate-100 font-semibold mt-1"><?= !empty($surat['tanggal_selesai']) ? date('d F Y', strtotime($surat['tanggal_selesai'])) : '-' ?></div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 px-4 py-3">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">Jenis Surat</div>
                                <div class="text-slate-100 font-semibold mt-1"><?= htmlspecialchars((string) ($surat['nama_surat'] ?? '-')) ?></div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 px-4 py-3">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">Token Verifikasi</div>
                                <div class="text-slate-100 font-semibold mt-1 break-all"><?= htmlspecialchars((string) ($surat['qr_token'] ?? '-')) ?></div>
                            </div>
                            <?php if (!empty($surat['keperluan'])): ?>
                                <div class="rounded-2xl border border-slate-800 px-4 py-3">
                                    <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">Keperluan</div>
                                    <div class="text-slate-100 font-semibold mt-1"><?= htmlspecialchars((string) $surat['keperluan']) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-slate-900/70 border border-slate-800 rounded-3xl p-6">
                            <h4 class="text-lg font-bold mb-5">Informasi Pemegang</h4>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-3xl">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-black text-slate-100"><?= htmlspecialchars((string) ($surat['nama_lengkap'] ?? '-')) ?></div>
                                    <div class="text-sm text-slate-400">NIK: <?= htmlspecialchars((string) ($surat['nik'] ?? '-')) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-900/70 border border-slate-800 rounded-3xl p-6">
                            <h4 class="text-lg font-bold mb-5">Informasi Penerbit</h4>
                            <div class="space-y-2 text-slate-300">
                                <div class="font-semibold text-slate-100"><?= htmlspecialchars((string) ($surat['jabatan'] ?? 'Kepala Desa Astambul Kota')) ?></div>
                                <div><?= htmlspecialchars((string) ($surat['nama_kades'] ?? 'Desa Astambul Kota')) ?></div>
                                <div class="text-sm text-slate-400">Website desa memvalidasi dokumen ini sebagai arsip resmi yang sah.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="p-10 md:p-14 text-center">
                <div class="w-20 h-20 rounded-full bg-rose-500/10 text-rose-400 flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-2xl font-black mb-3">Dokumen Tidak Ditemukan</h3>
                <p class="text-slate-300 mb-8 max-w-xl mx-auto">Token verifikasi tidak valid, belum terdaftar, atau dokumen belum disahkan secara digital oleh sistem desa.</p>

                <form action="<?= BASEURL; ?>/verify/check" method="POST" class="max-w-lg mx-auto">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="token" placeholder="Masukkan token verifikasi..." class="flex-1 bg-slate-900 border border-slate-700 text-white text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-5 py-4">
                        <button type="submit" class="px-6 py-4 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 font-black text-sm">Cek Verifikasi</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-8 text-center">
        <a href="<?= BASEURL; ?>" class="text-blue-600 hover:underline font-medium">Kembali ke Beranda</a>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
