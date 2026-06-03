<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Laporan & Statistik</h2>
            <p class="text-gray-500">Monitoring kinerja pelayanan desa dan hasil seleksi bantuan.</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="openReportModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                <i class="fas fa-print mr-2"></i> CETAK LAPORAN BARU
            </button>
        </div>
    </div>

    <!-- Modal Cetak Laporan -->
    <div id="reportModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
        <div class="relative top-20 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-black text-slate-900">Cetak Laporan Desa</h3>
                <p class="text-sm text-gray-400 mt-2">Pilih jenis laporan dan filter yang diinginkan.</p>
            </div>
            
            <form action="<?= BASEURL; ?>/laporan/preview" method="POST" class="space-y-6 text-left">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Laporan</label>
                    <select name="jenis_laporan" id="jenis_laporan" required onchange="handleReportChange()" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="surat">Laporan Pengajuan Surat</option>
                        <option value="aduan">Laporan Pengaduan Warga</option>
                        <option value="informasi">Laporan Informasi Publik</option>
                        <option value="program">Laporan Program Bantuan</option>
                        <option value="penerima">Daftar Penerima Bantuan</option>
                        <option value="warga">Daftar Warga Astambul Kota</option>
                    </select>
                </div>

                <div id="filter_surat" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status Surat</label>
                        <select name="status_surat" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="semua">Semua Status</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</label>
                        <select name="id_jenis_surat" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="semua">Semua Jenis</option>
                            <?php 
                                $jenis_surat = $this->model('SuratModel')->getJenisSurat();
                                foreach($jenis_surat as $js): 
                            ?>
                                <option value="<?= $js['id_jenis_surat']; ?>"><?= $js['nama_surat']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeReportModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i> PREVIEW DATA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReportModal() {
            document.getElementById('reportModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function handleReportChange() {
            const jenis = document.getElementById('jenis_laporan').value;
            const filterSurat = document.getElementById('filter_surat');
            if (jenis === 'surat') {
                filterSurat.classList.remove('hidden');
            } else {
                filterSurat.classList.add('hidden');
            }
        }
    </script>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-envelope-open-text text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_surat']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pengajuan Surat</div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_pengaduan']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pengaduan</div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-hand-holding-heart text-xl"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1"><?= $data['total_program']; ?></div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Program Bantuan</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Surat Stats -->
        <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-8">Status Pelayanan Surat</h3>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Selesai</span>
                        <span class="text-blue-600"><?= $data['stats_surat']['selesai']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['selesai'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Sedang Diproses</span>
                        <span class="text-amber-600"><?= $data['stats_surat']['proses']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['proses'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[10px]">Ditolak</span>
                        <span class="text-rose-600"><?= $data['stats_surat']['ditolak']; ?></span>
                    </div>
                    <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-full rounded-full" style="width: <?= $data['total_surat'] > 0 ? ($data['stats_surat']['ditolak'] / $data['total_surat'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export BLT -->
        <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-900 mb-8">Cetak Hasil Seleksi BLT</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Pilih program bantuan untuk mengunduh laporan hasil perhitungan perankingan SAW.</p>
            
            <div class="space-y-4">
                <?php 
                    $bltModel = $this->model('BltModel');
                    $programs = $bltModel->getPrograms();
                    foreach($programs as $p): 
                ?>
                    <div class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl hover:bg-blue-50 transition group">
                        <div>
                            <div class="font-bold text-slate-700"><?= $p['nama_program']; ?></div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1"><?= $p['periode']; ?></div>
                        </div>
                        <a href="<?= BASEURL; ?>/laporan/cetak_blt/<?= $p['id_program']; ?>" target="_blank" class="p-3 bg-white text-blue-600 rounded-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>