<?php $this->view('templates/header', $data); ?>

<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-8">
        <div class="relative group">
            <div class="w-32 h-32 rounded-[32px] bg-blue-50 overflow-hidden border-4 border-white shadow-xl">
                <img src="https://ui-avatars.com/api/?name=<?= $data['warga']['nama_lengkap']; ?>&background=0284c7&color=fff&size=128" alt="Profile" id="previewFoto">
            </div>
            <label for="foto" class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center cursor-pointer hover:bg-blue-700 transition shadow-lg">
                <i class="fas fa-camera"></i>
                <input type="file" id="foto" name="foto" class="hidden" accept="image/*" form="formWarga">
            </label>
        </div>
        <div class="text-center md:text-left">
            <h2 class="text-3xl font-black text-slate-900 mb-1"><?= $data['warga']['nama_lengkap']; ?></h2>
            <p class="text-gray-500 font-medium">NIK: <?= $data['warga']['nik']; ?> &bull; Warga Desa Astambul Kota</p>
        </div>
    </div>

    <?php if(isset($_SESSION['flash'])): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl text-sm flex justify-between items-center">
            <span><?= $_SESSION['flash']['message']; ?></span>
            <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700"><i class="fas fa-times"></i></button>
            <?php unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-4">
            <button onclick="showTab('biodata')" class="tab-btn active w-full p-6 bg-white rounded-[24px] border border-gray-100 flex items-center space-x-4 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-white transition"><i class="fas fa-user"></i></div>
                <span class="font-bold text-slate-700">Biodata Diri</span>
            </button>
            <button onclick="showTab('akun')" class="tab-btn w-full p-6 bg-white rounded-[24px] border border-gray-100 flex items-center space-x-4 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-500 flex items-center justify-center group-hover:bg-white transition"><i class="fas fa-lock"></i></div>
                <span class="font-bold text-slate-700">Data Akun & Keamanan</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-2">
            <!-- Tab Biodata -->
            <div id="tab-biodata" class="tab-content bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
                <h3 class="text-xl font-black text-slate-900 mb-8">Biodata Lengkap</h3>
                <form id="formWarga" action="<?= BASEURL; ?>/profile/update_warga" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id_warga" value="<?= $data['warga']['id_warga']; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= $data['warga']['nama_lengkap']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK</label>
                            <input type="text" value="<?= $data['warga']['nik']; ?>" disabled class="block w-full px-5 py-4 bg-gray-200 border border-gray-200 rounded-2xl text-gray-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= $data['warga']['tempat_lahir']; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= $data['warga']['tanggal_lahir']; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"><?= $data['warga']['alamat']; ?></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="<?= $data['warga']['pekerjaan']; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="L" <?= $data['warga']['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= $data['warga']['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition uppercase tracking-widest">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- Tab Akun -->
            <div id="tab-akun" class="tab-content hidden bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
                <h3 class="text-xl font-black text-slate-900 mb-8">Data Akun & Keamanan</h3>
                <form action="<?= BASEURL; ?>/profile/update_account" method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Alamat Email</label>
                        <input type="email" name="email" value="<?= $data['user']['email']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">No. WhatsApp</label>
                        <input type="text" name="no_hp" value="<?= $data['user']['no_hp']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Password Baru (Kosongkan jika tidak ganti)</label>
                        <input type="password" name="new_password" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="********">
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl shadow-lg hover:bg-slate-800 transition uppercase tracking-widest">Update Data Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById('tab-' + tab).classList.remove('hidden');
        
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active', 'bg-blue-50', 'text-blue-600');
            b.querySelector('div').classList.remove('bg-blue-50', 'text-blue-600');
            b.querySelector('div').classList.add('bg-gray-50', 'text-gray-500');
        });
        
        const activeBtn = event.currentTarget;
        activeBtn.classList.add('active', 'bg-blue-50', 'text-blue-600');
        activeBtn.querySelector('div').classList.remove('bg-gray-50', 'text-gray-500');
        activeBtn.querySelector('div').classList.add('bg-blue-50', 'text-blue-600');
    }

    document.getElementById('foto').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('previewFoto').src = URL.createObjectURL(file);
        }
    }
</script>

<?php $this->view('templates/footer', $data); ?>