<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $data['judul']; ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #111827; }
        .header { text-align: center; padding-bottom: 12px; border-bottom: 3px solid #111827; }
        .header h1 { margin: 0; font-size: 14px; text-transform: uppercase; }
        .header h2 { margin: 6px 0 0; font-size: 12px; font-weight: normal; }
        .title { text-align: center; margin: 24px 0 10px; }
        .title h3 { margin: 0; font-size: 14px; text-transform: uppercase; }
        .meta { text-align: center; margin-top: 6px; font-size: 11px; }
        .section { margin-top: 18px; line-height: 1.6; }
        .table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        .table td { padding: 4px 0; vertical-align: top; }
        .label { width: 160px; }
        .sign { margin-top: 36px; width: 100%; }
        .sign td { vertical-align: top; }
        .qr { width: 180px; text-align: center; }
        .small { font-size: 10px; color: #6b7280; }
        .name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        .line { height: 1px; background: #e5e7eb; margin: 16px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH DESA ASTAMBUL KOTA</h1>
        <h2>Kecamatan Astambul, Kabupaten Banjar, Kalimantan Selatan</h2>
    </div>

    <div class="title">
        <h3><?= strtoupper($data['surat']['nama_surat']); ?></h3>
        <div class="meta">Nomor: <?= $data['surat']['no_surat']; ?></div>
    </div>

    <div class="section">
        <div>Yang bertanda tangan di bawah ini, Kepala Desa Astambul Kota, menerangkan bahwa:</div>

        <table class="table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>: <?= $data['surat']['nama_lengkap']; ?></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: <?= $data['surat']['nik']; ?></td>
            </tr>
            <tr>
                <td class="label">Tempat/Tanggal Lahir</td>
                <td>: <?= $data['surat']['tempat_lahir']; ?>, <?= $data['surat']['tanggal_lahir']; ?></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: <?= $data['surat']['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: <?= $data['surat']['alamat']; ?><?= $data['surat']['rt_rw'] ? ' (RT/RW ' . $data['surat']['rt_rw'] . ')' : ''; ?></td>
            </tr>
        </table>

        <div class="line"></div>

        <div>Surat ini dibuat untuk keperluan:</div>
        <div style="margin-top: 6px;"><strong><?= $data['surat']['keperluan']; ?></strong></div>

        <div style="margin-top: 16px;">
            Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
        </div>
    </div>

    <table class="sign">
        <tr>
            <td>
                <div class="small">Verifikasi Dokumen</div>
                <div class="small"><?= $data['qr_url']; ?></div>
            </td>
            <td class="qr">
                <?php if($data['qr_data_uri']): ?>
                    <img src="<?= $data['qr_data_uri']; ?>" width="140" height="140">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 55%;">
                <div style="margin-top: 10px;">Astambul Kota, <?= date('d F Y', strtotime($data['surat']['tanggal_selesai'] ?? 'now')); ?></div>
                <div>Kepala Desa Astambul Kota</div>
                <?php if(!empty($data['ttd_data_uri'])): ?>
                    <div style="margin-top: 12px;">
                        <img src="<?= $data['ttd_data_uri']; ?>" width="180">
                    </div>
                <?php endif; ?>
                <div class="name">(<?= $data['surat']['nama_kades'] ?: 'Kepala Desa'; ?>)</div>
            </td>
            <td></td>
        </tr>
    </table>
</body>
</html>
