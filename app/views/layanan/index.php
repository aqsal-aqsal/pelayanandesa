<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Layanan Surat Online</h2>
            <p class="text-gray-500">Kelola pengajuan surat Anda. Anda bisa mengajukan baru, edit, atau batalkan selama masih menunggu.</p>
        </div>
        <button type="button" id="btnAjukanSurat" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-100 uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Ajukan Baru
        </button>
    </div>

    <?php if(isset($_SESSION['flash'])): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl text-sm flex justify-between items-center">
            <span><?= $_SESSION['flash']['message']; ?></span>
            <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700"><i class="fas fa-times"></i></button>
            <?php unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pengajuan'])): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengajuan surat yang tercatat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengajuan'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= htmlspecialchars($p['nama_surat']); ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $p['tanggal_pengajuan'] ? date('d F Y', strtotime($p['tanggal_pengajuan'])) : '-'; ?></td>
                                <td class="px-8 py-5">
                                    <?php 
                                        $statusStyles = [
                                            'menunggu' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                            'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100'
                                        ];
                                        $style = $statusStyles[$p['status']] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    ?>
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $style; ?>">
                                        <?= htmlspecialchars($p['status']); ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right space-x-3">
                                    <button
                                        type="button"
                                        class="text-slate-700 hover:text-slate-900 font-black text-[10px] uppercase tracking-widest"
                                        data-action="detail-surat"
                                        data-id="<?= (int)$p['id_pengajuan']; ?>"
                                        data-jenis="<?= htmlspecialchars($p['nama_surat'], ENT_QUOTES); ?>"
                                        data-urgensi="<?= (int)$p['nilai_prioritas']; ?>"
                                        data-keperluan="<?= htmlspecialchars($p['keperluan'] ?? '', ENT_QUOTES); ?>"
                                        data-status="<?= htmlspecialchars($p['status'], ENT_QUOTES); ?>"
                                        data-tanggal="<?= htmlspecialchars($p['tanggal_pengajuan'] ?? '-', ENT_QUOTES); ?>"
                                        data-nosurat="<?= htmlspecialchars($p['no_surat'] ?? '-', ENT_QUOTES); ?>"
                                        data-catatan="<?= htmlspecialchars($p['catatan_penolakan'] ?? '-', ENT_QUOTES); ?>"
                                        data-berkas="<?= htmlspecialchars($p['file_berkas'] ?? '', ENT_QUOTES); ?>"
                                    >Detail</button>
                                    <?php if($p['status'] == 'menunggu'): ?>
                                        <button
                                            type="button"
                                            class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase tracking-widest"
                                            data-action="edit-surat"
                                            data-id="<?= (int)$p['id_pengajuan']; ?>"
                                            data-idjenis="<?= (int)$p['id_jenis_surat']; ?>"
                                            data-urgensi="<?= (int)$p['nilai_prioritas']; ?>"
                                            data-keperluan="<?= htmlspecialchars($p['keperluan'] ?? '', ENT_QUOTES); ?>"
                                            data-berkas="<?= htmlspecialchars($p['file_berkas'] ?? '', ENT_QUOTES); ?>"
                                        >Edit</button>
                                        <button
                                            type="button"
                                            class="text-rose-500 hover:text-rose-700 font-black text-[10px] uppercase tracking-widest"
                                            data-action="hapus-surat"
                                            data-href="<?= BASEURL; ?>/layanan/hapus_pengajuan/<?= (int)$p['id_pengajuan']; ?>"
                                        >Hapus</button>
                                    <?php elseif($p['status'] == 'selesai'): ?>
                                        <a href="<?= BASEURL; ?>/layanan/unduh/<?= $p['id_pengajuan']; ?>" target="_blank" class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase tracking-widest">Unduh</a>
                                    <?php else: ?>
                                        <span class="text-gray-300 font-black text-[10px] uppercase tracking-widest">No Action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalSurat" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalSurat"></div>
    <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="bg-blue-600 px-10 py-8 flex items-start justify-between gap-4">
                <div>
                    <h3 id="modalSuratTitle" class="text-2xl font-black text-white">Ajukan Surat Baru</h3>
                    <p class="text-blue-100 text-sm mt-1">Lengkapi data pengajuan surat Anda.</p>
                </div>
                <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalSurat"><i class="fas fa-times"></i></button>
            </div>

            <form id="formSurat" action="<?= BASEURL; ?>/layanan/ajukan" method="POST" enctype="multipart/form-data" class="p-10 space-y-8 overflow-y-auto flex-1">
                <input type="hidden" name="id_warga" value="<?= (int)$data['warga']['id_warga']; ?>">
                <input type="hidden" name="id_pengajuan" id="surat_id_pengajuan" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" disabled value="<?= htmlspecialchars($data['warga']['nama_lengkap']); ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK</label>
                        <input type="text" disabled value="<?= htmlspecialchars($data['warga']['nik']); ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</label>
                    <select name="id_jenis_surat" id="surat_id_jenis_surat" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">-- Pilih Jenis Surat --</option>
                        <?php foreach($data['jenis_surat'] as $js): ?>
                            <option value="<?= (int)$js['id_jenis_surat']; ?>"><?= htmlspecialchars($js['nama_surat']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Keperluan</label>
                    <textarea name="keperluan" id="surat_keperluan" rows="4" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Jelaskan alasan pengajuan surat ini..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Upload Berkas Pendukung (KTP/KK) <span class="text-red-500">*</span></label>
                    <input type="file" name="file_berkas" id="surat_file_berkas" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                    <p id="surat_berkas_hint" class="text-[10px] text-gray-400 italic">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                </div>

                <div class="pt-2 flex justify-end space-x-4">
                    <button type="button" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition" data-modal-close="modalSurat">Batal</button>
                    <button type="submit" id="btnSubmitSurat" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] transition-all duration-200">
                        KIRIM PENGAJUAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalDetailSurat" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalDetailSurat"></div>
    <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="bg-slate-900 px-10 py-8 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-white">Detail Pengajuan Surat</h3>
                    <p class="text-slate-200 text-sm mt-1">Berikut data pengajuan sesuai input Anda.</p>
                </div>
                <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalDetailSurat"><i class="fas fa-times"></i></button>
            </div>

            <div class="p-10 space-y-6 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</div>
                        <div id="detailSuratJenis" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</div>
                        <div id="detailSuratStatus" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal Pengajuan</div>
                        <div id="detailSuratTanggal" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No Surat</div>
                        <div id="detailSuratNo" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Berkas</div>
                        <a id="detailSuratBerkas" class="font-bold text-blue-600 hover:text-blue-800 break-all" href="#" target="_blank"></a>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Keperluan</div>
                    <div id="detailSuratKeperluan" class="text-slate-700 whitespace-pre-line"></div>
                </div>

                <div class="space-y-2">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Catatan</div>
                    <div id="detailSuratCatatan" class="text-slate-700 whitespace-pre-line"></div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition" data-modal-close="modalDetailSurat">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalHapusSurat" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalHapusSurat"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="p-10 space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Batalkan Pengajuan?</h3>
                        <p class="text-gray-500 mt-1">Pengajuan yang dibatalkan akan dihapus permanen.</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-700" data-modal-close="modalHapusSurat"><i class="fas fa-times"></i></button>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition" data-modal-close="modalHapusSurat">Batal</button>
                    <a id="btnKonfirmasiHapusSurat" href="#" class="px-6 py-3 bg-rose-600 text-white rounded-2xl font-black text-sm hover:bg-rose-700 transition">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modalSurat = document.getElementById('modalSurat');
    const modalDetailSurat = document.getElementById('modalDetailSurat');
    const modalHapusSurat = document.getElementById('modalHapusSurat');

    const formSurat = document.getElementById('formSurat');
    const modalSuratTitle = document.getElementById('modalSuratTitle');
    const btnSubmitSurat = document.getElementById('btnSubmitSurat');
    const suratIdPengajuan = document.getElementById('surat_id_pengajuan');
    const suratIdJenis = document.getElementById('surat_id_jenis_surat');
    const suratKeperluan = document.getElementById('surat_keperluan');
    const suratBerkasHint = document.getElementById('surat_berkas_hint');
    const btnKonfirmasiHapusSurat = document.getElementById('btnKonfirmasiHapusSurat');

    const openModal = (id) => document.getElementById(id).classList.remove('hidden');
    const closeModal = (id) => document.getElementById(id).classList.add('hidden');

    document.querySelectorAll('[data-modal-close]').forEach(el => {
        el.addEventListener('click', () => closeModal(el.getAttribute('data-modal-close')));
    });

    document.getElementById('btnAjukanSurat').addEventListener('click', () => {
        formSurat.action = '<?= BASEURL; ?>/layanan/ajukan';
        modalSuratTitle.textContent = 'Ajukan Surat Baru';
        btnSubmitSurat.textContent = 'KIRIM PENGAJUAN';
        suratIdPengajuan.value = '';
        suratIdJenis.value = '';
        suratKeperluan.value = '';
        suratBerkasHint.textContent = 'Format: JPG, PNG, PDF (Maks. 2MB)';
        document.getElementById('surat_file_berkas').required = true;
        document.getElementById('surat_file_berkas').value = '';
        openModal('modalSurat');
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const action = btn.getAttribute('data-action');
        if (action === 'edit-surat') {
            formSurat.action = '<?= BASEURL; ?>/layanan/update';
            modalSuratTitle.textContent = 'Edit Pengajuan Surat';
            btnSubmitSurat.textContent = 'SIMPAN PERUBAHAN';
            suratIdPengajuan.value = btn.getAttribute('data-id');
            suratIdJenis.value = btn.getAttribute('data-idjenis');
            suratKeperluan.value = btn.getAttribute('data-keperluan') || '';
            const berkas = btn.getAttribute('data-berkas');
            suratBerkasHint.textContent = berkas ? 'Kosongkan jika tidak ingin mengganti berkas.' : 'Format: JPG, PNG, PDF (Maks. 2MB)';
            document.getElementById('surat_file_berkas').required = false;
            document.getElementById('surat_file_berkas').value = '';
            openModal('modalSurat');
            return;
        }

        if (action === 'hapus-surat') {
            btnKonfirmasiHapusSurat.href = btn.getAttribute('data-href');
            openModal('modalHapusSurat');
            return;
        }

        if (action === 'detail-surat') {
            document.getElementById('detailSuratJenis').textContent = btn.getAttribute('data-jenis') || '-';
            document.getElementById('detailSuratStatus').textContent = btn.getAttribute('data-status') || '-';
            const tanggalRaw = btn.getAttribute('data-tanggal') || '-';
            const tanggalIso = tanggalRaw && tanggalRaw !== '-' ? tanggalRaw.replace(' ', 'T') : null;
            document.getElementById('detailSuratTanggal').textContent = tanggalIso ? new Date(tanggalIso).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-';
            document.getElementById('detailSuratNo').textContent = btn.getAttribute('data-nosurat') || '-';

            const berkas = btn.getAttribute('data-berkas') || '';
            const berkasEl = document.getElementById('detailSuratBerkas');
            if (berkas) {
                berkasEl.textContent = berkas;
                berkasEl.href = '<?= BASEURL; ?>/assets/uploads/' + berkas;
                berkasEl.classList.remove('hidden');
            } else {
                berkasEl.textContent = '-';
                berkasEl.href = '#';
            }

            document.getElementById('detailSuratKeperluan').textContent = btn.getAttribute('data-keperluan') || '-';
            document.getElementById('detailSuratCatatan').textContent = btn.getAttribute('data-catatan') || '-';
            openModal('modalDetailSurat');
            return;
        }
    });
</script>

<?php $this->view('templates/footer', $data); ?>
