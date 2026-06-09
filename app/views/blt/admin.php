<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Manajemen Seleksi BLT (SAW)</h2>
            <p class="text-gray-500">Kelola program bantuan, kriteria, data calon penerima, dan jalankan perhitungan.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?= BASEURL; ?>/blt/kriteria" class="px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl font-bold text-sm hover:bg-blue-100 transition flex items-center">
                <i class="fas fa-sliders-h mr-2"></i> KELOLA KRITERIA
            </a>
            <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                <button onclick="openProgramModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                    <i class="fas fa-plus mr-2"></i> TAMBAH PROGRAM
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-play-circle"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Program Aktif</h3>
            <div class="text-3xl font-bold text-slate-900"><?= $data['program_aktif']; ?></div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Program Selesai</h3>
            <div class="text-3xl font-bold text-slate-900"><?= $data['program_selesai']; ?></div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-12 h-12 bg-gray-50 text-gray-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Direncanakan</h3>
            <div class="text-3xl font-bold text-slate-900"><?= $data['program_direncanakan']; ?></div>
        </div>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Program</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kuota</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['programs'])): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">Belum ada program bantuan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['programs'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-800"><?= $p['nama_program']; ?></div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1"><?= $p['sumber_dana']; ?></div>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $p['periode']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $p['kuota_penerima']; ?> KPM</td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $p['status'] == 'aktif' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-gray-50 text-gray-500 border-gray-100'; ?>">
                                        <?= $p['status']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <a href="<?= BASEURL; ?>/blt/calon/<?= $p['id_program']; ?>" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                        <?= $_SESSION['user']['level'] == 'kades' ? 'Lihat Calon' : 'Kelola Calon'; ?>
                                    </a>
                                    <?php if($_SESSION['user']['level'] == 'kades'): ?>
                                        <a href="<?= BASEURL; ?>/blt/hitung/<?= $p['id_program']; ?>" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center">
                                            Hitung SAW
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= BASEURL; ?>/blt/detail/<?= $p['id_program']; ?>" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                        Lihat Hasil
                                    </a>
                                    <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                                        <button onclick='openEditProgramModal(<?= json_encode($p); ?>)' class="px-4 py-2 bg-amber-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-amber-600 transition shadow-lg shadow-amber-100 flex items-center">
                                            Edit
                                        </button>
                                        <a href="<?= BASEURL; ?>/blt/hapus_program/<?= $p['id_program']; ?>" onclick="return confirm('Hapus program bantuan ini?')" class="px-4 py-2 bg-rose-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-700 transition shadow-lg shadow-rose-100 flex items-center">
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

<div id="programModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900" id="programModalTitle">Tambah Program Bantuan</h3>
            <p class="text-sm text-gray-400 mt-2">Lengkapi data program bantuan sosial.</p>
        </div>
        
        <form id="programForm" action="<?= BASEURL; ?>/blt/tambah_program" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_program" id="program_id_input">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Program</label>
                <input type="text" name="nama_program" id="program_nama_input" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="program_sumber_input" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Periode</label>
                    <input type="text" name="periode" id="program_periode_input" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Contoh: 2026">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Total Anggaran</label>
                    <input type="number" name="total_anggaran" id="program_anggaran_input" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kuota Penerima</label>
                    <input type="number" name="kuota_penerima" id="program_kuota_input" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status</label>
                    <select name="status" id="program_status_input" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="direncanakan">Direncanakan</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeProgramModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Program</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openProgramModal() {
        document.getElementById('programModalTitle').innerText = 'Tambah Program Bantuan';
        document.getElementById('programForm').action = '<?= BASEURL; ?>/blt/tambah_program';
        document.getElementById('program_id_input').value = '';
        document.getElementById('program_nama_input').value = '';
        document.getElementById('program_sumber_input').value = '';
        document.getElementById('program_periode_input').value = '';
        document.getElementById('program_anggaran_input').value = '';
        document.getElementById('program_kuota_input').value = '';
        document.getElementById('program_status_input').value = 'direncanakan';
        
        document.getElementById('programModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function openEditProgramModal(p) {
        document.getElementById('programModalTitle').innerText = 'Edit Program Bantuan';
        document.getElementById('programForm').action = '<?= BASEURL; ?>/blt/edit_program';
        
        document.getElementById('program_id_input').value = p.id_program;
        document.getElementById('program_nama_input').value = p.nama_program;
        document.getElementById('program_sumber_input').value = p.sumber_dana;
        document.getElementById('program_periode_input').value = p.periode;
        document.getElementById('program_anggaran_input').value = p.total_anggaran;
        document.getElementById('program_kuota_input').value = p.kuota_penerima;
        document.getElementById('program_status_input').value = p.status;
        
        document.getElementById('programModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeProgramModal() {
        document.getElementById('programModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
