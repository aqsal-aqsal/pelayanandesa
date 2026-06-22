<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2">Data Kependudukan</h2>
            <p class="text-gray-500">Kelola informasi seluruh warga Desa Astambul Kota.</p>
        </div>
        <?php if($_SESSION['user']['level'] != 'kades'): ?>
        <button onclick="openModal('tambah')" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
            <i class="fas fa-user-plus mr-2"></i> TAMBAH WARGA
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
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs">
                                            <?= substr($w['nama_lengkap'], 0, 1); ?>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700"><?= $w['nama_lengkap']; ?></span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $w['nik']; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $w['pekerjaan'] ?? '-'; ?></td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium"><?= $w['alamat']; ?></td>
                                <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                    <?php if($_SESSION['user']['level'] == 'kades'): ?>
                                        <button onclick='openModal("detail", <?= json_encode($w); ?>)' class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                                            Detail
                                        </button>
                                    <?php else: ?>
                                        <button onclick='openModal("edit", <?= json_encode($w); ?>)' class="px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition flex items-center">
                                            Edit
                                        </button>
                                        <a href="<?= BASEURL; ?>/warga/hapus/<?= $w['id_warga']; ?>" onclick="return confirm('Hapus data warga ini?')" class="px-4 py-2 bg-rose-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-700 transition shadow-lg shadow-rose-100 flex items-center">
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
<div id="wargaModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300">
    <div class="relative top-10 mx-auto p-10 border w-[600px] shadow-2xl rounded-[32px] bg-white mb-20">
        <div class="text-center mb-8">
            <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Tambah Warga Baru</h3>
            <p class="text-sm text-gray-400 mt-2">Pastikan data yang dimasukkan sesuai dengan KTP/KK.</p>
            <button type="button" onclick="autofill()" class="mt-4 text-[10px] font-bold text-blue-600 hover:text-blue-800 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full transition-all">
                <i class="fas fa-magic mr-1"></i> Autofill Data
            </button>
        </div>
        
        <form id="wargaForm" action="<?= BASEURL; ?>/warga/tambah" method="POST" class="space-y-6">
            <input type="hidden" name="id_warga" id="id_warga">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK (16 Digit)</label>
                    <input type="text" name="nik" id="nik" required maxlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">RT/RW</label>
                    <input type="text" name="rt_rw" id="rt_rw" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status Kawin</label>
                    <select name="status_kawin" id="status_kawin" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">-- Pilih --</option>
                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai">Cerai</option>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kondisi Rumah</label>
                    <select name="kondisi_rumah" id="kondisi_rumah" class="block w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">-- Pilih --</option>
                        <option value="layak">Layak</option>
                        <option value="kurang_layak">Kurang Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                </div>
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" id="submitBtn" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('wargaModal');
        const form = document.getElementById('wargaForm');
        const title = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('submitBtn');
        const autofillBtn = document.querySelector('button[onclick="autofill()"]');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Reset inputs and mode
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.readOnly = false;
            input.disabled = false;
        });
        submitBtn.classList.remove('hidden');
        if(autofillBtn) autofillBtn.classList.remove('hidden');

        if ((mode === 'edit' || mode === 'detail') && data) {
            title.innerText = mode === 'edit' ? 'Edit Data Warga' : 'Detail Data Warga';
            form.action = mode === 'edit' ? '<?= BASEURL; ?>/warga/edit' : '#';
            
            // Fill form fields
            document.getElementById('id_warga').value = data.id_warga;
            document.getElementById('nik').value = data.nik;
            document.getElementById('nama_lengkap').value = data.nama_lengkap;
            document.getElementById('tempat_lahir').value = data.tempat_lahir;
            document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('rt_rw').value = data.rt_rw;
            document.getElementById('pekerjaan').value = data.pekerjaan;
            document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
            document.getElementById('status_kawin').value = data.status_kawin;
            document.getElementById('penghasilan').value = data.penghasilan;
            document.getElementById('jumlah_tanggungan').value = data.jumlah_tanggungan;
            document.getElementById('kondisi_rumah').value = data.kondisi_rumah;

            if (mode === 'detail') {
                inputs.forEach(input => {
                    if (input.tagName === 'SELECT') input.disabled = true;
                    else input.readOnly = true;
                });
                submitBtn.classList.add('hidden');
                if(autofillBtn) autofillBtn.classList.add('hidden');
            }
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

    function autofill() {
        const names = ['Ahmad Fauzi', 'Siti Aminah', 'Budi Santoso', 'Dewi Lestari', 'Eko Prasetyo', 'Rina Wijaya', 'Slamet Riadi', 'Kartini Putri'];
        const places = ['Martapura', 'Banjarbaru', 'Banjarmasin', 'Astambul', 'Kertak Hanyar'];
        const addresses = ['Jl. Melati No. 12, Astambul', 'Jl. Mawar No. 5, Astambul Kota', 'RT 002 RW 001, Astambul', 'Kec. Astambul, Kab. Banjar'];
        const jobs = ['Petani', 'Pedagang', 'Buruh', 'PNS', 'Wiraswasta', 'IRT'];
        const rtrw = ['01/05', '02/03', '04/06', '03/02'];
        const penghasilanOptions = [500000, 1000000, 1500000, 2000000, 2500000];
        
        const randomName = names[Math.floor(Math.random() * names.length)];
        const randomPlace = places[Math.floor(Math.random() * places.length)];
        const randomAddress = addresses[Math.floor(Math.random() * addresses.length)];
        const randomJob = jobs[Math.floor(Math.random() * jobs.length)];
        const randomRT = rtrw[Math.floor(Math.random() * rtrw.length)];
        const randomPenghasilan = penghasilanOptions[Math.floor(Math.random() * penghasilanOptions.length)];
        const randomJK = Math.random() > 0.5 ? 'L' : 'P';
        const randomStatusKawin = ['belum_kawin', 'kawin', 'cerai'][Math.floor(Math.random() * 3)];
        const randomKondisiRumah = ['layak', 'kurang_layak', 'tidak_layak'][Math.floor(Math.random() * 3)];
        const randomJumlahTanggungan = Math.floor(Math.random() * 5);
        const randomNIK = '6303' + Math.floor(Math.random() * 1000000000000).toString().padStart(12, '0');
        
        // Random date between 1970 and 2005
        const start = new Date(1970, 0, 1);
        const end = new Date(2005, 0, 1);
        const randomDate = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        const dateStr = randomDate.toISOString().split('T')[0];

        document.getElementById('nik').value = randomNIK;
        document.getElementById('nama_lengkap').value = randomName;
        document.getElementById('tempat_lahir').value = randomPlace;
        document.getElementById('tanggal_lahir').value = dateStr;
        document.getElementById('alamat').value = randomAddress;
        document.getElementById('rt_rw').value = randomRT;
        document.getElementById('pekerjaan').value = randomJob;
        document.getElementById('jenis_kelamin').value = randomJK;
        document.getElementById('status_kawin').value = randomStatusKawin;
        document.getElementById('penghasilan').value = randomPenghasilan;
        document.getElementById('jumlah_tanggungan').value = randomJumlahTanggungan;
        document.getElementById('kondisi_rumah').value = randomKondisiRumah;
    }
</script>

<?php $this->view('templates/footer', $data); ?>
