<?php $this->view('templates/header', $data); ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-[520px] w-full bg-white p-12 rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white/20">
        <div class="text-center mb-10">
            <img src="<?= BASEURL; ?>/assets/img/logokabbanjar.png" alt="Logo Kabupaten Banjar" class="w-20 h-20 object-contain mx-auto mb-4">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Registrasi Warga</h2>
            <p class="text-gray-500 font-medium">Daftar untuk mengakses layanan desa</p>
            <button type="button" onclick="autofill()" class="mt-4 text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full transition-all">
                <i class="fas fa-magic mr-1"></i> Autofill Data
            </button>
        </div>

        <?php if(isset($_SESSION['flash'])): ?>
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl mb-6 text-sm">
                <?= $_SESSION['flash']['message']; ?>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/register" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">NIK <span class="text-red-500">*</span></label>
                <input name="nik" id="reg_nik" type="text" required maxlength="16" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Masukkan 16 digit NIK">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input name="nama_lengkap" id="reg_nama_lengkap" type="text" required
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Nama sesuai KTP">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input name="tempat_lahir" id="reg_tempat_lahir" type="text" required
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="Tempat lahir">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input name="tanggal_lahir" id="reg_tanggal_lahir" type="date" required
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="reg_jenis_kelamin" required
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Status Kawin <span class="text-red-500">*</span></label>
                    <select name="status_kawin" id="reg_status_kawin" required
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai">Cerai</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                <input name="alamat" id="reg_alamat" type="text" required
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Alamat domisili">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">RT/RW</label>
                <input name="rt_rw" id="reg_rt_rw" type="text"
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Contoh: 01/05">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Pekerjaan</label>
                    <input name="pekerjaan" id="reg_pekerjaan" type="text"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="Pekerjaan">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Penghasilan Bulanan (Rp)</label>
                    <input name="penghasilan" id="reg_penghasilan" type="number"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="500000">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Jumlah Tanggungan</label>
                    <input name="jumlah_tanggungan" id="reg_jumlah_tanggungan" type="number"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="Jumlah tanggungan">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kondisi Rumah</label>
                    <select name="kondisi_rumah" id="reg_kondisi_rumah"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="layak">Layak</option>
                        <option value="kurang_layak">Kurang Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">No. HP</label>
                    <input name="no_hp" id="reg_no_hp" type="text"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
                    <input name="email" id="reg_email" type="email"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="email@contoh.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password <span class="text-red-500">*</span></label>
                <input name="password" id="reg_password" type="password" required
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Buat password">
            </div>

            <div class="pt-4 space-y-4">
                <button type="submit"
                    class="w-full py-4 px-6 bg-blue-600 text-white text-lg font-bold rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all duration-300 transform active:scale-[0.98]">
                    Daftar Sekarang
                </button>
                <a href="<?= BASEURL; ?>/auth" class="w-full inline-flex justify-center items-center py-4 px-6 bg-white text-slate-700 text-sm font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 transition">
                    Sudah punya akun? Login
                </a>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="<?= BASEURL; ?>" class="inline-flex items-center text-gray-400 hover:text-blue-600 font-bold text-sm transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali ke Beranda
            </a>
        </div>
<script>
    function autofill() {
        const names = ['Ahmad Fauzi', 'Siti Aminah', 'Budi Santoso', 'Dewi Lestari', 'Eko Prasetyo', 'Rina Wijaya'];
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
        const randomHP = '08' + Math.floor(Math.random() * 1000000000).toString().padStart(10, '0');
        const email = randomName.toLowerCase().replace(' ', '.') + '@gmail.com';
        
        // Random date between 1970 and 2005
        const start = new Date(1970, 0, 1);
        const end = new Date(2005, 0, 1);
        const randomDate = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        const dateStr = randomDate.toISOString().split('T')[0];

        document.getElementById('reg_nik').value = randomNIK;
        document.getElementById('reg_nama_lengkap').value = randomName;
        document.getElementById('reg_tempat_lahir').value = randomPlace;
        document.getElementById('reg_tanggal_lahir').value = dateStr;
        document.getElementById('reg_jenis_kelamin').value = randomJK;
        document.getElementById('reg_status_kawin').value = randomStatusKawin;
        document.getElementById('reg_alamat').value = randomAddress;
        document.getElementById('reg_rt_rw').value = randomRT;
        document.getElementById('reg_pekerjaan').value = randomJob;
        document.getElementById('reg_penghasilan').value = randomPenghasilan;
        document.getElementById('reg_jumlah_tanggungan').value = randomJumlahTanggungan;
        document.getElementById('reg_kondisi_rumah').value = randomKondisiRumah;
        document.getElementById('reg_no_hp').value = randomHP;
        document.getElementById('reg_email').value = email;
        document.getElementById('reg_password').value = 'password123';
    }
</script>

    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
