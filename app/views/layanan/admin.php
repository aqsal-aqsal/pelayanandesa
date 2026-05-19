<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Layanan Surat</h2>
        <p class="text-gray-600">Daftar semua pengajuan surat masuk dari warga.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Prioritas</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Warga</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Surat</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['pengajuan'])): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan surat.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['pengajuan'] as $p): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold rounded-full <?= $p['prioritas'] >= 5 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'; ?>">
                                    P-<?= $p['prioritas']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-900"><?= $p['nama_lengkap']; ?></p>
                                <p class="text-xs text-gray-500"><?= $p['nik']; ?></p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?= $p['nama_surat']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= date('d/m/Y', strtotime($p['tanggal_pengajuan'])); ?></td>
                            <td class="px-6 py-4">
                                <?php 
                                    $statusColor = [
                                        'menunggu' => 'bg-blue-100 text-blue-700',
                                        'diproses' => 'bg-yellow-100 text-yellow-700',
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700'
                                    ];
                                ?>
                                <span class="px-2 py-1 text-xs font-bold rounded-full <?= $statusColor[$p['status']] ?? 'bg-gray-100'; ?>">
                                    <?= ucfirst($p['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openModal(<?= $p['id_pengajuan']; ?>)" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Update Status</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Update Status -->
<div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Update Status Pengajuan</h3>
            <form action="<?= BASEURL; ?>/layanan/update_status" method="POST" class="mt-4 text-left">
                <input type="hidden" name="id_pengajuan" id="modal_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                    <select name="status" class="w-full border rounded-lg p-2.5 text-sm">
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                    <textarea name="catatan" class="w-full border rounded-lg p-2.5 text-sm" rows="3"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById('modal_id').value = id;
        document.getElementById('statusModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }
</script>

<?php $this->view('templates/footer', $data); ?>
