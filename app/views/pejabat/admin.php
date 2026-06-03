<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Data Petugas Desa</h2>
            <p class="text-gray-500">Kelola data petugas dan upload tanda tangan untuk kebutuhan penandatanganan surat.</p>
        </div>
        <?php if($_SESSION['user']['level'] == 'petugas'): ?>
            <button onclick="openPejabatModal('tambah')" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                <i class="fas fa-plus mr-2"></i> TAMBAH PETUGAS
            </button>
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jabatan</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">TTD</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pejabat'])): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Belum ada data pejabat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pejabat'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-mono text-sm text-slate-700"><?= $p['id_petugas']; ?></td>
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $p['nama_petugas']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500"><?= $p['jabatan']; ?></td>
                                <td class="px-8 py-5">
                                    <?php if(!empty($p['ttd'])): ?>
                                        <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider bg-blue-50 text-blue-600 border-blue-100">Ada</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider bg-gray-50 text-gray-500 border-gray-100">Kosong</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <?php if((int)$p['id_petugas'] === (int)$_SESSION['user']['id_user'] || $_SESSION['user']['level'] == 'petugas'): ?>
                                        <button onclick='openTtdModal(<?= json_encode($p); ?>)' class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                            Upload TTD
                                        </button>
                                    <?php endif; ?>
                                    <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                                        <button onclick='openPejabatModal("edit", <?= json_encode($p); ?>)' class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                            Edit
                                        </button>
                                        <a href="<?= BASEURL; ?>/pejabat/hapus/<?= $p['id_petugas']; ?>" onclick="return confirm('Hapus data pejabat ini?')" class="px-4 py-2 bg-rose-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-700 transition shadow-lg shadow-rose-100 flex items-center">
                                            Hapus
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

<div id="pejabatModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 id="pejabatTitle" class="text-2xl font-black text-slate-900">Tambah Petugas</h3>
        </div>

        <form id="pejabatForm" action="<?= BASEURL; ?>/pejabat/tambah" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_petugas" id="id_petugas">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">ID Petugas (samakan dengan id_user)</label>
                <input type="number" name="id_petugas" id="id_petugas_input" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Petugas</label>
                <input type="text" name="nama_petugas" id="nama_petugas" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Contoh: Kepala Desa">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status Aktif</label>
                    <select name="status_aktif" id="status_aktif" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closePejabatModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="ttdModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[520px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Upload Tanda Tangan</h3>
            <p class="text-sm text-gray-400 mt-2">Upload gambar tanda tangan (PNG/JPG) untuk digunakan pada surat.</p>
        </div>

        <form action="<?= BASEURL; ?>/pejabat/upload_ttd" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
            <input type="hidden" name="id_petugas" id="ttd_id_petugas">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">File TTD</label>
                <input type="file" name="ttd" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <p class="text-[10px] text-gray-400 italic">Disarankan PNG dengan background transparan.</p>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeTtdModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Upload</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPejabatModal(mode, data = null) {
        const modal = document.getElementById('pejabatModal');
        const form = document.getElementById('pejabatForm');
        const title = document.getElementById('pejabatTitle');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        if (mode === 'edit' && data) {
            title.innerText = 'Edit Petugas';
            form.action = '<?= BASEURL; ?>/pejabat/edit';
            document.getElementById('id_petugas_input').value = data.id_petugas;
            document.getElementById('id_petugas_input').readOnly = true;
            document.getElementById('nama_petugas').value = data.nama_petugas;
            document.getElementById('jabatan').value = data.jabatan;
            document.getElementById('status_aktif').value = data.status_aktif;
        } else {
            title.innerText = 'Tambah Petugas';
            form.action = '<?= BASEURL; ?>/pejabat/tambah';
            form.reset();
            document.getElementById('id_petugas_input').readOnly = false;
        }
    }

    function closePejabatModal() {
        document.getElementById('pejabatModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openTtdModal(data) {
        document.getElementById('ttd_id_petugas').value = data.id_petugas;
        document.getElementById('ttdModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeTtdModal() {
        document.getElementById('ttdModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
