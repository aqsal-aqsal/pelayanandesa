<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $data['judul']; ?></title>
    <style>
        @page { 
            margin: 1.5cm 2cm 1.5cm 2cm; 
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt; 
            color: #1e293b; 
            line-height: 1.6; 
        }
        
        /* Header Style */
        .header { width: 100%; position: relative; text-align: center; padding-bottom: 15px; border-bottom: 2px solid #0f172a; }
        .logo-img { position: absolute; left: 0; top: 0; width: 70px; height: auto; }
        .header-text { margin-bottom: 0; }
        .header-text .gov-name { font-weight: 800; font-size: 14pt; color: #0f172a; letter-spacing: 1px; }
        .header-text .kec-name { font-weight: 700; font-size: 12pt; color: #0f172a; }
        .header-text .desa-name { font-weight: 800; font-size: 12pt; color: #0f172a; }
        .header-text .alamat { font-weight: 500; font-size: 10pt; color: #334155; margin-top: 5px; font-style: italic; }

        /* Title Style */
        .title { text-align: center; margin-top: 30px; margin-bottom: 30px; }
        .title .name { font-weight: 800; text-transform: uppercase; font-size: 14pt; color: #0f172a; border-bottom: 2px solid #0f172a; display: inline-block; padding-bottom: 2px; }
        .title .number { margin-top: 8px; font-weight: 600; color: #64748b; font-size: 10pt; }
        
        /* Content Style */
        .content { margin-top: 20px; color: #334155; }
        .opening { margin-bottom: 20px; }
        
        .fields-table { width: 100%; border-collapse: collapse; margin-left: 15px; margin-bottom: 20px; background-color: #f8fafc; border-radius: 12px; padding: 15px; }
        .fields-table td { padding: 6px 0; vertical-align: top; }
        .f-no { width: 25px; color: #94a3b8; font-weight: bold; }
        .f-label { width: 160px; color: #64748b; font-weight: 600; font-size: 10pt; text-transform: uppercase; }
        .f-colon { width: 15px; color: #cbd5e1; }
        .f-value { color: #1e293b; font-weight: 700; }
        
        .closing { margin-top: 25px; text-align: justify; color: #475569; }
        
        /* Signature Style */
        .sig-container { width: 100%; margin-top: 40px; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-left { width: 40%; vertical-align: bottom; }
        .sig-right { width: 60%; text-align: center; vertical-align: top; }
        
        .sig-date { margin-bottom: 5px; text-align: right; padding-right: 40px; color: #64748b; font-weight: 600; font-size: 10pt; }
        .sig-role { margin-bottom: 5px; font-weight: 600; text-align: right; padding-right: 80px; color: #334155; text-transform: uppercase; font-size: 10pt; }
        .sig-space { height: 90px; position: relative; width: 100%; text-align: right; }
        .sig-img { height: 85px; width: auto; margin-right: 50px; opacity: 0.9; }
        .sig-name-container { text-align: right; padding-right: 30px; }
        .sig-name { font-weight: 800; color: #0f172a; font-size: 12pt; }
    </style>
</head>
<body>
    <?php
        $surat = $data['surat'] ?? [];
        $namaSurat = (string)($surat['nama_surat'] ?? '');
        $noSurat = (string)($surat['no_surat'] ?? '................');
        $jenisKelamin = ($surat['jenis_kelamin'] ?? null) === 'L' ? 'Laki-laki' : 'Perempuan';
        
        function tgl_indo($tanggal){
            $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        }

        $tgl_cetak = tgl_indo(date('Y-m-d', strtotime($surat['tanggal_selesai'] ?? 'now')));
        $alamat = (string)($surat['alamat'] ?? '-');
        $rtRw = trim((string)($surat['rt_rw'] ?? ''));
        if ($rtRw !== '') { $alamat .= ' (RT/RW ' . $rtRw . ')'; }

        $lower = strtolower($namaSurat);
        $jenisKey = 'umum';
        if (strpos($lower, 'domisili') !== false) $jenisKey = 'domisili';
        elseif (strpos($lower, 'izin usaha') !== false) $jenisKey = 'izin_usaha';
        elseif (strpos($lower, 'keterangan usaha') !== false || ($lower === 'surat keterangan usaha')) $jenisKey = 'usaha';
        elseif (strpos($lower, 'tidak mampu') !== false) $jenisKey = 'tidak_mampu';
        elseif (strpos($lower, 'kematian') !== false) $jenisKey = 'kematian';
        elseif (strpos($lower, 'pindah') !== false) $jenisKey = 'pindah';
        elseif (strpos($lower, 'keramaian') !== false) $jenisKey = 'keramaian';

        $judulMap = [
            'domisili' => 'SURAT KETERANGAN DOMISILI',
            'izin_usaha' => 'SURAT KETERANGAN IZIN USAHA',
            'usaha' => 'SURAT KETERANGAN USAHA',
            'tidak_mampu' => 'SURAT KETERANGAN TIDAK MAMPU',
            'kematian' => 'SURAT KETERANGAN KEMATIAN',
            'pindah' => 'SURAT KETERANGAN PINDAH',
            'keramaian' => 'SURAT IZIN KERAMAIAN'
        ];
        $judulSurat = $judulMap[$jenisKey] ?? strtoupper($namaSurat);
        $keperluan = trim((string)($surat['keperluan'] ?? ''));
        
        // Default Fields
        $fields = [
            ['Nama Lengkap', $surat['nama_lengkap'] ?? '-'],
            ['No KTP/NIK', $surat['nik'] ?? '-'],
            ['Jenis Kelamin', $jenisKelamin],
            ['Pekerjaan', $surat['pekerjaan'] ?? '-'],
            ['Status Kawin', str_replace('_', ' ', $surat['status_kawin'] ?? ($surat['status_perkawinan'] ?? '-'))],
            ['Alamat', $alamat]
        ];
        
        $openingText = "Yang bertanda tangan dibawah ini Kepala Desa Astambul Kota, Kecamatan Astambul, Kabupaten Banjar, menerangkan dengan sebenarnya bahwa:";
        $closingText = "Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.";

        // Customize based on type
        if ($jenisKey === 'domisili') {
            $closingText = "Nama tersebut benar-benar penduduk Desa Astambul Kota, Kecamatan Astambul, Kabupaten Banjar, dan sudah tinggal dilingkungan lebih dari 6 bulan. " . $closingText;
        } elseif ($jenisKey === 'kematian') {
            $judulSurat = "SURAT KETERANGAN KEMATIAN";
            $openingText = "Kepala Desa Astambul Kota, Kecamatan Astambul, Kabupaten Banjar menerangkan bahwa:";
            $closingText = "Demikian surat keterangan kematian ini dibuat untuk dapat dipergunakan sebagaimana mestinya.";
            // You might want to add death-specific fields if they exist in database, 
            // for now we use the general ones but adjust the closing.
        } elseif ($jenisKey === 'pindah') {
            $openingText = "Menerangkan bahwa yang bersangkutan mengajukan permohonan pindah dengan data sebagai berikut:";
            $closingText = "Demikian surat keterangan pindah ini diberikan untuk dapat dipergunakan sebagaimana mestinya.";
        } elseif ($jenisKey === 'keramaian') {
            $openingText = "Kepala Desa Astambul Kota memberikan izin keramaian kepada:";
            $closingText = "Demikian surat izin keramaian ini dibuat untuk dipergunakan sesuai dengan ketentuan yang berlaku.";
        } elseif ($jenisKey === 'tidak_mampu') {
            $closingText = "Berdasarkan data yang ada pada kami, yang bersangkutan benar-benar berasal dari keluarga ekonomi lemah/tidak mampu. " . $closingText;
        } elseif ($jenisKey === 'izin_usaha' || $jenisKey === 'usaha') {
            $closingText = "Nama tersebut di atas benar memiliki usaha yang berlokasi di wilayah Desa Astambul Kota. " . $closingText;
        }

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

    <div class="title">
        <div class="name"><?= $judulSurat; ?></div>
        <div class="number">NOMOR: <?= $noSurat; ?></div>
    </div>

    <div class="content">
        <div class="opening">
            <?= $openingText; ?>
        </div>

        <table class="fields-table">
            <?php foreach ($fields as $index => $field): ?>
            <tr>
                <td class="f-no"><?= $index + 1; ?>.</td>
                <td class="f-label"><?= $field[0]; ?></td>
                <td class="f-colon">:</td>
                <td class="f-value"><?= htmlspecialchars((string)$field[1]); ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if (!empty($keperluan) && $jenisKey === 'umum'): ?>
            <tr>
                <td class="f-no"><?= count($fields) + 1; ?>.</td>
                <td class="f-label">Keperluan</td>
                <td class="f-colon">:</td>
                <td class="f-value"><?= htmlspecialchars($keperluan); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if (!empty($keperluan) && $jenisKey !== 'umum'): ?>
        <div style="margin-bottom: 20px;">
            <strong>Maksud/Tujuan:</strong><br>
            <?= htmlspecialchars($keperluan); ?>
        </div>
        <?php endif; ?>

        <div class="closing">
            <?= $closingText; ?>
        </div>
    </div>

    <div class="sig-container">
        <table class="sig-table">
            <tr>
                <td class="sig-left">
                </td>
                <td class="sig-right">
                    <div class="sig-date">Astambul, <?= $tgl_cetak; ?></div>
                    <div class="sig-role">Kepala Desa</div>
                    <div class="sig-space">
                        <?php if (!empty($data['ttd_data_uri'])): ?>
                            <img src="<?= $data['ttd_data_uri']; ?>" class="sig-img" alt="TTD">
                        <?php endif; ?>
                    </div>
                    <div class="sig-name-container">
                        <span class="sig-name"><?= htmlspecialchars($surat['nama_kades'] ?: '................................'); ?></span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
