<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Kelola Informasi Publik</h2>
            <p class="text-gray-500">Terbitkan pengumuman atau berita untuk warga desa.</p>
        </div>
        <?php if($_SESSION['user']['level'] != 'kades'): ?>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
            <i class="fas fa-plus mr-2"></i> BUAT INFORMASI BARU
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul Informasi</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Penulis</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['informasi'])): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">Belum ada informasi yang dibuat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['informasi'] as $i): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 text-sm text-gray-500"><?= date('d/m/Y', strtotime($i['tgl_publikasi'])); ?></td>
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $i['judul']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500"><?= $i['nama_petugas']; ?></td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <a href="<?= BASEURL; ?>/informasi/detail/<?= $i['id_informasi']; ?>" target="_blank" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                        Detail
                                    </a>
                                    <?php if($_SESSION['user']['level'] != 'kades'): ?>
                                    <button onclick='openModal("edit", <?= json_encode($i); ?>)' class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                        Edit
                                    </button>
                                    <a href="<?= BASEURL; ?>/informasi/hapus/<?= $i['id_informasi']; ?>" onclick="return confirm('Hapus informasi ini?')" class="px-4 py-2 bg-rose-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-700 transition shadow-lg shadow-rose-100 flex items-center">
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

<!-- Modal Form -->
<div id="infoModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Buat Informasi Publik</h3>
        </div>
        
        <form id="infoForm" action="<?= BASEURL; ?>/informasi/tambah" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
            <input type="hidden" name="id_informasi" id="id_informasi">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Informasi</label>
                <input type="text" name="judul" id="judul" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Konten / Isi Berita</label>
                <textarea name="konten" id="konten" rows="8" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Gambar Pendukung (Opsional)</label>
                <input type="file" name="gambar" accept="image/*" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <p id="editNote" class="text-[10px] text-amber-600 font-bold hidden">* Biarkan kosong jika tidak ingin mengubah gambar</p>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" id="submitBtn" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Publikasikan Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode = 'tambah', data = null) {
        const modal = document.getElementById('infoModal');
        const form = document.getElementById('infoForm');
        const title = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('submitBtn');
        const editNote = document.getElementById('editNote');

        if (mode === 'edit' && data) {
            title.innerText = 'Edit Informasi Publik';
            form.action = '<?= BASEURL; ?>/informasi/edit';
            submitBtn.innerText = 'Simpan Perubahan';
            submitBtn.className = submitBtn.className.replace('bg-blue-600', 'bg-amber-500').replace('hover:bg-blue-700', 'hover:bg-amber-600').replace('shadow-blue-100', 'shadow-amber-100');
            editNote.classList.remove('hidden');

            document.getElementById('id_informasi').value = data.id_informasi;
            document.getElementById('judul').value = data.judul;
            document.getElementById('konten').value = data.konten;
        } else {
            title.innerText = 'Buat Informasi Publik';
            form.action = '<?= BASEURL; ?>/informasi/tambah';
            submitBtn.innerText = 'Publikasikan Sekarang';
            submitBtn.className = submitBtn.className.replace('bg-amber-500', 'bg-blue-600').replace('hover:bg-amber-600', 'hover:bg-blue-700').replace('shadow-amber-100', 'shadow-blue-100');
            editNote.classList.add('hidden');

            form.reset();
            document.getElementById('id_informasi').value = '';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('infoModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>