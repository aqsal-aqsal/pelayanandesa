<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 italic">Manajemen Jenis Surat</h2>
        <p class="text-gray-500">Atur kategori surat yang tersedia untuk diajukan oleh warga.</p>
    </div>
    <div class="flex space-x-3">
        <?php if(empty($data['jenis'])): ?>
            <a href="<?= BASEURL; ?>/layanan/seed_jenis" class="bg-amber-50 text-amber-600 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-amber-100 transition flex items-center border border-amber-100">
                <i class="fas fa-magic mr-2"></i> SEED DEFAULT
            </a>
        <?php endif; ?>
        <button onclick="openModal('tambah')" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all flex items-center">
            <i class="fas fa-plus mr-2"></i> TAMBAH JENIS SURAT
        </button>
    </div>
</div>

<?php if(isset($_SESSION['flash'])): ?>
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl mb-6 text-sm flex justify-between items-center">
        <span><?= $_SESSION['flash']['message']; ?></span>
        <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700"><i class="fas fa-times"></i></button>
        <?php unset($_SESSION['flash']); ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Surat</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prioritas Dasar</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['jenis'])): ?>
                    <tr>
                        <td colspan="3" class="px-8 py-12 text-center text-gray-500 italic">Belum ada jenis surat yang ditambahkan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['jenis'] as $j): ?>
                        <tr class="hover:bg-gray-50/30 transition group">
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-700"><?= $j['nama_surat']; ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100">
                                    LEVEL <?= $j['prioritas']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right space-x-2">
                                <button onclick='openModal("edit", <?= json_encode($j); ?>)' class="p-2 text-gray-400 hover:text-blue-600 transition"><i class="fas fa-edit text-xs"></i></button>
                                <a href="<?= BASEURL; ?>/layanan/hapus_jenis/<?= $j['id_jenis_surat']; ?>" onclick="return confirm('Hapus jenis surat ini?')" class="p-2 text-gray-400 hover:text-rose-600 transition"><i class="fas fa-trash text-xs"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="jenisModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[450px] shadow-2xl rounded-[32px] bg-white">
        <div class="text-center mb-8">
            <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Tambah Jenis Surat</h3>
        </div>
        
        <form id="jenisForm" action="<?= BASEURL; ?>/layanan/tambah_jenis" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_jenis_surat" id="id_jenis_surat">
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Jenis Surat</label>
                <input type="text" name="nama_surat" id="nama_surat" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Contoh: Surat Keterangan Domisili">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Prioritas Dasar (1-5)</label>
                <input type="number" name="prioritas" id="prioritas" min="1" max="5" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="1">
                <p class="text-[10px] text-gray-400 italic">Semakin tinggi angka, semakin diprioritaskan dalam antrean.</p>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('jenisModal');
        const form = document.getElementById('jenisForm');
        const title = document.getElementById('modalTitle');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        if (mode === 'edit' && data) {
            title.innerText = 'Edit Jenis Surat';
            form.action = '<?= BASEURL; ?>/layanan/edit_jenis';
            document.getElementById('id_jenis_surat').value = data.id_jenis_surat;
            document.getElementById('nama_surat').value = data.nama_surat;
            document.getElementById('prioritas').value = data.prioritas;
        } else {
            title.innerText = 'Tambah Jenis Surat';
            form.action = '<?= BASEURL; ?>/layanan/tambah_jenis';
            form.reset();
        }
    }

    function closeModal() {
        document.getElementById('jenisModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
