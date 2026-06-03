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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prioritas</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Data Warga</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal Masuk</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
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
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <?php if($_SESSION['user']['level'] == 'kades' && $p['status'] == 'diproses'): ?>
                                        <button onclick="openModal(<?= $p['id_pengajuan']; ?>, 'selesai')" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center">
                                            Tanda Tangani
                                        </button>
                                    <?php elseif($_SESSION['user']['level'] == 'petugas' && $p['status'] == 'menunggu'): ?>
                                        <button onclick="openModal(<?= $p['id_pengajuan']; ?>)" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                            Verifikasi
                                        </button>
                                    <?php elseif($p['status'] == 'selesai'): ?>
                                        <a href="<?= BASEURL; ?>/layanan/unduh/<?= $p['id_pengajuan']; ?>" target="_blank" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                            Unduh
                                        </a>
                                    <?php else: ?>
                                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No Action</span>
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

<!-- Modal Update Status -->
<div id="statusModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[400px] shadow-2xl rounded-[32px] bg-white">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Update Status</h3>
            <p class="text-sm text-gray-400 mt-2">Ubah status pengajuan surat ini.</p>
        </div>
        
        <form action="<?= BASEURL; ?>/layanan/update_status" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_pengajuan" id="modal_id">
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Status</label>
                <select name="status" id="modal_status" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="diproses">Setujui & Proses (Petugas)</option>
                    <option value="selesai">Selesai & Tanda Tangani (Kades)</option>
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
    function openModal(id, status = 'diproses') {
        document.getElementById('modal_id').value = id;
        document.getElementById('modal_status').value = status;
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
