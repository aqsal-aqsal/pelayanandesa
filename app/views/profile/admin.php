<?php $this->view('templates/header', $data); ?>

<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-8">
        <div class="relative group">
            <div class="w-32 h-32 rounded-[32px] bg-blue-50 overflow-hidden border-4 border-white shadow-xl">
                <img src="https://ui-avatars.com/api/?name=<?= $data['petugas']['nama_petugas']; ?>&background=0f172a&color=fff&size=128" alt="Profile" id="previewFoto">
            </div>
            <label for="foto" class="absolute -bottom-2 -right-2 w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center cursor-pointer hover:bg-slate-800 transition shadow-lg">
                <i class="fas fa-camera"></i>
                <input type="file" id="foto" name="foto" class="hidden" accept="image/*" form="formAdmin">
            </label>
        </div>
        <div class="text-center md:text-left">
            <h2 class="text-3xl font-black text-slate-900 mb-1"><?= $data['petugas']['nama_petugas']; ?></h2>
            <p class="text-gray-500 font-medium">Jabatan: <?= $data['petugas']['jabatan']; ?> &bull; <?= ucfirst($_SESSION['user']['level']); ?></p>
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
            <button onclick="showTab('biodata')" class="tab-btn active w-full p-6 bg-white rounded-[24px] border border-gray-100 flex items-center space-x-4 hover:bg-slate-50 transition group text-left">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-white transition"><i class="fas fa-user-tie"></i></div>
                <span class="font-bold text-slate-700">Profil Petugas</span>
            </button>
            <button onclick="showTab('akun')" class="tab-btn w-full p-6 bg-white rounded-[24px] border border-gray-100 flex items-center space-x-4 hover:bg-slate-50 transition group text-left">
                <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-500 flex items-center justify-center group-hover:bg-white transition"><i class="fas fa-key"></i></div>
                <span class="font-bold text-slate-700">Akun & Keamanan</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-2">
            <!-- Tab Biodata -->
            <div id="tab-biodata" class="tab-content bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
                <h3 class="text-xl font-black text-slate-900 mb-8">Data Profil Petugas</h3>
                <form id="formAdmin" action="<?= BASEURL; ?>/pejabat/update" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id_petugas" value="<?= $data['petugas']['id_petugas']; ?>">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="nama_petugas" value="<?= $data['petugas']['nama_petugas']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jabatan</label>
                        <input type="text" name="jabatan" value="<?= $data['petugas']['jabatan']; ?>" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition uppercase tracking-widest">Update Profil</button>
                    </div>
                </form>
            </div>

            <!-- Tab Akun -->
            <div id="tab-akun" class="tab-content hidden bg-white p-10 rounded-[32px] shadow-sm border border-gray-100">
                <h3 class="text-xl font-black text-slate-900 mb-8">Data Akun & Keamanan</h3>
                <form action="<?= BASEURL; ?>/profile/update_account" method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Username (NIK)</label>
                        <input type="text" value="<?= $data['user']['nik']; ?>" disabled class="block w-full px-5 py-4 bg-gray-200 border border-gray-200 rounded-2xl text-gray-500">
                    </div>
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
            b.classList.remove('active', 'bg-blue-50', 'text-blue-600', 'bg-slate-50', 'text-slate-900');
            b.querySelector('div').classList.remove('bg-blue-50', 'text-blue-600');
            b.querySelector('div').classList.add('bg-gray-50', 'text-gray-500');
        });
        
        const activeBtn = event.currentTarget;
        activeBtn.classList.add('active', 'bg-slate-50', 'text-slate-900');
        activeBtn.querySelector('div').classList.remove('bg-gray-50', 'text-gray-500');
        activeBtn.querySelector('div').classList.add('bg-blue-50', 'text-blue-600');
    }
</script>

<?php $this->view('templates/footer', $data); ?>