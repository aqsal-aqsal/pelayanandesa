<?php $this->view('templates/header', $data); ?>

<div class="text-center py-12">
    <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
        Pelayanan Desa <span class="text-blue-600">Terpadu</span>
    </h1>
    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
        Sistem Informasi Pelayanan Desa Astambul Kota. Ajukan surat, kirim pengaduan, dan cek penerima bantuan dengan mudah dan transparan.
    </p>
    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
        <div class="rounded-md shadow">
            <a href="<?= BASEURL; ?>/layanan" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                Ajukan Layanan
            </a>
        </div>
        <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
            <a href="<?= BASEURL; ?>/pengaduan" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                Kirim Pengaduan
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
    <!-- Feature 1 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4 text-2xl">
            <i class="fas fa-file-alt"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2">Surat Online</h3>
        <p class="text-gray-600">Ajukan berbagai jenis surat keterangan dan dokumen desa secara online tanpa antre lama.</p>
    </div>
    <!-- Feature 2 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4 text-2xl">
            <i class="fas fa-hand-holding-heart"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2">Bantuan (BLT)</h3>
        <p class="text-gray-600">Transparansi seleksi penerima bantuan menggunakan algoritma SAW yang adil dan akurat.</p>
    </div>
    <!-- Feature 3 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mb-4 text-2xl">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2">Pengaduan</h3>
        <p class="text-gray-600">Sampaikan keluhan atau aspirasi Anda langsung kepada pemerintah desa dengan sistem prioritas.</p>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
