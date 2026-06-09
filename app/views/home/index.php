<?php $this->view('templates/header', $data); ?>

<!-- Hero Section -->
<section class="py-12 lg:py-20 flex flex-col lg:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">

        <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight">
            APLIKASI PELAYANAN DESA DAN PENERIMA BLT<br> <span class="text-blue-600">PADA DESA ASTAMBUL KOTA</span>
        </h1>
        <p class="text-lg text-gray-600 leading-relaxed max-w-xl">
            Akses layanan publik lebih cepat, transparan, dan efisien dari mana saja. Komitmen kami untuk kemudahan hidup warga Desa Astambul Kota.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="<?= BASEURL; ?>/layanan" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold flex items-center hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Lihat Layanan <i class="fas fa-arrow-right ml-3"></i>
            </a>
            <a href="#" class="bg-white text-slate-800 px-8 py-4 rounded-xl font-bold border-2 border-slate-100 hover:border-slate-200 transition">
                Profil Desa
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-500 rounded-2xl -z-10 opacity-20 animate-pulse"></div>
        <div class="rounded-3xl overflow-hidden shadow-2xl transform hover:scale-[1.02] transition duration-500">
            <img src="<?= BASEURL; ?>/assets/img/astambulkota.jpeg" alt="Astambul Kota" class="w-full h-[500px] object-cover">
            <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Layanan Mandiri 24/7</h4>
                        <p class="text-sm text-gray-600">Urus dokumen kependudukan kapan saja tanpa antre.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Desa Section -->
<section id="layanan" class="py-20 border-t border-gray-50">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Layanan Desa</h2>
        <p class="text-gray-500 max-w-2xl mx-auto">
            Satu portal untuk semua kebutuhan warga. Cepat, tepat, dan tanpa biaya tambahan.
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Card 1 -->
        <div class="group bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fas fa-id-card"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Administrasi Kependudukan</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                Pengurusan KTP, Kartu Keluarga, dan surat keterangan secara daring.
            </p>
            <a href="<?= BASEURL; ?>/layanan" class="text-blue-600 font-bold text-sm flex items-center hover:gap-2 transition-all">
                Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <!-- Card 2 -->
        <div class="group bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fas fa-heartbeat"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Layanan Kesehatan</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                Pendaftaran Puskesmas pembantu, cek status stunting, dan info ambulans.
            </p>
            <a href="#" class="text-blue-600 font-bold text-sm flex items-center hover:gap-2 transition-all">
                Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <!-- Card 3 -->
        <div class="group bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Pendidikan & Pelatihan</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                Akses beasiswa desa, pendaftaran PAUD, dan pelatihan UMKM digital.
            </p>
            <a href="#" class="text-blue-600 font-bold text-sm flex items-center hover:gap-2 transition-all">
                Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        <!-- Card 4 -->
        <div class="group bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fas fa-store"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Pasar Desa Digital</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                E-commerce lokal untuk mempromosikan produk unggulan warga desa.
            </p>
            <a href="#" class="text-blue-600 font-bold text-sm flex items-center hover:gap-2 transition-all">
                Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </div>
</section>

<!-- Kabar Terbaru Section -->
<section id="berita" class="py-20 border-t border-gray-50">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Kabar Terbaru Desa</h2>
            <p class="text-gray-500">Ikuti perkembangan dan kegiatan di lingkungan kita.</p>
        </div>
        <a href="<?= BASEURL; ?>/informasi" class="text-blue-600 font-bold hover:underline">Lihat Semua Berita</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if (empty($data['berita'])): ?>
            <div class="col-span-full bg-white p-12 rounded-2xl border border-slate-100 text-center text-gray-500 italic">
                Belum ada berita yang dipublikasikan.
            </div>
        <?php else: ?>
            <?php foreach ($data['berita'] as $b): ?>
                <?php
                    $excerpt = trim(strip_tags($b['konten'] ?? ''));
                    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                        if (mb_strlen($excerpt) > 140) {
                            $excerpt = mb_substr($excerpt, 0, 140) . '...';
                        }
                    } else {
                        if (strlen($excerpt) > 140) {
                            $excerpt = substr($excerpt, 0, 140) . '...';
                        }
                    }
                ?>
                <a href="<?= BASEURL; ?>/informasi/detail/<?= (int)$b['id_informasi']; ?>" class="group block bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-xs font-bold text-gray-400"><?= $b['tgl_publikasi'] ? date('d M Y', strtotime($b['tgl_publikasi'])) : '-'; ?></span>
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded uppercase">Berita</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition mb-3"><?= htmlspecialchars($b['judul']); ?></h3>
                    <p class="text-gray-500 text-sm"><?= htmlspecialchars($excerpt); ?></p>
                    <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600"><?= htmlspecialchars($b['nama_petugas'] ?? '-'); ?></span>
                        <span class="text-blue-600 font-black text-[10px] uppercase tracking-widest">Baca</span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<?php $this->view('templates/footer', $data); ?>
