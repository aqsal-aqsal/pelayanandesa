<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Hasil Seleksi SAW & Penyaluran Bantuan</h2>
        <p class="text-gray-600">Daftar peringkat calon penerima bantuan dan bukti penyerahan.</p>
    </div>
    <a href="<?= BASEURL; ?>/blt/admin" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ranking</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bukti Penyerahan</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['hasil'])): ?>
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-gray-500 italic">Hasil perhitungan belum tersedia.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['hasil'] as $h): ?>
                        <tr class="<?= $h['ranking'] <= 5 ? 'bg-blue-50/30' : ''; ?>">
                            <td class="px-8 py-5">
                                <span class="flex items-center justify-center w-10 h-10 rounded-xl <?= $h['ranking'] <= 3 ? 'bg-yellow-400 text-white font-bold' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?= $h['ranking']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm text-gray-500 font-mono"><?= $h['nik']; ?></td>
                            <td class="px-8 py-5 font-bold text-slate-800"><?= $h['nama_lengkap']; ?></td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider 
                                    <?= $h['status_penyaluran'] == 'disalurkan' ? 'bg-green-50 text-green-600 border-green-100' : 
                                       ($h['status_penyaluran'] == 'diterima' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                                       'bg-gray-50 text-gray-500 border-gray-100'); ?>">
                                    <?= $h['status_penyaluran'] ?? 'belum'; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <?php if($h['bukti_penyerahan']): ?>
                                    <a href="<?= BASEURL; ?>/assets/uploads/<?= $h['bukti_penyerahan']; ?>" target="_blank" 
                                       class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <i class="fas fa-file-image"></i> Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400 italic">Belum ada bukti</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                                    <button onclick='openBuktiModal(<?= json_encode($h); ?>)' 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-1">
                                        <i class="fas fa-upload"></i> Upload Bukti
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="bg-blue-50 p-8 rounded-[32px] border border-blue-100">
    <h4 class="font-black text-blue-800 mb-3 text-lg"><i class="fas fa-info-circle mr-2"></i> Mengenai Perhitungan SAW</h4>
    <p class="text-sm text-blue-700 leading-relaxed">
        Metode <strong>Simple Additive Weighting (SAW)</strong> memberikan skor akhir berdasarkan bobot setiap kriteria (Penghasilan, Tanggungan, Kondisi Rumah, dll). Skor tertinggi menunjukkan prioritas utama sebagai penerima bantuan secara objektif dan transparan.
    </p>
</div>

<!-- Modal Upload Bukti Penyerahan -->
<div id="buktiModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Upload Bukti Penyerahan</h3>
            <p class="text-sm text-gray-400 mt-2" id="buktiModalSubtitle"></p>
        </div>
        
        <form id="buktiForm" action="<?= BASEURL; ?>/blt/upload_bukti" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
            <input type="hidden" name="id_program" id="bukti_id_program" value="<?= $data['id_program']; ?>">
            <input type="hidden" name="id_calon" id="bukti_id_calon">
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">File Bukti (Foto/Dokumen)</label>
                <input type="file" name="bukti" accept="image/*,.pdf" required 
                       class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status Penyaluran</label>
                <select name="status_penyaluran" id="bukti_status" 
                        class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="disalurkan">Disalurkan</option>
                    <option value="diterima">Diterima</option>
                </select>
            </div>
            
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeBuktiModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Upload Bukti</button>
            </div>
        </form>
    </div>
</div>

<script>
function openBuktiModal(h) {
    document.getElementById('buktiModalSubtitle').innerText = 'Untuk: ' + h.nama_lengkap + ' (' + h.nik + ')';
    document.getElementById('bukti_id_calon').value = h.id_calon;
    document.getElementById('buktiModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeBuktiModal() {
    document.getElementById('buktiModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('buktiForm').reset();
}
</script>

<?php $this->view('templates/footer', $data); ?>
