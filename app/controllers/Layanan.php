<?php

class Layanan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Layanan Surat Online';
        $suratModel = $this->model('SuratModel');
        $data['jenis_surat'] = $suratModel->getJenisSurat();
        
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);
        
        $this->view('layanan/index', $data);
    }

    public function ajukan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $suratModel = $this->model('SuratModel');
            
            // Priority Calculation Logic
            $id_jenis = $_POST['id_jenis_surat'];
            $urgensi = (int)$_POST['urgensi']; // 1: Normal, 2: Mendesak, 3: Sangat Mendesak
            
            // Get base priority from jenis_surat
            $this->db = new Database;
            $this->db->query('SELECT prioritas FROM jenis_surat WHERE id_jenis_surat = :id');
            $this->db->bind('id', $id_jenis);
            $base_priority = $this->db->single()['prioritas'] ?? 1;

            $total_priority = $base_priority * $urgensi;

            $data = [
                'id_warga' => $_POST['id_warga'],
                'id_jenis_surat' => $id_jenis,
                'keperluan' => $_POST['keperluan'],
                'nilai_prioritas' => $urgensi,
                'prioritas' => $total_priority,
                'file_berkas' => $this->uploadFile('file_berkas')
            ];

            if ($suratModel->ajukanSurat($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Permohonan berhasil dikirim!'];
                header('Location: ' . BASEURL . '/dashboard/warga');
                exit;
            }
        }
    }

    private function uploadFile($name) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0) {
            $filename = time() . '_' . $_FILES[$name]['name'];
            $destination = 'assets/uploads/' . $filename;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $destination)) {
                return $filename;
            }
        }
        return null;
    }

    public function admin() {
        if ($_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Manajemen Layanan';
        $suratModel = $this->model('SuratModel');
        $data['pengajuan'] = $suratModel->getAllPengajuan();
        $this->view('layanan/admin', $data);
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $suratModel = $this->model('SuratModel');
            $id = $_POST['id_pengajuan'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? null;
            $user_id = $_SESSION['user']['id_user'];
            $level = $_SESSION['user']['level'];

            if ($status == 'selesai' && $level != 'kades') {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Hanya Kepala Desa yang dapat menandatangani surat (status selesai).'];
                header('Location: ' . BASEURL . '/layanan/admin');
                exit;
            }

            if ($level == 'kades' && $status == 'selesai') {
                // Kades signing the document
                if ($suratModel->kadesTandaTangan($id, $user_id)) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Surat berhasil ditandatangani dan selesai!'];
                }
            } else {
                // Petugas updating status
                if ($suratModel->updateStatus($id, $status, $catatan, $user_id)) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Status pengajuan berhasil diperbarui!'];
                    
                    if ($status == 'diproses') {
                        $surat = $suratModel->getPengajuanById($id);
                        if ($surat) {
                            if (!$surat['no_surat']) {
                                $bulan = date('m', strtotime($surat['tanggal_verif'] ?? 'now'));
                                $tahun = date('Y', strtotime($surat['tanggal_verif'] ?? 'now'));
                                $kode = $surat['kode_surat'] ?: 'SK';
                                $no = $kode . '/' . $surat['id_pengajuan'] . '/' . $bulan . '/' . $tahun;
                                $suratModel->setNoSurat($surat['id_pengajuan'], $no);
                            }

                            if (!$surat['qr_token']) {
                                $token = bin2hex(random_bytes(16));
                                $url = BASEURL . '/verify/' . $token;
                                $suratModel->setQr($surat['id_pengajuan'], $token, $url);
                            }
                        }
                    }
                }
            }
            
            header('Location: ' . BASEURL . '/layanan/admin');
            exit;
        }
    }

    public function unduh($id) {
        $suratModel = $this->model('SuratModel');
        $surat = $suratModel->getPengajuanById($id);

        if (!$surat || $surat['status'] != 'selesai') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        if ($_SESSION['user']['level'] == 'masyarakat') {
            $warga = $this->model('WargaModel')->getWargaByNik($_SESSION['user']['nik']);
            if (!$warga || (int)$warga['id_warga'] !== (int)$surat['id_warga']) {
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            }
        }

        if (!$surat['no_surat']) {
            $bulan = date('m', strtotime($surat['tanggal_selesai'] ?? 'now'));
            $tahun = date('Y', strtotime($surat['tanggal_selesai'] ?? 'now'));
            $kode = $surat['kode_surat'] ?: 'SK';
            $no = $kode . '/' . $surat['id_pengajuan'] . '/' . $bulan . '/' . $tahun;
            $suratModel->setNoSurat($surat['id_pengajuan'], $no);
            $surat['no_surat'] = $no;
        }

        if (!$surat['qr_token']) {
            $token = bin2hex(random_bytes(16));
            $url = BASEURL . '/verify/' . $token;
            $suratModel->setQr($surat['id_pengajuan'], $token, $url);
            $surat['qr_token'] = $token;
            $surat['qr_url'] = $url;
        }

        $qrUrl = $surat['qr_url'] ?: (BASEURL . '/verify/' . $surat['qr_token']);
        $qrDataUri = null;
        if (class_exists('\\Endroid\\QrCode\\Writer\\PngWriter') && class_exists('\\Endroid\\QrCode\\QrCode')) {
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write(\Endroid\QrCode\QrCode::create($qrUrl)->setSize(180));
            $qrDataUri = 'data:image/png;base64,' . base64_encode($result->getString());
        } else {
            $qrDataUri = 'https://chart.googleapis.com/chart?cht=qr&chs=180x180&chl=' . urlencode($qrUrl);
        }

        $ttdDataUri = null;
        if (!empty($surat['ttd_kades'])) {
            $rootPath = dirname(__DIR__, 2);
            $ttdPath = $rootPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $surat['ttd_kades'];
            if (file_exists($ttdPath)) {
                $ext = strtolower(pathinfo($ttdPath, PATHINFO_EXTENSION));
                $mime = $ext == 'png' ? 'image/png' : ($ext == 'jpg' || $ext == 'jpeg' ? 'image/jpeg' : null);
                if ($mime) {
                    $ttdDataUri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($ttdPath));
                }
            }
        }

        $data = [
            'judul' => $surat['nama_surat'],
            'surat' => $surat,
            'qr_data_uri' => $qrDataUri,
            'qr_url' => $qrUrl,
            'ttd_data_uri' => $ttdDataUri
        ];

        if (class_exists('\\Dompdf\\Dompdf')) {
            ob_start();
            $this->view('surat/pdf', $data);
            $html = ob_get_clean();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $filename = str_replace(' ', '_', $surat['nama_surat']) . '_' . $surat['no_surat'] . '.pdf';
            $dompdf->stream($filename, ["Attachment" => false]);
            return;
        }

        $this->view('surat/pdf', $data);
    }

    public function jenis() {
        if ($_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Manajemen Jenis Surat';
        $data['jenis'] = $this->model('SuratModel')->getJenisSurat();
        $this->view('layanan/jenis', $data);
    }

    public function seed_jenis() {
        if ($_SESSION['user']['level'] != 'petugas') exit;
        
        $suratModel = $this->model('SuratModel');
        $default_types = [
            ['nama_surat' => 'Surat Keterangan Domisili', 'prioritas' => 5],
            ['nama_surat' => 'Surat Keterangan Izin Usaha', 'prioritas' => 3],
            ['nama_surat' => 'Surat Keterangan Usaha', 'prioritas' => 3],
            ['nama_surat' => 'Surat Keterangan Tidak Mampu', 'prioritas' => 5],
            ['nama_surat' => 'Surat Keterangan Kematian', 'prioritas' => 5],
            ['nama_surat' => 'Surat Keterangan Pindah', 'prioritas' => 4],
            ['nama_surat' => 'Surat Izin Keramaian', 'prioritas' => 2]
        ];

        foreach ($default_types as $type) {
            $suratModel->addJenisSurat($type);
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jenis surat standar berhasil ditambahkan!'];
        header('Location: ' . BASEURL . '/layanan/jenis');
        exit;
    }

    public function tambah_jenis() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('SuratModel')->addJenisSurat($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jenis surat berhasil ditambahkan!'];
            }
            header('Location: ' . BASEURL . '/layanan/jenis');
            exit;
        }
    }

    public function edit_jenis() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('SuratModel')->updateJenisSurat($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jenis surat berhasil diperbarui!'];
            }
            header('Location: ' . BASEURL . '/layanan/jenis');
            exit;
        }
    }

    public function hapus_jenis($id) {
        if ($this->model('SuratModel')->deleteJenisSurat($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jenis surat berhasil dihapus!'];
        }
        header('Location: ' . BASEURL . '/layanan/jenis');
        exit;
    }

    public function hapus_pengajuan($id) {
        if ($this->model('SuratModel')->deletePengajuan($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengajuan berhasil dibatalkan!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal membatalkan pengajuan. Hanya pengajuan dengan status menunggu yang dapat dihapus.'];
        }
        header('Location: ' . BASEURL . '/dashboard/warga');
        exit;
    }
}
