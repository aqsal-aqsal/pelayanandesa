    </main>
    
    <?php $use_sidebar_layout = isset($_SESSION['user']) && empty($data['public_page']); ?>
    <?php if (!$use_sidebar_layout): ?>
        <?php if ($data['judul'] == 'Login' && $data['judul'] == 'Registrasi'): ?>
        <footer class="bg-gray-50 border-t border-gray-100 pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="col-span-1 md:col-span-2 space-y-6">
                        <div class="flex items-center space-x-2">
                            <img src="<?= BASEURL; ?>/assets/img/logokabbanjar.png" alt="Logo Kabupaten Banjar" class="w-8 h-8 object-contain">
                            <span class="text-xl font-bold text-slate-800">Desa Astambul Kota</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                            Jl. Jenderal Sudirman No. 45, Astambul, Kalimantan Selatan. Melayani dengan hati, membangun dengan teknologi.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-400 hover:text-blue-600 hover:border-blue-600 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-400 hover:text-pink-600 hover:border-pink-600 transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-400 hover:text-green-600 hover:border-green-600 transition">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Navigasi</h4>
                        <ul class="space-y-4 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-blue-600 transition">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Hubungi Kami</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Peta Situs</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-slate-900 mb-6 uppercase text-xs tracking-widest">Lainnya</h4>
                        <ul class="space-y-4 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-blue-600 transition">Portal PPID</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Open Data</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Lapor!</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-8 text-center">
                    <p class="text-xs text-gray-400 font-medium">
                        &copy; 2026 Pemerintah Desa Astambul Kota. Mewujudkan Tata Kelola Digital yang Transparan dan Melayani.
                    </p>
                </div>
            </div>
        </footer>
        <?php endif; ?>
    <?php else: ?>
        </div> <!-- End of flex container from header -->
    <?php endif; ?>


    <script src="<?= BASEURL; ?>/assets/js/main.js"></script>
</body>
</html>
