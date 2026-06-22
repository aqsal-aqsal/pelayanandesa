<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Pengaduan Masyarakat</h2>
            <p class="text-gray-500">Kelola pengaduan Anda. Anda bisa membuat baru, edit, atau hapus selama masih menunggu.</p>
        </div>
        <button type="button" id="btnBuatPengaduan" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-100 uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Buat Pengaduan
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pengaduan'])): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengaduan yang tercatat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengaduan'] as $a): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= htmlspecialchars($a['judul_aduan']); ?></td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        <?= htmlspecialchars($a['kategori_aduan']); ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $a['tanggal_aduan'] ? date('d F Y', strtotime($a['tanggal_aduan'])) : '-'; ?></td>
                                <td class="px-8 py-5">
                                    <?php 
                                        $statusStyles = [
                                            'menunggu' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                            'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100'
                                        ];
                                        $style = $statusStyles[$a['status']] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    ?>
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $style; ?>">
                                        <?= htmlspecialchars($a['status']); ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-bold text-slate-600 elapsed-time" data-start-time="<?= htmlspecialchars($a['tanggal_aduan']); ?>" data-status="<?= htmlspecialchars($a['status']); ?>" data-end-time="<?= htmlspecialchars($a['tanggal_selesai'] ?? ''); ?>">
                                        --
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right space-x-3">
                                    <button
                                        type="button"
                                        class="text-slate-700 hover:text-slate-900 font-black text-[10px] uppercase tracking-widest"
                                        data-action="detail-aduan"
                                        data-id="<?= (int)$a['id_pengaduan']; ?>"
                                        data-judul="<?= htmlspecialchars($a['judul_aduan'], ENT_QUOTES); ?>"
                                        data-kategori="<?= htmlspecialchars($a['kategori_aduan'], ENT_QUOTES); ?>"
                                        data-isi="<?= htmlspecialchars($a['isi_aduan'] ?? '', ENT_QUOTES); ?>"
                                        data-status="<?= htmlspecialchars($a['status'], ENT_QUOTES); ?>"
                                        data-tanggal="<?= htmlspecialchars($a['tanggal_aduan'] ?? '-', ENT_QUOTES); ?>"
                                        data-catatan="<?= htmlspecialchars($a['catatan_penolakan'] ?? '-', ENT_QUOTES); ?>"
                                        data-bukti="<?= htmlspecialchars($a['file_bukti'] ?? '', ENT_QUOTES); ?>"
                                    >Detail</button>
                                    <?php if($a['status'] == 'menunggu'): ?>
                                        <button
                                            type="button"
                                            class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase tracking-widest"
                                            data-action="edit-aduan"
                                            data-id="<?= (int)$a['id_pengaduan']; ?>"
                                            data-judul="<?= htmlspecialchars($a['judul_aduan'], ENT_QUOTES); ?>"
                                            data-kategori="<?= htmlspecialchars($a['kategori_aduan'], ENT_QUOTES); ?>"
                                            data-isi="<?= htmlspecialchars($a['isi_aduan'] ?? '', ENT_QUOTES); ?>"
                                            data-bukti="<?= htmlspecialchars($a['file_bukti'] ?? '', ENT_QUOTES); ?>"
                                        >Edit</button>
                                        <button
                                            type="button"
                                            class="text-rose-500 hover:text-rose-700 font-black text-[10px] uppercase tracking-widest"
                                            data-action="hapus-aduan"
                                            data-href="<?= BASEURL; ?>/pengaduan/hapus/<?= (int)$a['id_pengaduan']; ?>"
                                        >Hapus</button>
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

