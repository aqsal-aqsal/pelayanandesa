<?php $this->view('templates/header', $data); ?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Masuk ke Akun</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Gunakan NIK Anda untuk mengakses layanan desa
            </p>
        </div>

        <?php if(isset($_SESSION['flash'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= $_SESSION['flash']['message']; ?></span>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="<?= BASEURL; ?>/auth/login" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="nik" class="sr-only">NIK</label>
                    <input id="nik" name="nik" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Nomor Induk Kependudukan">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-lock text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
