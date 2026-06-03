<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Selamat Datang, <?= $data['warga']['nama_lengkap'] ?? 'Warga'; ?>!</h2>
            <p class="text-gray-500">Kelola profil dan pantau status layanan Anda di sini.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Surat Menunggu</h3>
            <p class="text-2xl font-black text-slate-900"><?= $data['surat_menunggu']; ?></p>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-file-check"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Surat Selesai</h3>
            <p class="text-2xl font-black text-slate-900"><?= $data['surat_selesai']; ?></p>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Total Pengaduan</h3>
            <p class="text-2xl font-black text-slate-900"><?= $data['aduan_total']; ?></p>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <h3 class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Status Bantuan</h3>
            <p class="text-sm font-black text-slate-900 truncate">
                <?= isset($data['hasil_blt']['status_penerimaan']) ? strtoupper((string)$data['hasil_blt']['status_penerimaan']) : 'TIDAK TERDAFTAR'; ?>
            </p>
        </div>
    </div>

    <?php if(isset($_SESSION['flash'])): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl text-sm flex justify-between items-center">
            <span><?= $_SESSION['flash']['message']; ?></span>
            <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700"><i class="fas fa-times"></i></button>
            <?php unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <!-- Status Pengajuan Table -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <h3 class="font-bold text-slate-800">Status Pengajuan Surat</h3>
            <a href="<?= BASEURL; ?>/layanan" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-xs font-black hover:bg-blue-700 transition shadow-lg shadow-blue-100 uppercase tracking-widest">
                <i class="fas fa-plus mr-2"></i> Ajukan Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pengajuan'])): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengajuan surat yang tercatat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengajuan'] as $p): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $p['nama_surat']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= date('d F Y', strtotime($p['tanggal_pengajuan'])); ?></td>
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
                                    <?php if($p['status'] == 'menunggu'): ?>
                                        <a href="<?= BASEURL; ?>/layanan/hapus_pengajuan/<?= $p['id_pengajuan']; ?>" onclick="return confirm('Batalkan pengajuan ini?')" class="text-rose-500 hover:text-rose-700 font-black text-[10px] uppercase tracking-widest">Batalkan</a>
                                    <?php elseif($p['status'] == 'selesai'): ?>
                                        <a href="<?= BASEURL; ?>/layanan/unduh/<?= $p['id_pengajuan']; ?>" target="_blank" class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase tracking-widest">Unduh</a>
                                    <?php else: ?>
                                        <span class="text-gray-300 font-black text-[10px] uppercase tracking-widest cursor-not-allowed">No Action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <h3 class="font-bold text-slate-800">Status Pengaduan Masyarakat</h3>
            <a href="<?= BASEURL; ?>/pengaduan" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-xs font-black hover:bg-blue-700 transition shadow-lg shadow-blue-100 uppercase tracking-widest">
                <i class="fas fa-plus mr-2"></i> Buat Pengaduan
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['pengaduan'])): ?>
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">Belum ada pengaduan yang tercatat.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['pengaduan'] as $a): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-700"><?= $a['judul_aduan']; ?></td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        <?= $a['kategori_aduan']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= date('d F Y', strtotime($a['tanggal_aduan'])); ?></td>
                                <td class="px-8 py-5">
                                    <?php 
                                        $statusStylesAduan = [
                                            'menunggu' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'diproses' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'selesai' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100'
                                        ];
                                        $styleAduan = $statusStylesAduan[$a['status']] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    ?>
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg border uppercase tracking-wider <?= $styleAduan; ?>">
                                        <?= $a['status']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Profile -->
<div id="profileModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-10 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-black text-slate-900">Perbarui Profil Saya</h3>
            <p class="text-sm text-gray-400 mt-2">Pastikan data Anda selalu yang terbaru.</p>
        </div>
        
        <form action="<?= BASEURL; ?>/dashboard/update_profil" method="POST" class="space-y-6 text-left">
            <input type="hidden" name="id_warga" id="prof_id_warga">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="prof_nama" required class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="prof_pekerjaan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="prof_tempat_lahir" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="prof_tanggal_lahir" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="prof_jk" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status Kawin</label>
                    <select name="status_kawin" id="prof_status_kawin" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai">Cerai</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Alamat</label>
                    <input type="text" name="alamat" id="prof_alamat" required class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">RT/RW</label>
                    <input type="text" name="rt_rw" id="prof_rt_rw" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Penghasilan</label>
                    <input type="number" name="penghasilan" id="prof_penghasilan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggungan</label>
                    <input type="number" name="jumlah_tanggungan" id="prof_tanggungan" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kondisi Rumah</label>
                    <select name="kondisi_rumah" id="prof_rumah" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="layak">Layak</option>
                        <option value="kurang_layak">Kurang Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                </div>
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="button" onclick="closeProfileModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openProfileModal(data) {
        const modal = document.getElementById('profileModal');
        document.getElementById('prof_id_warga').value = data.id_warga;
        document.getElementById('prof_nama').value = data.nama_lengkap;
        document.getElementById('prof_pekerjaan').value = data.pekerjaan;
        document.getElementById('prof_alamat').value = data.alamat;
        document.getElementById('prof_tempat_lahir').value = data.tempat_lahir;
        document.getElementById('prof_tanggal_lahir').value = data.tanggal_lahir;
        document.getElementById('prof_jk').value = data.jenis_kelamin;
        document.getElementById('prof_status_kawin').value = data.status_kawin;
        document.getElementById('prof_rt_rw').value = data.rt_rw;
        document.getElementById('prof_penghasilan').value = data.penghasilan;
        document.getElementById('prof_tanggungan').value = data.jumlah_tanggungan;
        document.getElementById('prof_rumah').value = data.kondisi_rumah;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<?php $this->view('templates/footer', $data); ?>
