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
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">NIK</label>
                <input name="nik" type="text" required maxlength="16"
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Masukkan 16 digit NIK">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Lengkap</label>
                <input name="nama_lengkap" type="text" required
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Nama sesuai KTP">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Alamat</label>
                <input name="alamat" type="text" required
                    class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                    placeholder="Alamat domisili">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">No. HP</label>
                    <input name="no_hp" type="text"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
                    <input name="email" type="email"
                        class="block w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 outline-none"
                        placeholder="email@contoh.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password</label>
                <input name="password" type="password" required
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
        const address = ['Jl. Melati No. 12, Astambul', 'Jl. Mawar No. 5, Astambul Kota', 'RT 002 RW 001, Astambul', 'Kec. Astambul, Kab. Banjar'];
        
        const randomName = names[Math.floor(Math.random() * names.length)];
        const randomAddress = address[Math.floor(Math.random() * address.length)];
        const randomNIK = '6303' + Math.floor(Math.random() * 1000000000000).toString().padStart(12, '0');
        const randomHP = '08' + Math.floor(Math.random() * 1000000000).toString().padStart(10, '0');
        const email = randomName.toLowerCase().replace(' ', '.') + '@gmail.com';

        document.querySelector('input[name="nik"]').value = randomNIK;
        document.querySelector('input[name="nama_lengkap"]').value = randomName;
        document.querySelector('input[name="alamat"]').value = randomAddress;
        document.querySelector('input[name="no_hp"]').value = randomHP;
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="password"]').value = 'password123';
    }
</script>

    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
