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

        .program-info { margin-top: 20px; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-radius: 4px; }
        .report-title { text-align: center; font-weight: 800; text-transform: uppercase; font-size: 14pt; color: #0f172a; margin-top: 30px; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9; display: inline-block; padding-bottom: 5px; width: 100%; }
        table.report-table { width: 100%; border-collapse: collapse; margin-top: 10px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        table.report-table th, table.report-table td { padding: 8px 5px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        table.report-table th { background-color: #f8fafc; font-weight: 800; text-transform: uppercase; text-align: center; color: #64748b; font-size: 7pt; letter-spacing: 0.5px; }
        table.report-table td { color: #334155; font-size: 8pt; }
        table.report-table td.center { text-align: center; }
        table.report-table td.rank { font-weight: bold; text-align: center; }
        table.report-table tr:last-child td { border-bottom: none; }

        .calon-section { margin-bottom: 30px; page-break-inside: avoid; }
        .calon-name { font-size: 11pt; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
        .calon-nik { font-size: 9pt; color: #64748b; }

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
        
        // Helper untuk tanggal Indonesia
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

    <?php if (isset($data['program'])): ?>
        <div class="program-info">
            <div style="font-weight: 800;">Program: <?= htmlspecialchars($data['program']['nama_program']); ?></div>
            <div>Periode: <?= htmlspecialchars($data['program']['periode']); ?></div>
            <div>Sumber Dana: <?= htmlspecialchars($data['program']['sumber_dana']); ?></div>
        </div>
    <?php endif; ?>

    <?php foreach($data['hasil'] as $h): ?>
        <div class="calon-section">
            <div class="calon-name">
                Ranking <?= $h['ranking']; ?>: <?= htmlspecialchars($h['nama_lengkap']); ?> 
                <span class="calon-nik"> (NIK: <?= htmlspecialchars($h['nik']); ?>)</span>
            </div>
            
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th width="80">Tipe</th>
                        <th width="80">Bobot</th>
                        <th width="60">Nilai Asli</th>
                        <th width="100">Nilai Normalisasi</th>
                        <th width="100">Nilai Terbobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($h['kriteria'] as $k): ?>
                    <tr>
                        <td><?= htmlspecialchars($k['nama_kriteria']); ?></td>
                        <td class="center"><?= htmlspecialchars($k['tipe']); ?></td>
                        <td class="center"><?= htmlspecialchars($k['bobot']); ?></td>
                        <td class="center"><?= htmlspecialchars($k['nilai_asli']); ?></td>
                        <td class="center"><?= htmlspecialchars($k['nilai_normalisasi']); ?></td>
                        <td class="center"><?= htmlspecialchars($k['nilai_terbobot']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="background: #f8fafc; font-weight: 800;">
                        <td colspan="5" style="text-align: right;">Total Skor SAW:</td>
                        <td class="center"><?= htmlspecialchars($h['nilai_total']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

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