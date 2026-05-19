<?php $this->view('templates/header', $data); ?>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                <?= substr($data['user']['nik'], 0, 1); ?>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900"><?= $data['warga']['nama_lengkap'] ?? 'Warga'; ?></p>
                <p class="text-xs text-gray-500"><?= $data['user']['nik']; ?></p>
            </div>
        </div>
        
        <nav class="space-y-2">
            <a href="<?= BASEURL; ?>/dashboard/warga" class="flex items-center space-x-3 p-3 rounded-lg bg-blue-50 text-blue-600 font-medium">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= BASEURL; ?>/layanan" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-file-alt"></i>
                <span>Ajukan Surat</span>
            </a>
            <a href="<?= BASEURL; ?>/pengaduan" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-exclamation-circle"></i>
                <span>Kirim Pengaduan</span>
            </a>
            <a href="<?= BASEURL; ?>/blt" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Cek BLT</span>
            </a>
            <hr class="my-4">
            <a href="<?= BASEURL; ?>/auth/logout" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 space-y-6">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, <?= $data['warga']['nama_lengkap'] ?? 'Warga'; ?>!</h2>
            <p class="text-gray-600">Pantau status pengajuan surat dan pengaduan Anda di sini.</p>
        </div>

        <!-- Status Pengajuan Terakhir -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Status Pengajuan Surat</h3>
                <a href="<?= BASEURL; ?>/layanan" class="text-sm text-blue-600 hover:underline">Ajukan Baru</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis Surat</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if(empty($data['pengajuan'])): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan surat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($data['pengajuan'] as $p): ?>
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900"><?= $p['nama_surat']; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= date('d/m/Y', strtotime($p['tanggal_pengajuan'])); ?></td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $statusColor = [
                                                'menunggu' => 'bg-blue-100 text-blue-700',
                                                'diproses' => 'bg-yellow-100 text-yellow-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700'
                                            ];
                                        ?>
                                        <span class="px-2 py-1 text-xs font-bold rounded-full <?= $statusColor[$p['status']] ?? 'bg-gray-100'; ?>">
                                            <?= ucfirst($p['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
