<!DOCTYPE html>
<html>
<head>
    <title><?= $data['judul']; ?></title>
    <style>
        @page { 
            margin: 1.5cm 2cm 1.5cm 2cm; 
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt; 
            color: #1e293b; 
            line-height: 1.5; 
        }
        
        /* Header Style */
        .header { width: 100%; position: relative; text-align: center; padding-bottom: 15px; border-bottom: 2px solid #0f172a; }
        .logo-img { position: absolute; left: 0; top: 0; width: 70px; height: auto; }
        .header-text { margin-bottom: 0; }
        .header-text .gov-name { font-weight: 800; font-size: 14pt; color: #0f172a; letter-spacing: 1px; }
        .header-text .kec-name { font-weight: 700; font-size: 12pt; color: #0f172a; }
        .header-text .desa-name { font-weight: 800; font-size: 12pt; color: #0f172a; }
        .header-text .alamat { font-weight: 500; font-size: 10pt; color: #334155; margin-top: 5px; font-style: italic; }

        .report-title { text-align: center; font-weight: 800; text-transform: uppercase; font-size: 14pt; color: #0f172a; margin-top: 30px; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9; display: inline-block; padding-bottom: 5px; width: 100%; }

        table.report-table { width: 100%; border-collapse: collapse; margin-top: 10px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        table.report-table th, table.report-table td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        table.report-table th { background-color: #f8fafc; font-weight: 800; text-transform: uppercase; text-align: center; color: #64748b; font-size: 8pt; letter-spacing: 0.5px; }
        table.report-table td { color: #334155; font-size: 9pt; }
        table.report-table td.center { text-align: center; }
        table.report-table tr:last-child td { border-bottom: none; }

        .status-badge { font-weight: 800; text-transform: uppercase; font-size: 7pt; padding: 4px 8px; border-radius: 6px; display: inline-block; background-color: #f1f5f9; color: #475569; }
        
        .sig-container { width: 100%; margin-top: 40px; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-right { width: 100%; text-align: center; vertical-align: top; padding-left: 60%; }
        
        .sig-date { margin-bottom: 5px; color: #64748b; font-weight: 600; }
        .sig-role { margin-bottom: 60px; font-weight: 700; color: #334155; }
        .sig-name { font-weight: 800; color: #0f172a; font-size: 11pt; }
    </style>
</head>
<body>
    <?php
        // Path logo ABSOLUT di server
        $serverLogoPath = 'c:/laragon/www/pelayanandesa/public/assets/img/logokabbanjar.png';
        
        // Baca file dan encode ke base64
        $logoBase64 = '';
        if (file_exists($serverLogoPath)) {
            $logoContent = file_get_contents($serverLogoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
        } else {
            // Fallback: placeholder biru jika file tidak ada
            $logoBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAdgAAAHYBTnsmCAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPAAAAAASUVORK5CYII=';
        }
        
        // Fungsi tgl_indo harus sebelum dipanggil!
        function tgl_indo($tanggal){
            $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        }
        
        $tgl_sekarang = tgl_indo(date('Y-m-d'));
    ?>
    <div class="header">
        <img src="<?= $logoBase64; ?>" class="logo-img" alt="Logo">
        <div class="header-text">
            <div class="gov-name">PEMERINTAH KABUPATEN BANJAR</div>
            <div class="kec-name">KECAMATAN ASTAMBUL</div>
            <div class="desa-name">DESA ASTAMBUL KOTA</div>
            <div class="alamat">Alamat: Jl. Syekh Muhammad Arsyad Al-Banjari Astambul Kota RT.04/RW.01</div>
        </div>
    </div>

    <div class="report-title"><?= $data['judul']; ?></div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="30">NO</th>
                <th width="80">TANGGAL</th>
                <th>NAMA WARGA</th>
                <th>JENIS SURAT</th>
                <th width="70">SKOR</th>
                <th width="80">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['pengajuan'] as $p): ?>
                <tr>
                    <td class="center" style="font-weight: bold; color: #94a3b8;"><?= $no++; ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($p['tanggal_pengajuan'])); ?></td>
                    <td style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars((string)($p['nama_lengkap'] ?? '')); ?></td>
                    <td><?= htmlspecialchars((string)($p['nama_surat'] ?? '')); ?></td>
                    <td class="center" style="font-weight: 600;"><?= $p['prioritas'] ?? 0; ?></td>
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
