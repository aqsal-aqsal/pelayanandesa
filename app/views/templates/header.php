<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - <?= APP_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Navbar (Hidden on Login Page) -->
    <?php if ($data['judul'] != 'Login'): ?>
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= BASEURL; ?>" class="text-xl font-bold">Desa Astambul Kota</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="<?= BASEURL; ?>" class="hover:bg-blue-700 px-3 py-2 rounded-md">Beranda</a>
                    <a href="<?= BASEURL; ?>/layanan" class="hover:bg-blue-700 px-3 py-2 rounded-md">Layanan</a>
                    <a href="<?= BASEURL; ?>/pengaduan" class="hover:bg-blue-700 px-3 py-2 rounded-md">Pengaduan</a>
                    <a href="<?= BASEURL; ?>/blt" class="hover:bg-blue-700 px-3 py-2 rounded-md">BLT (SAW)</a>
                    <a href="<?= BASEURL; ?>/auth" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold hover:bg-gray-100 transition">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <main class="<?= $data['judul'] == 'Login' ? '' : 'max-w-7xl mx-auto py-6 sm:px-6 lg:px-8'; ?>">

