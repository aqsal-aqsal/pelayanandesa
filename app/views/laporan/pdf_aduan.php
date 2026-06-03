<!DOCTYPE html>
<html>
<head>
    <title><?= $data['judul']; ?></title>
    <style>
        @page { margin: 1.5cm 2cm 1.5cm 2cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #1e293b; line-height: 1.5; }
        .header { width: 100%; position: relative; text-align: center; padding-bottom: 10px; border-bottom: 2px solid #0f172a; }
        .logo-img { position: absolute; left: 0; top: 0; width: 60px; height: auto; }
        .header-text { margin-bottom: 0; }
        .header-text .gov-name { font-weight: 800; font-size: 13pt; color: #0f172a; letter-spacing: 1px; }
        .header-text .district-name { font-weight: 700; font-size: 11pt; color: #334155; }
        .report-title { text-align: center; font-weight: 800; text-transform: uppercase; font-size: 14pt; color: #0f172a; margin-top: 30px; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9; display: inline-block; padding-bottom: 5px; width: 100%; }
        table.report-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #e2e8f0; }
        table.report-table th, table.report-table td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        table.report-table th { background-color: #f8fafc; font-weight: 800; text-transform: uppercase; text-align: center; color: #64748b; font-size: 8pt; }
        table.report-table td { color: #334155; font-size: 9pt; }
        table.report-table td.center { text-align: center; }
        .status-badge { font-weight: 800; text-transform: uppercase; font-size: 7pt; padding: 4px 8px; border-radius: 6px; display: inline-block; background-color: #f1f5f9; color: #475569; }
        .sig-container { width: 100%; margin-top: 40px; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-right { width: 100%; text-align: center; padding-left: 60%; }
        .sig-date { margin-bottom: 5px; color: #64748b; font-weight: 600; }
        .sig-role { margin-bottom: 60px; font-weight: 700; color: #334155; }
        .sig-name { font-weight: 800; color: #0f172a; font-size: 11pt; }
    </style>
</head>
<body>
    <?php
        $rootPath = dirname(__DIR__, 2);
        $logoPath = $rootPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'logokabbanjar.png';
        $logoDataUri = null;
        if (file_exists($logoPath)) {
            $logoDataUri = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
        function tgl_indo($tanggal){
            $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        }
        $tgl_sekarang = tgl_indo(date('Y-m-d'));
    ?>
    <div class="header">
        <?php if ($logoDataUri): ?>
            <img src="<?= $logoDataUri; ?>" class="logo-img" alt="Logo">
        <?php endif; ?>
        <div class="header-text">
            <div class="gov-name">PEMERINTAH DESA ASTAMBUL KOTA</div>
            <div class="district-name">KECAMATAN ASTAMBUL &bull; KAB.BANJAR</div>
        </div>
    </div>
    <div class="report-title"><?= $data['judul']; ?></div>
    <table class="report-table">
        <thead>
            <tr>
                <th width="30">NO</th>
                <th width="80">TANGGAL</th>
                <th>NAMA WARGA</th>
                <th>JUDUL PENGADUAN</th>
                <th>KATEGORI</th>
                <th width="80">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['pengaduan'] as $p): ?>
                <tr>
                    <td class="center"><?= $no++; ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($p['tanggal_aduan'])); ?></td>
                    <td style="font-weight: 700;"><?= htmlspecialchars((string)($p['nama_lengkap'] ?? '')); ?></td>
                    <td><?= htmlspecialchars((string)($p['judul_aduan'] ?? '')); ?></td>
                    <td class="center"><?= htmlspecialchars((string)($p['kategori_aduan'] ?? '')); ?></td>
                    <td class="center"><span class="status-badge"><?= htmlspecialchars((string)($p['status'] ?? '')); ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="sig-container">
        <table class="sig-table">
            <tr>
                <td class="sig-right">
                    <div class="sig-date">Astambul, <?= $tgl_sekarang; ?></div>
                    <div class="sig-role">Kepala Desa Astambul Kota</div>
                    <div class="sig-name">................................</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>