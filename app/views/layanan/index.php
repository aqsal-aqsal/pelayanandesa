<?php $this->view('templates/header', $data); ?>

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-blue-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white">Form Pengajuan Surat Online</h2>
    </div>
    
    <form action="<?= BASEURL; ?>/layanan/ajukan" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        <input type="hidden" name="id_warga" value="<?= $data['warga']['id_warga']; ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" disabled value="<?= $data['warga']['nama_lengkap']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" disabled value="<?= $data['warga']['nik']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>

        <div>
            <label for="id_jenis_surat" class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
            <select name="id_jenis_surat" id="id_jenis_surat" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">-- Pilih Jenis Surat --</option>
                <?php foreach($data['jenis_surat'] as $js): ?>
                    <option value="<?= $js['id_jenis_surat']; ?>"><?= $js['nama_surat']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="urgensi" class="block text-sm font-medium text-gray-700 mb-1">Tingkat Urgensi (Prioritas)</label>
            <select name="urgensi" id="urgensi" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="1">Normal</option>
                <option value="2">Mendesak</option>
                <option value="3">Sangat Mendesak (Darurat)</option>
            </select>
            <p class="mt-1 text-xs text-gray-500">Pilihan urgensi akan mempengaruhi urutan antrean pelayanan.</p>
        </div>

        <div>
            <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
            <textarea name="keperluan" id="keperluan" rows="3" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jelaskan alasan pengajuan surat ini..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Berkas Pendukung (KTP/KK)</label>
            <input type="file" name="file_berkas" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, PDF (Maks. 2MB)</p>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="<?= BASEURL; ?>/dashboard" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Kirim Pengajuan</button>
        </div>
    </form>
</div>

<?php $this->view('templates/footer', $data); ?>
