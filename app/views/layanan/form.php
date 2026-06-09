<?php $this->view('templates/header', $data); ?>

<?php
    $is_edit = isset($data['pengajuan_edit']);
    $pengajuan = $data['pengajuan_edit'] ?? null;
?>

<div class="space-y-8 max-w-4xl mx-auto">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2"><?= $is_edit ? 'Edit Pengajuan Surat' : 'Ajukan Surat Baru'; ?></h2>
            <p class="text-gray-500">Lengkapi data pengajuan surat Anda.</p>
        </div>
        <a href="<?= BASEURL; ?>/layanan" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-10 py-8">
            <h3 class="text-2xl font-black text-white"><?= $is_edit ? 'Perbarui Data Pengajuan' : 'Form Pengajuan Surat Online'; ?></h3>
            <p class="text-blue-100 text-sm mt-1">Pastikan data benar sebelum dikirim.</p>
        </div>
        
        <form onsubmit="this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerText='Mengirim...'; return true;" action="<?= BASEURL; ?>/layanan/<?= $is_edit ? 'update' : 'ajukan'; ?>" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            <input type="hidden" name="id_warga" value="<?= $data['warga']['id_warga']; ?>">
            <?php if($is_edit): ?>
                <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan']; ?>">
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" disabled value="<?= $data['warga']['nama_lengkap']; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">NIK</label>
                    <input type="text" disabled value="<?= $data['warga']['nik']; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</label>
                <select name="id_jenis_surat" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">-- Pilih Jenis Surat --</option>
                    <?php foreach($data['jenis_surat'] as $js): ?>
                        <option value="<?= $js['id_jenis_surat']; ?>" <?= $is_edit && (int)$pengajuan['id_jenis_surat'] === (int)$js['id_jenis_surat'] ? 'selected' : ''; ?>>
                            <?= $js['nama_surat']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Keperluan</label>
                <textarea name="keperluan" rows="4" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Jelaskan alasan pengajuan surat ini..."><?= $is_edit ? $pengajuan['keperluan'] : ''; ?></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Upload Berkas Pendukung (KTP/KK) <span class="text-red-500">*</span></label>
                <input type="file" name="file_berkas" id="file_berkas_input" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" <?= $is_edit ? '' : 'required' ?>>
                <!-- Preview Nama File -->
                <div id="file_preview" class="flex items-center gap-2 p-3 <?= $is_edit && $pengajuan['file_berkas'] ? 'bg-green-50 border border-green-100 text-green-700' : 'bg-gray-50 border border-gray-200 text-gray-600' ?> rounded-xl text-sm">
                    <?php if($is_edit && $pengajuan['file_berkas']): ?>
                        <i class="fas fa-check-circle"></i>
                        <span><?= $pengajuan['file_berkas']; ?></span>
                        <span class="text-[10px] ml-auto text-green-600 uppercase font-bold">Sudah Upload</span>
                    <?php else: ?>
                        <i class="fas fa-file"></i>
                        <span id="file_name_display">Pilih file...</span>
                    <?php endif; ?>
                </div>
                <p class="text-[10px] text-gray-400 italic"><?= $is_edit ? 'Kosongkan jika tidak ingin mengganti berkas.' : 'Format: JPG, PNG, PDF (Maks. 2MB)'; ?></p>
            </div>

            <div class="pt-4 flex justify-end space-x-4">
                <a href="<?= BASEURL; ?>/layanan" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Batal</a>
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] transition-all duration-200">
                    <?= $is_edit ? 'SIMPAN PERUBAHAN' : 'KIRIM PENGAJUAN'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview nama file berkas
    const fileInput = document.getElementById('file_berkas_input');
    const fileNameDisplay = document.getElementById('file_name_display');
    
    if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                document.getElementById('file_preview').classList.remove('bg-gray-50', 'border-gray-200', 'text-gray-600');
                document.getElementById('file_preview').classList.add('bg-blue-50', 'border-blue-100', 'text-blue-700');
            } else {
                fileNameDisplay.textContent = 'Pilih file...';
                document.getElementById('file_preview').classList.remove('bg-blue-50', 'border-blue-100', 'text-blue-700');
                document.getElementById('file_preview').classList.add('bg-gray-50', 'border-gray-200', 'text-gray-600');
            }
        });
    }
</script>

<?php $this->view('templates/footer', $data); ?>
