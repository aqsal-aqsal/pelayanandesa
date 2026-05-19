<?php $this->view('templates/header', $data); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-2xl border border-gray-200">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Login Sistem</h2>
            <p class="text-sm text-gray-500 italic">Silakan masukkan akun Anda untuk melanjutkan</p>
        </div>

        <?php if(isset($_SESSION['flash'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm"><?= $_SESSION['flash']['message']; ?></p>
                    </div>
                </div>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="<?= BASEURL; ?>/auth/login" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">Username / NIK</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="nik" name="nik" type="text" required class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition sm:text-sm" placeholder="Masukkan NIK Anda">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition sm:text-sm" placeholder="Masukkan Password">
                    </div>
                </div>
            </div>

            <div class="space-y-3 pt-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02]">
                    MASUK KE SISTEM
                </button>
                <a href="<?= BASEURL; ?>" class="w-full flex justify-center py-3 px-4 border border-gray-300 text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all duration-200">
                    KEMBALI KE BERANDA
                </a>
            </div>
        </form>
        
        <div class="mt-8 text-center border-t pt-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Desa Astambul Kota</p>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
