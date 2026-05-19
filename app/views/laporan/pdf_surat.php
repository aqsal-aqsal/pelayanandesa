<!DOCTYPE html>
<html>
<head>
    <title><?= $data['judul']; ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .status { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { margin-top: 50px; text-align: right; }
        .footer-space { height: 100px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pemerintah Desa Astambul Kota</h2>
        <p>Kecamatan Astambul, Kabupaten Banjar, Kalimantan Selatan</p>
        <h3><?= $data['judul']; ?></h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>Jenis Surat</th>
                <th>Prioritas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['pengajuan'] as $p): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d/m/Y', strtotime($p['tanggal_pengajuan'])); ?></td>
                    <td><?= $p['nama_lengkap']; ?></td>
                    <td><?= $p['nama_surat']; ?></td>
                    <td><?= $p['prioritas']; ?></td>
                    <td class="status"><?= $p['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Astambul Kota, <?= date('d F Y'); ?></p>
        <p>Kepala Desa Astambul Kota,</p>
        <div class="footer-space"></div>
        <p><strong>( __________________________ )</strong></p>
    </div>
</body>
</html>
