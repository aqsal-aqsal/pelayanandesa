<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Antrean Layanan Surat</h2>
            <p class="text-gray-500">Daftar pengajuan surat yang diurutkan berdasarkan <span class="text-blue-600 font-bold">Priority Scheduling</span>.</p>
        </div>
        <?php if($_SESSION['user']['level'] == 'petugas'): ?>
            <a href="<?= BASEURL; ?>/layanan/jenis" class="px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl font-bold text-sm hover:bg-blue-100 transition flex items-center">
                <i class="fas fa-cog mr-2"></i> KELOLA JENIS SURAT
            </a>
        <?php endif; ?>
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
                                Data Warga
                                <?php if ($data['sort_by'] == 'nama_lengkap'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'ASC' ? '↑' : '↓' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'nama_surat' && $data['sort_order'] == 'ASC') ? 'DESC' : 'ASC';
                            ?>
                            <a href="?sort_by=nama_surat&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Jenis Surat
                                <?php if ($data['sort_by'] == 'nama_surat'): ?>
                                    <span class="text-sm"><?= $data['sort_order'] == 'ASC' ? '↑' : '↓' ?></span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <?php
                                $new_order = ($data['sort_by'] == 'tanggal_pengajuan' && $data['sort_order'] == 'DESC') ? 'ASC' : 'DESC';
                            ?>
                            <a href="?sort_by=tanggal_pengajuan&sort_order=<?= $new_order ?>" class="flex items-center gap-1 hover:text-gray-700 transition">
                                Tanggal Masuk
                                <?php if ($data['sort_by'] == 'tanggal_pengajuan'): ?>
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
                    <?php if(empty($data['pengajuan'])): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-gray-500 italic">Belum ada antrean pengajuan surat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengajuan'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-xs <?= $p['prioritas'] >= 6 ? 'bg-rose-50 text-rose-600' : ($p['prioritas'] >= 3 ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600'); ?>">
                                            <?= $p['prioritas']; ?>
                                        </div>
                                        <?php if($p['prioritas'] >= 6): ?>
                                            <span class="animate-pulse flex h-2 w-2 rounded-full bg-rose-500"></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-700"><?= $p['nama_lengkap']; ?></div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">NIK: <?= $p['nik']; ?></div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-medium text-slate-600"><?= $p['nama_surat']; ?></div>
                                    <div class="text-[10px] text-gray-400 italic mt-1"><?= substr($p['keperluan'], 0, 30); ?>...</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-slate-500"><?= date('d M Y', strtotime($p['tanggal_pengajuan'])); ?></div>
                                    <div class="text-[10px] text-gray-400 mt-0.5"><?= date('H:i', strtotime($p['tanggal_pengajuan'])); ?> WIB</div>
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
                                    <span class="text-[10px] font-bold text-slate-600 elapsed-time" data-start-time="<?= htmlspecialchars($p['tanggal_pengajuan']); ?>" data-status="<?= htmlspecialchars($p['status']); ?>" data-end-time="<?= htmlspecialchars($p['tanggal_selesai'] ?? ''); ?>">
                                        --
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <!-- Detail Button (for everyone) -->
                                    <button
                                        type="button"
                                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center"
                                        data-action="detail-surat"
                                        data-id="<?= (int)$p['id_pengajuan']; ?>"
                                        data-nik="<?= htmlspecialchars($p['nik'], ENT_QUOTES); ?>"
                                        data-nama="<?= htmlspecialchars($p['nama_lengkap'], ENT_QUOTES); ?>"
                                        data-jenis="<?= htmlspecialchars($p['nama_surat'], ENT_QUOTES); ?>"
                                        data-keperluan="<?= htmlspecialchars($p['keperluan'] ?? '', ENT_QUOTES); ?>"
                                        data-status="<?= htmlspecialchars($p['status'], ENT_QUOTES); ?>"
                                        data-tanggal="<?= htmlspecialchars($p['tanggal_pengajuan'] ?? '-', ENT_QUOTES); ?>"
                                        data-nosurat="<?= htmlspecialchars($p['no_surat'] ?? '-', ENT_QUOTES); ?>"
                                        data-catatan="<?= htmlspecialchars($p['catatan_penolakan'] ?? '-', ENT_QUOTES); ?>"
                                        data-berkas="<?= htmlspecialchars($p['file_berkas'] ?? '', ENT_QUOTES); ?>"
                                        data-prioritas="<?= (int)$p['prioritas']; ?>">
                                        Detail
                                    </button>
                                    
                                    <!-- Other Action Buttons -->
                                    <?php if($_SESSION['user']['level'] == 'kades' && $p['status'] == 'diproses'): ?>
                                        <button onclick="openModalStatus(<?= $p['id_pengajuan']; ?>, 'selesai')" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center">
                                            Tanda Tangani
                                        </button>
                                    <?php elseif($_SESSION['user']['level'] == 'petugas' && $p['status'] == 'menunggu'): ?>
                                        <button onclick="openModalStatus(<?= $p['id_pengajuan']; ?>)" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                            Verifikasi
                                        </button>
                                    <?php elseif($p['status'] == 'selesai'): ?>
                                        <a href="<?= BASEURL; ?>/layanan/unduh/<?= $p['id_pengajuan']; ?>" target="_blank" class="px-4 py-2 bg-green-50 text-green-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-green-100 transition flex items-center">
                                            Unduh
                                        </a>
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
<!-- Modal Detail Surat -->
<div id="modalDetailSurat" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalDetailSurat"></div>
    <div class="relative min-h-full flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="bg-slate-900 px-10 py-8 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-white">Detail Pengajuan Surat</h3>
                    <p class="text-slate-200 text-sm mt-1">Berikut data pengajuan surat lengkap.</p>
                </div>
                <button type="button" class="text-white/80 hover:text-white" data-modal-close="modalDetailSurat"><i class="fas fa-times"></i></button>
            </div>

            <div class="p-10 space-y-6 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK Warga</div>
                        <div id="detailSuratNik" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</div>
                        <div id="detailSuratNama" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</div>
                        <div id="detailSuratJenis" class="font-bold text-slate-800"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prioritas</div>
                        <div id="detailSuratPrioritas" class="font-bold text-slate-800"></div>
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
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Berkas Pendukung</div>
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
<!-- Modal Update Status -->
<div id="statusModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[500px] shadow-2xl rounded-[32px] bg-white">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Update Status</h3>
            <p class="text-sm text-gray-400 mt-2">Ubah status pengajuan surat ini.</p>
        </div>
        
        <form action="<?= BASEURL; ?>/layanan/update_status" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_pengajuan" id="modal_id">
            <input type="hidden" id="modal_file" value="">
            
            <!-- Tampilkan Berkas Bukti -->
            <div id="file_view" class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Berkas Bukti</label>
                <div id="berkas_bukti" class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-xl text-sm text-blue-700"></div>
            </div>
            
            <div class="space-y-2" id="status_select_wrapper">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Status</label>
                <select name="status" id="modal_status" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <!-- Petugas Only -->
                    <option value="diproses">Verifikasi & Lanjutkan ke Kades</option>
                    <option value="ditolak">Tolak Pengajuan</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Catatan / Alasan (Jika Ditolak)</label>
                <textarea name="catatan" rows="3" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Update Sekarang</button>
            </div>
        </form>
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

    // Ubah openModal untuk menerima data pengajuan
    const pengajuanData = <?php echo json_encode($data['pengajuan']); ?>;
    const modalDetailSurat = document.getElementById('modalDetailSurat');
    
    const openModal = (id) => document.getElementById(id).classList.remove('hidden');
    const closeModal = (id) => document.getElementById(id).classList.add('hidden');
    
    // Handle modal close buttons
    document.querySelectorAll('[data-modal-close]').forEach(el => {
        el.addEventListener('click', () => {
            const modalId = el.getAttribute('data-modal-close');
            if(modalId) closeModal(modalId);
        });
    });
    
    function openModalStatus(id, status = 'diproses') {
        const data = pengajuanData.find(p => p.id_pengajuan == id);
        document.getElementById('modal_id').value = id;
        document.getElementById('modal_status').value = status;
        
        // Tampilkan berkas bukti
        const berkasDiv = document.getElementById('berkas_bukti');
        if (data.file_berkas) {
            berkasDiv.innerHTML = `
                <i class="fas fa-file-alt"></i>
                <span>${data.file_berkas}</span>
                <a href="<?= BASEURL; ?>/assets/uploads/${data.file_berkas}" target="_blank" class="ml-auto text-blue-600 font-bold text-xs uppercase">Lihat</a>
            `;
        } else {
            berkasDiv.innerHTML = '<span class="text-gray-400 italic">Tidak ada berkas</span>';
        }

        // Sesuaikan status untuk Kades
        const statusSelectWrapper = document.getElementById('status_select_wrapper');
        const statusSelect = document.getElementById('modal_status');
        if('<?= $_SESSION['user']['level'] ?>' === 'kades') {
            statusSelect.innerHTML = `
                <option value="selesai">Tanda Tangani & Selesai</option>
            `;
        } else {
            statusSelect.innerHTML = `
                <option value="diproses">Verifikasi & Lanjutkan ke Kades</option>
                <option value="ditolak">Tolak Pengajuan</option>
            `;
        }
        
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Rename the old openModal function for backward compatibility
    window.openModal = openModalStatus;
    
    // Handle detail surat button click
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action="detail-surat"]');
        if (!btn) return;
        
        document.getElementById('detailSuratNik').textContent = btn.getAttribute('data-nik') || '-';
        document.getElementById('detailSuratNama').textContent = btn.getAttribute('data-nama') || '-';
        document.getElementById('detailSuratJenis').textContent = btn.getAttribute('data-jenis') || '-';
        document.getElementById('detailSuratPrioritas').textContent = btn.getAttribute('data-prioritas') ? btn.getAttribute('data-prioritas') : '-';
        document.getElementById('detailSuratStatus').textContent = btn.getAttribute('data-status') || '-';
        const tanggalRaw = btn.getAttribute('data-tanggal') || '-';
        const tanggalIso = tanggalRaw && tanggalRaw !== '-' ? tanggalRaw.replace(' ', 'T') : null;
        document.getElementById('detailSuratTanggal').textContent = tanggalIso ? new Date(tanggalIso).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
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
        document.body.style.overflow = 'hidden';
    });
    
    function closeModalStatus() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Rename old closeModal for backward compatibility
    window.closeModal = closeModalStatus;
</script>

<?php $this->view('templates/footer', $data); ?>
