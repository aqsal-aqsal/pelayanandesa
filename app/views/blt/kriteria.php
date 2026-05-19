<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Kriteria Bantuan (SAW)</h2>
            <p class="text-gray-500">Atur kriteria, bobot, dan tipe (benefit/cost) untuk perhitungan SAW.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= BASEURL; ?>/blt/admin" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> KEMBALI
            </a>
            <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                <button onclick="openKriteriaModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                    <i class="fas fa-plus mr-2"></i> TAMBAH KRITERIA
                </button>
            <?php endif; ?>
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kriteria</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bobot</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['kriteria'])): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">Belum ada kriteria yang ditambahkan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['kriteria'] as $k): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $k['nama_kriteria']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $k['bobot']; ?>%</td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $k['tipe_kriteria'] == 'benefit' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-amber-50 text-amber-600 border-amber-100'; ?>">
                                        <?= $k['tipe_kriteria']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                                        <a href="<?= BASEURL; ?>/blt/hapus_kriteria/<?= $k['id_kriteria']; ?>" onclick="return confirm('Hapus kriteria ini?')" class="text-rose-500 hover:text-rose-700 font-black text-[10px] uppercase tracking-widest">
                                            Hapus
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

<div id="kriteriaModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[500px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Tambah Kriteria</h3>
        </div>

        <form action="<?= BASEURL; ?>/blt/tambah_kriteria" method="POST" class="space-y-6 text-left">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Kriteria</label>
                <input type="text" name="nama_kriteria" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Bobot (%)</label>
                    <input type="number" name="bobot" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tipe</label>
                    <select name="tipe_kriteria" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeKriteriaModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Kriteria</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openKriteriaModal() {
        document.getElementById('kriteriaModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeKriteriaModal() {
        document.getElementById('kriteriaModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
