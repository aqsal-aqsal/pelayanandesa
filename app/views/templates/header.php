<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - <?= APP_NAME; ?></title>
    <link rel="icon" type="image/png" href="<?= BASEURL; ?>/assets/img/logokabbanjar.png">
    <link rel="apple-touch-icon" href="<?= BASEURL; ?>/assets/img/logokabbanjar.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-gray-900">
    <?php $use_sidebar_layout = isset($_SESSION['user']) && empty($data['public_page']); ?>
    <?php if ($use_sidebar_layout): ?>
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-72 bg-white border-r border-gray-200 flex flex-col fixed h-full z-40 overflow-y-auto">
                <div class="p-6 flex items-center space-x-3 flex-shrink-0">
                    <img src="<?= BASEURL; ?>/assets/img/logokabbanjar.png" alt="Logo Kabupaten Banjar" class="w-8 h-8 object-contain">
                    <span class="font-bold text-slate-800 tracking-tight">Desa Astambul</span>
                </div>

                <nav class="flex-1 px-4 space-y-0.5">
                    <?php 
                        $level = $_SESSION['user']['level'];
                        $current_page = $data['judul'];
                    ?>
                    
                    <?php if ($level == 'masyarakat'): ?>
                        <a href="<?= BASEURL; ?>/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= strpos($current_page, 'Dashboard') !== false ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-th-large w-5"></i>
                            <span>Dashboard Warga</span>
                        </a>
                        <div class="px-4 py-2 mt-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pengajuan Surat</span>
                        </div>
                        <a href="<?= BASEURL; ?>/layanan" class="flex items-center space-x-3 px-4 py-2 rounded-xl <?= $current_page == 'Layanan Surat Online' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition ml-2">
                            <i class="fas fa-circle text-[6px] w-5 text-center"></i>
                            <span>Ajukan surat</span>
                        </a>
                        <div class="px-4 py-2 mt-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pengaduan</span>
                        </div>
                        <a href="<?= BASEURL; ?>/pengaduan" class="flex items-center space-x-3 px-4 py-2 rounded-xl <?= $current_page == 'Pengaduan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition ml-2">
                            <i class="fas fa-circle text-[6px] w-5 text-center"></i>
                            <span>Ajukan Pengaduan</span>
                        </a>
                        <a href="<?= BASEURL; ?>/blt" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= strpos($current_page, 'Bantuan') !== false ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition mt-2">
                            <i class="fas fa-info-circle w-5"></i>
                            <span>Informasi Bantuan</span>
                        </a>
                    <?php elseif ($level == 'kades'): ?>
                        <a href="<?= BASEURL; ?>/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= strpos($current_page, 'Dashboard') !== false ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-chart-pie w-5"></i>
                            <span>Dashboard Kades</span>
                        </a>
                        <a href="<?= BASEURL; ?>/layanan/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Layanan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-file-signature w-5"></i>
                            <span>Daftar Surat</span>
                        </a>
                        <a href="<?= BASEURL; ?>/pengaduan/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Pengaduan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-bullhorn w-5"></i>
                            <span>Daftar Aduan</span>
                        </a>
                        <a href="<?= BASEURL; ?>/warga/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Data Kependudukan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-users w-5"></i>
                            <span>Data Warga</span>
                        </a>
                        <a href="<?= BASEURL; ?>/blt/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Seleksi BLT' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-gift w-5"></i>
                            <span>Program Bantuan</span>
                        </a>
                        <a href="<?= BASEURL; ?>/informasi/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Kelola Informasi' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-newspaper w-5"></i>
                            <span>Informasi Publik</span>
                        </a>
                        <a href="<?= BASEURL; ?>/laporan" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Laporan & Statistik' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-file-pdf w-5"></i>
                            <span>Cetak Laporan</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASEURL; ?>/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= strpos($current_page, 'Dashboard') !== false ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-chart-pie w-5"></i>
                            <span>Dashboard Petugas</span>
                        </a>
                        <a href="<?= BASEURL; ?>/layanan/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Layanan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-tasks w-5"></i>
                            <span>Daftar Surat</span>
                        </a>
                        <a href="<?= BASEURL; ?>/pengaduan/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Pengaduan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-bullhorn w-5"></i>
                            <span>Daftar Aduan</span>
                        </a>
                        <a href="<?= BASEURL; ?>/warga/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Data Kependudukan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-users w-5"></i>
                            <span>Data Warga</span>
                        </a>
                        <a href="<?= BASEURL; ?>/pejabat/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Data Pejabat' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-user-tie w-5"></i>
                            <span>Data Petugas</span>
                        </a>
                        <a href="<?= BASEURL; ?>/blt/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Manajemen Seleksi BLT' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-gift w-5"></i>
                            <span>Program Bantuan</span>
                        </a>
                        <a href="<?= BASEURL; ?>/informasi/admin" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Kelola Informasi' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-newspaper w-5"></i>
                            <span>Informasi Publik</span>
                        </a>
                        <a href="<?= BASEURL; ?>/laporan" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $current_page == 'Laporan & Statistik' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                            <i class="fas fa-file-pdf w-5"></i>
                            <span>Cetak Laporan</span>
                        </a>
                    <?php endif; ?>
                </nav>

                <div class="px-4 py-6 space-y-1 border-t border-gray-100">
                    <a href="<?= BASEURL; ?>/profile" class="flex items-center space-x-3 px-4 py-3 rounded-xl <?= $data['judul'] == 'Pengaturan Profil' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50'; ?> transition">
                        <i class="fas fa-cog w-5"></i>
                        <span>Pengaturan Profil</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                        <i class="fas fa-headset w-5"></i>
                        <span>Bantuan</span>
                    </a>
                </div>

                <div class="p-4 border-t border-gray-100">
                    <div class="flex items-center justify-between px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border-2 border-blue-100">
                                <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['user']['nik']; ?>&background=0284c7&color=fff" alt="User">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 truncate w-24"><?= $_SESSION['user']['nik']; ?></span>
                                <span class="text-xs text-gray-500 capitalize"><?= $level; ?></span>
                            </div>
                        </div>
                        <a href="<?= BASEURL; ?>/auth/logout" class="text-gray-400 hover:text-red-500 transition">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 ml-72 p-10">
                <!-- Breadcrumbs & Title -->
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-slate-900 mb-2"><?= $data['judul']; ?></h1>
                    <nav class="flex text-sm text-gray-400 space-x-2">
                        <i class="fas fa-home pt-1"></i>
                        <i class="fas fa-chevron-right text-[10px] pt-1"></i>
                        <span class="text-blue-600 font-medium">Beranda</span>
                    </nav>
                </div>
    <?php else: ?>
        <!-- Navbar (Hidden on Login Page) -->
        <?php if ($data['judul'] != 'Login' && $data['judul'] != 'Registrasi'): ?>
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-2">
                        <img src="<?= BASEURL; ?>/assets/img/logokabbanjar.png" alt="Logo Kabupaten Banjar" class="w-10 h-10 object-contain">
                        <a href="<?= BASEURL; ?>" class="text-xl font-bold text-slate-800">Desa Astambul Kota</a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#layanan" class="text-gray-600 hover:text-blue-600 font-medium transition">Layanan</a>
                        <a href="<?= BASEURL; ?>/informasi" class="text-gray-600 hover:text-blue-600 font-medium transition">Berita</a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition">Profil Desa</a>
                        <?php if (!isset($_SESSION['user'])): ?>
                            <a href="<?= BASEURL; ?>/auth/register" class="text-gray-600 hover:text-blue-600 font-bold transition">Daftar</a>
                            <a href="<?= BASEURL; ?>/auth" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-slate-800 transition shadow-sm">Masuk</a>
                        <?php else: ?>
                            <a href="<?= BASEURL; ?>/dashboard" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">Dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php endif; ?>
        <main class="<?= ($data['judul'] == 'Login' || $data['judul'] == 'Registrasi') ? '' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8'; ?>">
    <?php endif; ?>
