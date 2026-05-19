<?php $this->view('templates/header', $data); ?>

<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900">Verifikasi Keaslian Dokumen</h2>
        <p class="mt-2 text-gray-600">Scan QR Code pada surat atau masukkan token di bawah untuk memverifikasi keaslian dokumen.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <?php if($data['surat']): ?>
            <div class="bg-green-600 px-6 py-4 flex items-center justify-between">
                <span class="text-white font-bold flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> DOKUMEN ASLI & TERVERIFIKASI
                </span>
                <span class="text-green-100 text-xs font-mono"><?= $data['surat']['qr_token']; ?></span>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-4 border-b pb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Surat</p>
                        <p class="text-lg font-bold text-gray-800"><?= $data['surat']['nama_surat']; ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Nomor Surat</p>
                        <p class="text-lg font-bold text-gray-800"><?= $data['surat']['no_surat'] ?? '-'; ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 border-b pb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Nama Pemilik</p>
                        <p class="text-gray-800 font-medium"><?= $data['surat']['nama_lengkap']; ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Terbit</p>
                        <p class="text-gray-800 font-medium"><?= date('d F Y', strtotime($data['surat']['tanggal_selesai'])); ?></p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Diverifikasi Oleh</p>
                    <p class="text-gray-800 font-medium"><?= $data['surat']['kades'] ?? 'Kepala Desa Astambul Kota'; ?></p>
                </div>

                <div class="pt-4">
                    <div class="bg-blue-50 p-4 rounded-lg flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <p class="text-sm text-blue-700">Dokumen ini diterbitkan secara resmi melalui Sistem Informasi Pelayanan Desa Terpadu Desa Astambul Kota.</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400 text-3xl">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Token Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-8">Maaf, token verifikasi tidak valid atau dokumen tidak terdaftar dalam sistem kami.</p>
                
                <form action="<?= BASEURL; ?>/verify" method="GET" class="max-w-sm mx-auto">
                    <div class="flex space-x-2">
                        <input type="text" name="url" placeholder="Masukkan Token..." class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Cek</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-8 text-center">
        <a href="<?= BASEURL; ?>" class="text-blue-600 hover:underline font-medium">Kembali ke Beranda</a>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