<div id="modalAduan" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalAduan"></div>
    <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="bg-blue-600 px-10 py-8 flex items-start justify-between gap-4">
                <div>
                    <h3 id="modalAduanTitle" class="text-2xl font-black text-white">Buat Pengaduan</h3>
                    <p class="text-blue-100 text-sm mt-1">Sampaikan keluhan atau aspirasi Anda secara aman dan cepat.</p>
                </div>
                <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalAduan"><i class="fas fa-times"></i></button>
            </div>
            
            <form id="formAduan" action="<?= BASEURL; ?>/pengaduan/kirim" method="POST" enctype="multipart/form-data" class="p-10 space-y-8 overflow-y-auto flex-1">
                <input type="hidden" name="id_warga" value="<?= (int)$data['warga']['id_warga']; ?>">
                <input type="hidden" name="id_pengaduan" id="aduan_id_pengaduan" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Laporan</label>
                        <input type="text" name="judul_aduan" id="aduan_judul" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Apa yang ingin Anda laporkan?">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</label>
                        <select name="kategori_aduan" id="aduan_kategori" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="pelayanan">Pelayanan Publik</option>
                            <option value="infrastruktur">Infrastruktur (Jalan/Jembatan)</option>
                            <option value="keamanan">Keamanan Lingkungan</option>
                            <option value="sosial">Sosial & Bantuan</option>
                            <option value="lingkungan">Kebersihan & Lingkungan</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Isi Laporan / Detail Pengaduan</label>
                    <textarea name="isi_aduan" id="aduan_isi" rows="5" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Ceritakan detail kejadian atau keluhan Anda secara lengkap..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Lampiran Bukti (Foto/Dokumen)</label>
                    <div class="relative group">
                        <input type="file" name="file_bukti" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="px-5 py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl flex items-center justify-center space-x-3 group-hover:bg-blue-50 group-hover:border-blue-200 transition">
                            <i class="fas fa-cloud-upload-alt text-gray-400 group-hover:text-blue-500"></i>
                            <span class="text-sm text-gray-500 group-hover:text-blue-600 font-medium">Klik untuk upload file bukti</span>
                        </div>
                    </div>
                    <p id="aduan_bukti_hint" class="text-[10px] text-gray-400 italic">Maksimal ukuran file 2MB (JPG, PNG, PDF)</p>
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <button type="button" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition" data-modal-close="modalAduan">Batal</button>
                    <button type="submit" id="btnSubmitAduan" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] transition-all duration-200">
                        KIRIM PENGADUAN SEKARANG
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalDetailAduan" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalDetailAduan"></div>
    <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="bg-slate-900 px-10 py-8 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-white">Detail Pengaduan</h3>
                    <p class="text-slate-200 text-sm mt-1">Berikut data laporan sesuai input Anda.</p>
                </div>
                <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalDetailAduan"><i class="fas fa-times"></i></button>
            </div>

            <div class="p-10 space-y-6 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul</div>
                        <div id="detailAduanJudul" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</div>
                        <div id="detailAduanStatus" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</div>
                        <div id="detailAduanKategori" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</div>
                        <div id="detailAduanTanggal" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lampiran Bukti</div>
                        <a id="detailAduanBukti" class="font-bold text-blue-600 hover:text-blue-800 break-all" href="#" target="_blank"></a>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Isi Laporan</div>
                    <div id="detailAduanIsi" class="text-slate-700 whitespace-pre-line"></div>
                </div>

                <div class="space-y-2">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Catatan</div>
                    <div id="detailAduanCatatan" class="text-slate-700 whitespace-pre-line"></div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition" data-modal-close="modalDetailAduan">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalHapusAduan" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalHapusAduan"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="p-10 space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Hapus Pengaduan?</h3>
                        <p class="text-gray-500 mt-1">Pengaduan yang dihapus akan hilang permanen.</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-700" data-modal-close="modalHapusAduan"><i class="fas fa-times"></i></button>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition" data-modal-close="modalHapusAduan">Batal</button>
                    <a id="btnKonfirmasiHapusAduan" href="#" class="px-6 py-3 bg-rose-600 text-white rounded-2xl font-black text-sm hover:bg-rose-700 transition">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to format elapsed time
    function formatElapsedTime(seconds) {
        if (seconds < 60) {
            return seconds + ' detik';
        } else if (seconds < 3600) {
            return Math.floor(seconds / 60) + ' menit';
        } else if (seconds < 86400) {
            return Math.floor(seconds / 3600) + ' jam';
        } else {
            return Math.floor(seconds / 86400) + ' hari';
        }
    }

    // Function to update all elapsed times
    function updateElapsedTimes() {
        const now = new Date();
        const timeElements = document.querySelectorAll('.elapsed-time');
        
        timeElements.forEach(el => {
            const startTimeStr = el.getAttribute('data-start-time');
            const endTimeStr = el.getAttribute('data-end-time');
            const status = el.getAttribute('data-status');
            
            if (!startTimeStr) return;
            
            const startTime = new Date(startTimeStr.replace(' ', 'T')); // Convert to ISO for Safari
            let endTime;
            
            if (status === 'selesai' && endTimeStr) {
                endTime = new Date(endTimeStr.replace(' ', 'T'));
            } else if (status === 'ditolak') {
                endTime = null; // Or maybe use updated_at?
            } else {
                endTime = now;
            }
            
            let elapsedSeconds = 0;
            if (endTime) {
                elapsedSeconds = Math.floor((endTime - startTime) / 1000);
            } else {
                elapsedSeconds = Math.floor((now - startTime) / 1000);
            }
            
            if (elapsedSeconds > 0) {
                el.textContent = formatElapsedTime(elapsedSeconds);
            }
        });
    }

    // Run initially and then every second
    updateElapsedTimes();
    setInterval(updateElapsedTimes, 1000);

    const modalAduan = document.getElementById('modalAduan');
    const modalDetailAduan = document.getElementById('modalDetailAduan');
    const modalHapusAduan = document.getElementById('modalHapusAduan');
    
    const formAduan = document.getElementById('formAduan');
    const modalAduanTitle = document.getElementById('modalAduanTitle');
    const btnSubmitAduan = document.getElementById('btnSubmitAduan');
    const aduanIdPengaduan = document.getElementById('aduan_id_pengaduan');
    const aduanJudul = document.getElementById('aduan_judul');
    const aduanKategori = document.getElementById('aduan_kategori');
    const aduanIsi = document.getElementById('aduan_isi');
    const aduanBuktiHint = document.getElementById('aduan_bukti_hint');
    const btnKonfirmasiHapusAduan = document.getElementById('btnKonfirmasiHapusAduan');
    
    const openModal = (id) => document.getElementById(id).classList.remove('hidden');
    const closeModal = (id) => document.getElementById(id).classList.add('hidden');
    
    document.querySelectorAll('[data-modal-close]').forEach(el => {
        el.addEventListener('click', () => closeModal(el.getAttribute('data-modal-close')));
    });
    
    document.getElementById('btnBuatPengaduan').addEventListener('click', () => {
        formAduan.action = '<?= BASEURL; ?>/pengaduan/kirim';
        modalAduanTitle.textContent = 'Buat Pengaduan';
        btnSubmitAduan.textContent = 'KIRIM PENGADUAN SEKARANG';
        aduanIdPengaduan.value = '';
        aduanJudul.value = '';
        aduanKategori.value = 'pelayanan';
        aduanIsi.value = '';
        aduanBuktiHint.textContent = 'Maksimal ukuran file 2MB (JPG, PNG, PDF)';
        openModal('modalAduan');
    });
    
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        
        const action = btn.getAttribute('data-action');
        if (action === 'edit-aduan') {
            formAduan.action = '<?= BASEURL; ?>/pengaduan/update';
            modalAduanTitle.textContent = 'Edit Pengaduan';
            btnSubmitAduan.textContent = 'SIMPAN PERUBAHAN';
            aduanIdPengaduan.value = btn.getAttribute('data-id');
            aduanJudul.value = btn.getAttribute('data-judul') || '';
            aduanKategori.value = btn.getAttribute('data-kategori') || 'pelayanan';
            aduanIsi.value = btn.getAttribute('data-isi') || '';
            const bukti = btn.getAttribute('data-bukti');
            aduanBuktiHint.textContent = bukti ? 'Kosongkan jika tidak ingin mengganti lampiran.' : 'Maksimal ukuran file 2MB (JPG, PNG, PDF)';
            openModal('modalAduan');
            return;
        }
        
        if (action === 'hapus-aduan') {
            btnKonfirmasiHapusAduan.href = btn.getAttribute('data-href');
            openModal('modalHapusAduan');
            return;
        }
        
        if (action === 'detail-aduan') {
            document.getElementById('detailAduanJudul').textContent = btn.getAttribute('data-judul') || '-';
            document.getElementById('detailAduanStatus').textContent = btn.getAttribute('data-status') || '-';
            document.getElementById('detailAduanKategori').textContent = btn.getAttribute('data-kategori') || '-';
            const tanggalRaw = btn.getAttribute('data-tanggal') || '-';
            const tanggalIso = tanggalRaw && tanggalRaw !== '-' ? tanggalRaw.replace(' ', 'T') : null;
            document.getElementById('detailAduanTanggal').textContent = tanggalIso ? new Date(tanggalIso).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-';
            
            const bukti = btn.getAttribute('data-bukti') || '';
            const buktiEl = document.getElementById('detailAduanBukti');
            if (bukti) {
                buktiEl.textContent = bukti;
                buktiEl.href = '<?= BASEURL; ?>/assets/uploads/' + bukti;
            } else {
                buktiEl.textContent = '-';
                buktiEl.href = '#';
            }
            
            document.getElementById('detailAduanIsi').textContent = btn.getAttribute('data-isi') || '-';
            document.getElementById('detailAduanCatatan').textContent = btn.getAttribute('data-catatan') || '-';
            openModal('modalDetailAduan');
            return;
        }
    });
</script>

<?php $this->view('templates/footer', $data); ?>
