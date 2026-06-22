<?php

class Layanan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/layanan/admin');
            exit;
        }

        $data['judul'] = 'Layanan Surat Online';
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $suratModel = $this->model('SuratModel');
        $data['jenis_surat'] = $suratModel->getJenisSurat();
        $data['pengajuan'] = $suratModel->getPengajuanByWarga($data['warga']['id_warga']);

        $this->view('layanan/index', $data);
    }

    public function buat() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/layanan/admin');
            exit;
        }

        $data['judul'] = 'Ajukan Surat';
        $suratModel = $this->model('SuratModel');
        $data['jenis_surat'] = $suratModel->getJenisSurat();

        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $this->view('layanan/form', $data);
    }

    public function edit($id) {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/layanan/admin');
            exit;
        }

        $suratModel = $this->model('SuratModel');
        $pengajuan = $suratModel->getPengajuanById($id);

        $wargaModel = $this->model('WargaModel');
        $warga = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        if (!$pengajuan || !$warga || (int)$pengajuan['id_warga'] !== (int)$warga['id_warga'] || $pengajuan['status'] != 'menunggu') {
            header('Location: ' . BASEURL . '/layanan');
            exit;
        }

        $data['judul'] = 'Edit Pengajuan Surat';
        $data['jenis_surat'] = $suratModel->getJenisSurat();
        $data['warga'] = $warga;
        $data['pengajuan_edit'] = $pengajuan;
        $this->view('layanan/form', $data);
    }

    public function update() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $suratModel = $this->model('SuratModel');

            $id_pengajuan = $_POST['id_pengajuan'];
            $id_jenis = $_POST['id_jenis_surat'];

            $wargaModel = $this->model('WargaModel');
            $warga = $wargaModel->getWargaByNik($_SESSION['user']['nik']);      

            $pengajuan = $suratModel->getPengajuanById($id_pengajuan);
            if (!$pengajuan || !$warga || (int)$pengajuan['id_warga'] !== (int)$warga['id_warga'] || $pengajuan['status'] != 'menunggu') {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pengajuan tidak dapat diedit.'];
                header('Location: ' . BASEURL . '/layanan');
                exit;
            }

            $this->db = new Database;
            $this->db->query('SELECT prioritas FROM jenis_surat WHERE id_jenis_surat = :id');
            $this->db->bind('id', $id_jenis);
            $total_priority = $this->db->single()['prioritas'] ?? 1;

            $file = $this->uploadFile('file_berkas');
            $payload = [
                'id_pengajuan' => $id_pengajuan,
                'id_warga' => $warga['id_warga'],
                'id_jenis_surat' => $id_jenis,
                'keperluan' => $_POST['keperluan'],
                'nilai_prioritas' => 1,
                'prioritas' => $total_priority,
                'file_berkas' => $file
            ];

            if ($suratModel->updatePengajuan($payload)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengajuan berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui pengajuan.'];
            }

            header('Location: ' . BASEURL . '/layanan');
            exit;
        }
    }

    public function ajukan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_SESSION['user']['level'] != 'masyarakat') {
                header('Location: ' . BASEURL . '/layanan/admin');
                exit;
            }

            // Validasi file upload wajib
            if (!isset($_FILES['file_berkas']) || $_FILES['file_berkas']['error'] != 0) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Upload berkas pendukung (KTP/KK) wajib diisi!'];
                header('Location: ' . BASEURL . '/layanan');
                exit;
            }

            $suratModel = $this->model('SuratModel');
            
            // Priority Calculation Logic
            $id_jenis = $_POST['id_jenis_surat'];
            
            // Get base priority from jenis_surat
            $this->db = new Database;
            $this->db->query('SELECT prioritas FROM jenis_surat WHERE id_jenis_surat = :id');
            $this->db->bind('id', $id_jenis);
            $total_priority = $this->db->single()['prioritas'] ?? 1;

            $data = [
                'id_warga' => $_POST['id_warga'],
                'id_jenis_surat' => $id_jenis,
                'keperluan' => $_POST['keperluan'],
                'nilai_prioritas' => 1,
                'prioritas' => $total_priority,
                'file_berkas' => $this->uploadFile('file_berkas')
            ];

            if ($suratModel->ajukanSurat($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Permohonan berhasil dikirim!'];
                header('Location: ' . BASEURL . '/layanan');
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
        
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'prioritas';
        $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC';
        
        $pengajuan = $suratModel->getAllPengajuan($sort_by, $sort_order);
        
        // Sort: non-selesai first, then selesai; non-selesai sorted by priority descending
        usort($pengajuan, function($a, $b) {
            if ($a['status'] === 'selesai' && $b['status'] !== 'selesai') {
                return 1;
            }
            if ($a['status'] !== 'selesai' && $b['status'] === 'selesai') {
                return -1;
            }
            // For non-selesai, sort by priority descending
            return $b['prioritas'] - $a['prioritas'];
        });
        
        $data['pengajuan'] = $pengajuan;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        
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
            'ttd_data_uri' => $ttdDataUri
        ];

        if (class_exists('\\Dompdf\\Dompdf')) {
            ob_start();
            $this->view('surat/pdf', $data);
            $html = ob_get_clean();

            $dompdf = new \Dompdf\Dompdf();
            $options = $dompdf->getOptions();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'sans-serif');
            $dompdf->setOptions($options);
            
            $dompdf->loadHtml($html);
            // Set paper size to F4 (Folio/Legal Indonesian size: 215mm x 330mm)
            // 1mm = 2.83465pt. 215mm = 609.45pt, 330mm = 935.43pt
            $dompdf->setPaper([0, 0, 609.45, 935.43], 'portrait');
            $dompdf->render();
            $filename = str_replace(' ', '_', $surat['nama_surat']) . '_' . str_replace('/', '-', $surat['no_surat']) . '.pdf';
            
            // Open in browser (inline) instead of forcing download
            if (ob_get_length()) ob_end_clean();
            
            $dompdf->stream($filename, ["Attachment" => false]);
            exit;
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
        header('Location: ' . BASEURL . '/layanan');
        exit;
    }
}
