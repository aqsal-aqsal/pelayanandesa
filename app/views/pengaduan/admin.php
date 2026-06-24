<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Manajemen Pengaduan</h2>
            <p class="text-gray-500">Pantau dan berikan respon terhadap aspirasi warga.</p>
        </div>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" placeholder="Cari aduan..." class="pl-8 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'prioritas' && $data['sort_order'] == 'DESC') ? 'ASC' : 'DESC';
                            ?>
                            <a href="?sort_by=prioritas&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Prioritas
                                <?php if ($data['sort_by'] == 'prioritas'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'DESC' ? '↓' : '↑' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'nama_lengkap' && $data['sort_order'] == 'ASC') ? 'DESC' : 'ASC';
                            ?>
                            <a href="?sort_by=nama_lengkap&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Warga
                                <?php if ($data['sort_by'] == 'nama_lengkap'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'ASC' ? '↑' : '↓' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Laporan
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'tanggal_aduan' && $data['sort_order'] == 'DESC') ? 'ASC' : 'DESC';
                            ?>
                            <a href="?sort_by=tanggal_aduan&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Tanggal Aduan
                                <?php if ($data['sort_by'] == 'tanggal_aduan'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'DESC' ? '↓' : '↑' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'status' && $data['sort_order'] == 'ASC') ? 'DESC' : 'ASC';
                            ?>
                            <a href="?sort_by=status&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Status
                                <?php if ($data['sort_by'] == 'status'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'ASC' ? '↑' : '↓' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pengaduan'])): ?>
                        <tr>
                            <td colspan="8" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengaduan masyarakat yang masuk.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengaduan'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-xs <?= $p['prioritas'] >= 3 ? 'bg-rose-50 text-rose-600' : ($p['prioritas'] >= 2 ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600'); ?>">
                                            <?= $p['prioritas']; ?>
                                        </div>
                                        <?php if($p['prioritas'] >= 3): ?>
                                            <span class="animate-pulse flex h-2 w-2 rounded-full bg-rose-500"></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs">
                                            <?= substr($p['nama_lengkap'], 0, 1); ?>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700"><?= $p['nama_lengkap']; ?></span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800 line-clamp-1"><?= $p['judul_aduan']; ?></p>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        <?= $p['kategori_aduan']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-slate-500"><?= date('d M Y', strtotime($p['tanggal_aduan'])); ?></div>
                                </td>
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
                                        <?= $p['status']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-bold text-slate-600 elapsed-time" data-start-time="<?= htmlspecialchars($p['tanggal_aduan']); ?>" data-status="<?= htmlspecialchars($p['status']); ?>" data-end-time="<?= htmlspecialchars($p['tanggal_selesai'] ?? ''); ?>">
                                        --
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <button type="button" 
                                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center"
                                        data-action="detail-pengaduan"
                                        data-id="<?= (int)$p['id_pengaduan']; ?>"
                                        data-nama="<?= htmlspecialchars($p['nama_lengkap'], ENT_QUOTES); ?>"
                                        data-judul="<?= htmlspecialchars($p['judul_aduan'], ENT_QUOTES); ?>"
                                        data-isi="<?= htmlspecialchars($p['isi_aduan'] ?? '', ENT_QUOTES); ?>"
                                        data-kategori="<?= htmlspecialchars($p['kategori_aduan'], ENT_QUOTES); ?>"
                                        data-status="<?= htmlspecialchars($p['status'], ENT_QUOTES); ?>"
                                        data-tanggal="<?= htmlspecialchars($p['tanggal_aduan'] ?? '-', ENT_QUOTES); ?>"
                                        data-catatan="<?= htmlspecialchars($p['catatan_penolakan'] ?? '-', ENT_QUOTES); ?>"
                                        data-file="<?= htmlspecialchars($p['file_bukti'] ?? '', ENT_QUOTES); ?>"
                                        data-prioritas="<?= (int)$p['prioritas']; ?>">
                                        Detail
                                    </button>

                                    <?php if($p['status'] == 'menunggu' || $p['status'] == 'diproses'): ?>
                                        <button onclick="openModal(<?= $p['id_pengaduan']; ?>)" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center">
                                            Respon Aduan
                                        </button>
                                    <?php else: ?>
                                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail Pengaduan -->
    <div id="modalDetailPengaduan" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalDetailPengaduan"></div>
        <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
            <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
                <div class="bg-slate-900 px-10 py-8 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-white">Detail Pengaduan</h3>
                        <p class="text-slate-200 text-sm mt-1">Berikut detail pengaduan warga.</p>
                    </div>
                    <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalDetailPengaduan"><i class="fas fa-times"></i></button>
                </div>

                <div class="p-10 space-y-6 overflow-y-auto flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Warga</div>
                            <div id="detailPengaduanNama" class="font-bold text-slate-800"></div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</div>
                            <div id="detailPengaduanKategori" class="font-bold text-slate-800"></div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prioritas</div>
                            <div id="detailPengaduanPrioritas" class="font-bold text-slate-800"></div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</div>
                            <div id="detailPengaduanStatus" class="font-bold text-slate-800"></div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal Aduan</div>
                            <div id="detailPengaduanTanggal" class="font-bold text-slate-800"></div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bukti Pendukung</div>
                            <a id="detailPengaduanFile" class="font-bold text-blue-600 hover:text-blue-800 break-all" href="#" target="_blank"></a>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul Aduan</div>
                        <div id="detailPengaduanJudul" class="font-bold text-slate-800"></div>
                    </div>

                    <div class="space-y-2">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Isi Aduan</div>
                        <div id="detailPengaduanIsi" class="text-slate-700 whitespace-pre-line"></div>
                    </div>

                    <div class="space-y-2">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Catatan Respon</div>
                        <div id="detailPengaduanCatatan" class="text-slate-700 whitespace-pre-line"></div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="button" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition" data-modal-close="modalDetailPengaduan">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Respon -->
