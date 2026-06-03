<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Data Calon Penerima</h2>
            <p class="text-gray-500">Tambahkan calon penerima berdasarkan NIK, lalu input nilai kriteria untuk perhitungan SAW.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= BASEURL; ?>/blt/admin" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> KEMBALI
            </a>
            <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                <button onclick="openCalonModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                    <i class="fas fa-user-plus mr-2"></i> TAMBAH CALON
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
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['calon'])): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">Belum ada calon penerima untuk program ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['calon'] as $c): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-mono text-sm text-slate-700"><?= $c['nik']; ?></td>
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $c['nama_lengkap']; ?></td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider bg-gray-50 text-gray-600 border-gray-100">
                                        <?= $c['status']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <?php if($_SESSION['user']['level'] == 'petugas'): ?>
                                        <button onclick='openNilaiModal(<?= $c['id_calon']; ?>, <?= json_encode($c); ?>)' class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                            Input Nilai
                                        </button>
                                        <?php if($c['status'] == 'diusulkan'): ?>
                                            <a href="<?= BASEURL; ?>/blt/ajukan_kades/<?= $data['id_program']; ?>/<?= $c['id_calon']; ?>" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center">
                                                Ajukan Kades
                                            </a>
                                        <?php endif; ?>
                                    <?php elseif($_SESSION['user']['level'] == 'kades'): ?>
                                        <button onclick='openNilaiModal(<?= $c['id_calon']; ?>, <?= json_encode($c); ?>, true)' class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                            Lihat Nilai
                                        </button>
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

<div id="calonModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[520px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Tambah Calon Penerima</h3>
            <p class="text-sm text-gray-400 mt-2">Masukkan NIK warga yang akan diusulkan.</p>
        </div>

        <form action="<?= BASEURL; ?>/blt/tambah_calon" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_program" value="<?= $data['id_program']; ?>">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK Warga</label>
                <input type="text" name="nik" required maxlength="16" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeCalonModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Tambahkan</button>
            </div>
        </form>
    </div>
</div>

<div id="nilaiModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border w-[650px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900" id="nilaiTitle">Input Nilai Kriteria</h3>
            <p class="text-sm text-gray-400 mt-2" id="nilaiSubtitle"></p>
        </div>

        <form id="nilaiForm" action="<?= BASEURL; ?>/blt/simpan_nilai" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_program" value="<?= $data['id_program']; ?>">
            <input type="hidden" name="id_calon" id="nilai_id_calon">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="nilaiInputsContainer">
                <?php if(empty($data['kriteria'])): ?>
                    <div class="col-span-full bg-amber-50 border border-amber-100 text-amber-700 p-5 rounded-2xl text-sm">
                        Belum ada kriteria. Tambahkan kriteria terlebih dahulu.
                    </div>
                <?php else: ?>
                    <?php foreach($data['kriteria'] as $k): ?>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">
                                <?= $k['nama_kriteria']; ?> (<?= $k['bobot']; ?>%)
                            </label>
                            <input type="number" step="0.001" name="kriteria_<?= $k['id_kriteria']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeNilaiModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" id="nilaiSubmitBtn" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCalonModal() {
        document.getElementById('calonModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeCalonModal() {
        document.getElementById('calonModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openNilaiModal(idCalon, dataCalon, isDetail = false) {
        const modal = document.getElementById('nilaiModal');
        const form = document.getElementById('nilaiForm');
        const title = document.getElementById('nilaiTitle');
        const submitBtn = document.getElementById('nilaiSubmitBtn');
        const inputs = form.querySelectorAll('input:not([type="hidden"])');

        document.getElementById('nilai_id_calon').value = idCalon;
        document.getElementById('nilaiSubtitle').innerText = 'NIK: ' + dataCalon.nik + ' | Nama: ' + dataCalon.nama_lengkap;
        
        if (isDetail) {
            title.innerText = 'Detail Nilai Kriteria';
            submitBtn.classList.add('hidden');
            inputs.forEach(input => input.readOnly = true);
            
            // Note: In a real app, you'd fetch the existing values here
            // For now, we just show the readonly fields
        } else {
            title.innerText = 'Input Nilai Kriteria';
            submitBtn.classList.remove('hidden');
            inputs.forEach(input => input.readOnly = false);
            form.reset();
            document.getElementById('nilai_id_calon').value = idCalon;
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeNilaiModal() {
        document.getElementById('nilaiModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
