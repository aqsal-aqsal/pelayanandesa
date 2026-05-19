<?php $this->view('templates/header', $data); ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Program Bantuan Langsung Tunai (BLT)</h2>
    <p class="text-gray-600">Daftar program bantuan sosial yang tersedia di Desa Astambul Kota.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($data['programs'] as $p): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 flex-1">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $p['status'] == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'; ?>">
                        <?= ucfirst($p['status']); ?>
                    </span>
                    <span class="text-sm text-gray-500"><?= $p['periode']; ?></span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $p['nama_program']; ?></h3>
                <p class="text-gray-600 text-sm mb-4">Sumber Dana: <?= $p['sumber_dana']; ?></p>
                
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Anggaran</span>
                        <span class="font-semibold">Rp <?= number_format($p['total_anggaran'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Kuota Penerima</span>
                        <span class="font-semibold"><?= $p['kuota_penerima']; ?> Orang</span>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <a href="<?= BASEURL; ?>/blt/detail/<?= $p['id_program']; ?>" class="block text-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                    Lihat Hasil Seleksi (SAW)
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $this->view('templates/footer', $data); ?>