<div id="statusModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[500px] shadow-2xl rounded-[32px] bg-white">
        <div class="text-center">
            <h3 class="text-2xl font-black text-slate-900">Respon Pengaduan</h3>
            <p class="text-sm text-gray-400 mt-2">Update status dan berikan tanggapan untuk warga.</p>
            
            <form action="<?= BASEURL; ?>/pengaduan/update_status" method="POST" class="mt-8 text-left space-y-6">
                <input type="hidden" name="id_pengaduan" id="modal_id">
                
                <!-- Tampilkan Bukti -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Bukti Pendukung</label>
                    <div id="berkas_bukti" class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-xl text-sm text-blue-700"></div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Ubah Status</label>
                    <select name="status" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="diproses">Proses Laporan</option>
                        <option value="selesai">Selesaikan</option>
                        <option value="ditolak">Tolak Laporan</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggapan / Catatan</label>
                    <textarea name="catatan" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" rows="4" placeholder="Tuliskan respon atau alasan di sini..."></textarea>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Perubahan</button>
                </div>
            </form>
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

    const pengaduanData = <?php echo json_encode($data['pengaduan']); ?>;
    
    const openModalGeneric = (id) => document.getElementById(id).classList.remove('hidden');
    const closeModalGeneric = (id) => document.getElementById(id).classList.add('hidden');
    
    // Handle modal close buttons
    document.querySelectorAll('[data-modal-close]').forEach(el => {
        el.addEventListener('click', () => {
            const modalId = el.getAttribute('data-modal-close');
            if(modalId) closeModalGeneric(modalId);
        });
    });
    
    function openModal(id) {
        const data = pengaduanData.find(p => p.id_pengaduan == id);
        
        document.getElementById('modal_id').value = id;
        
        // Tampilkan bukti
        const berkasDiv = document.getElementById('berkas_bukti');
        if (data.file_bukti) {
            berkasDiv.innerHTML = `
                <i class="fas fa-image"></i>
                <span>${data.file_bukti}</span>
                <a href="<?= BASEURL; ?>/assets/uploads/${data.file_bukti}" target="_blank" class="ml-auto text-blue-600 font-bold text-xs uppercase">Lihat</a>
            `;
        } else {
            berkasDiv.innerHTML = '<span class="text-gray-400 italic">Tidak ada bukti</span>';
        }
        
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Handle detail pengaduan button click
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action="detail-pengaduan"]');
        if (!btn) return;
        
        document.getElementById('detailPengaduanNama').textContent = btn.getAttribute('data-nama') || '-';
        document.getElementById('detailPengaduanKategori').textContent = btn.getAttribute('data-kategori') || '-';
        document.getElementById('detailPengaduanPrioritas').textContent = btn.getAttribute('data-prioritas') ? btn.getAttribute('data-prioritas') : '-';
        document.getElementById('detailPengaduanStatus').textContent = btn.getAttribute('data-status') || '-';
        
        const tanggalRaw = btn.getAttribute('data-tanggal') || '-';
        const tanggalIso = tanggalRaw && tanggalRaw !== '-' ? tanggalRaw.replace(' ', 'T') : null;
        document.getElementById('detailPengaduanTanggal').textContent = tanggalIso ? new Date(tanggalIso).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
        
        const file = btn.getAttribute('data-file') || '';
        const fileEl = document.getElementById('detailPengaduanFile');
        if (file) {
            fileEl.textContent = file;
            fileEl.href = '<?= BASEURL; ?>/assets/uploads/' + file;
            fileEl.classList.remove('hidden');
        } else {
            fileEl.textContent = '-';
            fileEl.href = '#';
        }
        
        document.getElementById('detailPengaduanJudul').textContent = btn.getAttribute('data-judul') || '-';
        document.getElementById('detailPengaduanIsi').textContent = btn.getAttribute('data-isi') || '-';
        document.getElementById('detailPengaduanCatatan').textContent = btn.getAttribute('data-catatan') || '-';
        
        openModalGeneric('modalDetailPengaduan');
        document.body.style.overflow = 'hidden';
    });
</script>

<?php $this->view('templates/footer', $data); ?>
