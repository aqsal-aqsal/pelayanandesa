<?php $this->view('templates/header', $data); ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Daftar Pengaduan Masuk</h3>
            <p class="text-sm text-gray-400 mt-1">Pantau dan berikan respon terhadap aspirasi warga.</p>
        </div>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" placeholder="Cari aduan..." class="pl-8 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Warga</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Laporan</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['pengaduan'])): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengaduan masyarakat yang masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['pengaduan'] as $p): ?>
                        <tr class="hover:bg-gray-50/30 transition group">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        <?= substr($p['nama_lengkap'], 0, 1); ?>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700"><?= $p['nama_lengkap']; ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-bold text-slate-800 line-clamp-1"><?= $p['judul_aduan']; ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?= date('d M Y', strtotime($p['tanggal_aduan'])); ?></p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                    <?= $p['kategori_aduan']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <?php 
                                    $statusStyles = [
                                        'menunggu' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'selesai' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100'
                                    ];
                                    $style = $statusStyles[$p['status']] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                ?>
                                <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $style; ?>">
                                    <?= $p['status']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button onclick="openModal(<?= $p['id_pengaduan']; ?>)" class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase tracking-widest group-hover:underline">Respon Aduan</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Respon -->
<div id="statusModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[450px] shadow-2xl rounded-[32px] bg-white">
        <div class="text-center">
            <h3 class="text-2xl font-black text-slate-900">Respon Pengaduan</h3>
            <p class="text-sm text-gray-400 mt-2">Update status dan berikan tanggapan untuk warga.</p>
            
            <form action="<?= BASEURL; ?>/pengaduan/update_status" method="POST" class="mt-8 text-left space-y-6">
                <input type="hidden" name="id_pengaduan" id="modal_id">
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
    function openModal(id) {
        document.getElementById('modal_id').value = id;
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
