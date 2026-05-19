<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 italic">Data Kependudukan</h2>
        <p class="text-gray-500">Kelola informasi seluruh warga Desa Astambul Kota.</p>
    </div>
    <button onclick="openModal('tambah')" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all transform active:scale-95 flex items-center">
        <i class="fas fa-user-plus mr-2"></i> TAMBAH WARGA
    </button>
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
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Warga</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pekerjaan</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Alamat</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['warga'])): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Data warga masih kosong.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data['warga'] as $w): ?>
                        <tr class="hover:bg-gray-50/30 transition group">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        <?= substr($w['nama_lengkap'], 0, 1); ?>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700"><?= $w['nama_lengkap']; ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-gray-500 font-mono"><?= $w['nik']; ?></td>
                            <td class="px-8 py-5 text-sm text-gray-500"><?= $w['pekerjaan'] ?? '-'; ?></td>
                            <td class="px-8 py-5 text-sm text-gray-500"><?= $w['alamat']; ?></td>
                            <td class="px-8 py-5 text-right space-x-2">
                                <button onclick='openModal("edit", <?= json_encode($w); ?>)' class="p-2 text-gray-400 hover:text-blue-600 transition"><i class="fas fa-edit text-xs"></i></button>
                                <a href="<?= BASEURL; ?>/warga/hapus/<?= $w['id_warga']; ?>" onclick="return confirm('Hapus data warga ini?')" class="p-2 text-gray-400 hover:text-rose-600 transition"><i class="fas fa-trash text-xs"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="wargaModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-10 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Tambah Warga Baru</h3>
            <p class="text-sm text-gray-400 mt-2">Pastikan data yang dimasukkan sesuai dengan KTP/KK.</p>
        </div>
        
        <form id="wargaForm" action="<?= BASEURL; ?>/warga/tambah" method="POST" class="space-y-6">
            <input type="hidden" name="id_warga" id="id_warga">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK (16 Digit)</label>
                    <input type="text" name="nik" id="nik" required class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" required class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="2" required class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Fields for SAW BLT Logic -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Penghasilan (Rp)</label>
                    <input type="number" name="penghasilan" id="penghasilan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Tanggungan</label>
                    <input type="number" name="jumlah_tanggungan" id="jumlah_tanggungan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('wargaModal');
        const form = document.getElementById('wargaForm');
        const title = document.getElementById('modalTitle');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        if (mode === 'edit' && data) {
            title.innerText = 'Edit Data Warga';
            form.action = '<?= BASEURL; ?>/warga/edit';
            // Fill form fields
            document.getElementById('id_warga').value = data.id_warga;
            document.getElementById('nik').value = data.nik;
            document.getElementById('nama_lengkap').value = data.nama_lengkap;
            document.getElementById('tempat_lahir').value = data.tempat_lahir;
            document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('pekerjaan').value = data.pekerjaan;
            document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
            document.getElementById('penghasilan').value = data.penghasilan;
            document.getElementById('jumlah_tanggungan').value = data.jumlah_tanggungan;
        } else {
            title.innerText = 'Tambah Warga Baru';
            form.action = '<?= BASEURL; ?>/warga/tambah';
            form.reset();
        }
    }

    function closeModal() {
        document.getElementById('wargaModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
