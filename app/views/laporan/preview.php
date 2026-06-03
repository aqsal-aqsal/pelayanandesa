<?php $this->view('templates/header', $data); ?>

<div class="space-y-8">
    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= BASEURL; ?>/laporan" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Preview Laporan</h2>
            </div>
            <p class="text-gray-500 font-medium ml-13 italic">Menampilkan data sementara sebelum dicetak ke PDF.</p>
        </div>
        
        <form action="<?= BASEURL; ?>/laporan/cetak" method="POST" target="_blank">
            <input type="hidden" name="jenis_laporan" value="<?= $data['jenis']; ?>">
            <input type="hidden" name="tgl_mulai" value="<?= $data['tgl_mulai']; ?>">
            <input type="hidden" name="tgl_selesai" value="<?= $data['tgl_selesai']; ?>">
            <input type="hidden" name="status_surat" value="<?= $data['status_surat']; ?>">
            <input type="hidden" name="id_jenis_surat" value="<?= $data['id_jenis_surat']; ?>">
            
            <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100">
                <i class="fas fa-file-pdf mr-2 text-lg"></i> CETAK KE PDF
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Data Terfilter: <?= count($data['list']); ?> Entri Ditemukan</span>
            <div class="flex gap-4 text-xs font-bold text-slate-500">
                <span>Jenis: <span class="text-blue-600"><?= strtoupper($data['jenis']); ?></span></span>
                <?php if($data['tgl_mulai']): ?>
                    <span>Periode: <span class="text-blue-600"><?= $data['tgl_mulai']; ?> s/d <?= $data['tgl_selesai']; ?></span></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">No</th>
                        <?php if($data['jenis'] == 'surat'): ?>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Warga</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <?php elseif($data['jenis'] == 'aduan'): ?>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pelapor</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul Aduan</th>
                        <?php elseif($data['jenis'] == 'warga'): ?>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIK</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Alamat</th>
                        <?php elseif($data['jenis'] == 'penerima'): ?>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Penerima</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Program</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($data['list'])): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic font-medium bg-white">Tidak ada data yang sesuai dengan filter.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($data['list'] as $item): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5 text-sm text-gray-400"><?= $no++; ?></td>
                                <?php if($data['jenis'] == 'surat'): ?>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-700"><?= $item['nama_lengkap']; ?></td>
                                    <td class="px-8 py-5 text-sm text-slate-600"><?= $item['nama_surat']; ?></td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 text-[10px] font-black rounded-lg border uppercase tracking-widest bg-blue-50 text-blue-600 border-blue-100"><?= $item['status']; ?></span>
                                    </td>
                                <?php elseif($data['jenis'] == 'aduan'): ?>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-700"><?= $item['nama_lengkap']; ?></td>
                                    <td class="px-8 py-5 text-sm text-slate-600"><?= $item['judul_aduan']; ?></td>
                                <?php elseif($data['jenis'] == 'warga'): ?>
                                    <td class="px-8 py-5 text-sm font-mono text-slate-700"><?= $item['nik']; ?></td>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-700"><?= $item['nama_lengkap']; ?></td>
                                    <td class="px-8 py-5 text-sm text-slate-500"><?= $item['alamat']; ?></td>
                                <?php elseif($data['jenis'] == 'penerima'): ?>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-700"><?= $item['nama_lengkap']; ?></td>
                                    <td class="px-8 py-5 text-sm text-slate-600"><?= $item['nama_program']; ?> (<?= $item['periode']; ?>)</td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->view('templates/footer', $data); ?>