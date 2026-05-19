<?php $this->view('templates/header', $data); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Seleksi BLT (SAW)</h2>
        <p class="text-gray-600">Kelola program bantuan dan jalankan perhitungan seleksi.</p>
    </div>
</div>

<?php if(isset($_SESSION['flash'])): ?>
    <div class="bg-<?= $_SESSION['flash']['type'] == 'success' ? 'green' : 'red'; ?>-100 border border-<?= $_SESSION['flash']['type'] == 'success' ? 'green' : 'red'; ?>-400 text-<?= $_SESSION['flash']['type'] == 'success' ? 'green' : 'red'; ?>-700 px-4 py-3 rounded relative mb-6">
        <?= $_SESSION['flash']['message']; ?>
        <?php unset($_SESSION['flash']); ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 gap-6">
    <?php foreach($data['programs'] as $p): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900"><?= $p['nama_program']; ?></h3>
                <p class="text-sm text-gray-500"><?= $p['periode']; ?> | Kuota: <?= $p['kuota_penerima']; ?> Orang</p>
            </div>
            <div class="flex space-x-2">
                <a href="<?= BASEURL; ?>/blt/hitung/<?= $p['id_program']; ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                    <i class="fas fa-calculator mr-2"></i> Hitung SAW
                </a>
                <a href="<?= BASEURL; ?>/blt/detail/<?= $p['id_program']; ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    <i class="fas fa-list-ol mr-2"></i> Lihat Hasil
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $this->view('templates/footer', $data); ?>
