<?php $this->view('templates/header', $data); ?>

<?php
    $is_edit = isset($data['aduan_edit']);
    $aduan = $data['aduan_edit'] ?? null;
?>

<div class="space-y-8 max-w-4xl mx-auto">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-2"><?= $is_edit ? 'Edit Pengaduan' : 'Buat Pengaduan'; ?></h2>
            <p class="text-gray-500">Sampaikan keluhan atau aspirasi Anda secara aman dan cepat.</p>
        </div>
        <a href="<?= BASEURL; ?>/pengaduan" class="px-6 py-3 bg-gray-50 text-gray-600 rounded-2xl font-bold text-sm hover:bg-gray-100 transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-10 py-8">
            <h3 class="text-2xl font-black text-white"><?= $is_edit ? 'Perbarui Pengaduan' : 'Kirim Pengaduan Masyarakat'; ?></h3>
            <p class="text-blue-100 text-sm mt-1">Lengkapi data dengan jelas agar cepat ditindaklanjuti.</p>
        </div>
        
        <form action="<?= BASEURL; ?>/pengaduan/<?= $is_edit ? 'update' : 'kirim'; ?>" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            <input type="hidden" name="id_warga" value="<?= $data['warga']['id_warga']; ?>">
            <?php if($is_edit): ?>
                <input type="hidden" name="id_pengaduan" value="<?= $aduan['id_pengaduan']; ?>">
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Laporan</label>
                    <input type="text" name="judul_aduan" required value="<?= $is_edit ? $aduan['judul_aduan'] : ''; ?>" class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Apa yang ingin Anda laporkan?">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</label>
                    <?php $kat = $is_edit ? $aduan['kategori_aduan'] : 'pelayanan'; ?>
                    <select name="kategori_aduan" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="pelayanan" <?= $kat === 'pelayanan' ? 'selected' : ''; ?>>Pelayanan Publik</option>
                        <option value="infrastruktur" <?= $kat === 'infrastruktur' ? 'selected' : ''; ?>>Infrastruktur (Jalan/Jembatan)</option>
                        <option value="keamanan" <?= $kat === 'keamanan' ? 'selected' : ''; ?>>Keamanan Lingkungan</option>
                        <option value="sosial" <?= $kat === 'sosial' ? 'selected' : ''; ?>>Sosial & Bantuan</option>
                        <option value="lingkungan" <?= $kat === 'lingkungan' ? 'selected' : ''; ?>>Kebersihan & Lingkungan</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Isi Laporan / Detail Pengaduan</label>
                <textarea name="isi_aduan" rows="5" required class="block w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Ceritakan detail kejadian atau keluhan Anda secara lengkap..."><?= $is_edit ? $aduan['isi_aduan'] : ''; ?></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Lampiran Bukti (Foto/Dokumen)</label>
                <div class="relative group">
                    <input type="file" name="file_bukti" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="px-5 py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl flex items-center justify-center space-x-3 group-hover:bg-blue-50 group-hover:border-blue-200 transition">
                        <i class="fas fa-cloud-upload-alt text-gray-400 group-hover:text-blue-500"></i>
                        <span class="text-sm text-gray-500 group-hover:text-blue-600 font-medium">Klik untuk upload file bukti</span>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 italic"><?= $is_edit ? 'Kosongkan jika tidak ingin mengganti lampiran.' : 'Maksimal ukuran file 2MB (JPG, PNG, PDF)'; ?></p>
            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="<?= BASEURL; ?>/pengaduan" class="px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Batal</a>
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] transition-all duration-200">
                    <?= $is_edit ? 'SIMPAN PERUBAHAN' : 'KIRIM PENGADUAN SEKARANG'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>
