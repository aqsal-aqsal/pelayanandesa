<?php

class Blt extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

        $data['judul'] = 'Bantuan Langsung Tunai (BLT)';
        $data['nik_dicari'] = '';
        $data['status_cek'] = null;
        $data['hasil_cek'] = [];
        $data['program_lolos'] = [];
        $this->view('blt/index', $data);
    }

    public function cek_hasil() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nik = trim($_POST['nik']);
            $bltModel = $this->model('BltModel');
            $hasil = $bltModel->getHasilByNik($nik);
            $programLolos = array_values(array_filter($hasil, function ($item) {
                return isset($item['status_penerimaan']) && $item['status_penerimaan'] === 'terpilih';
            }));

            $data['judul'] = 'Bantuan Langsung Tunai (BLT)';
            $data['status_cek'] = !empty($programLolos) ? 'lolos' : 'tidak_lolos';
            $data['hasil_cek'] = $hasil;
            $data['program_lolos'] = $programLolos;
            $data['nik_dicari'] = $nik;
            $this->view('blt/index', $data);
        }
    }

    public function peringkat($id_program) {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $program = $bltModel->getProgramById($id_program);

        if (!$program) {
            header('Location: ' . BASEURL . '/blt');
            exit;
        }

        $data['judul'] = 'Perankingan SAW BLT';
        $data['program'] = $program;
        $data['hasil'] = $bltModel->getHasilSAW($id_program);
        $this->view('blt/peringkat', $data);
    }

    public function detail($id_program) {
        if ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Detail Seleksi BLT';
        $data['id_program'] = $id_program;
        $data['hasil'] = $bltModel->getHasilSAW($id_program);
        $this->view('blt/detail', $data);
    }

    public function upload_bukti() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_program = $_POST['id_program'];
            $id_calon = $_POST['id_calon'];
            $status_penyaluran = $_POST['status_penyaluran'];

            // Handle file upload
            $uploadDir = 'assets/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = '';
            if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
                $fileTmpPath = $_FILES['bukti']['tmp_name'];
                $fileName = time() . '_' . basename($_FILES['bukti']['name']);
                $destPath = $uploadDir . $fileName;
                
                if (!move_uploaded_file($fileTmpPath, $destPath)) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal mengunggah file!'];
                    header('Location: ' . BASEURL . '/blt/detail/' . $id_program);
                    exit;
                }
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Tidak ada file yang diunggah!'];
                header('Location: ' . BASEURL . '/blt/detail/' . $id_program);
                exit;
            }

            $bltModel = $this->model('BltModel');
            if ($bltModel->updateBuktiPenyaluran($id_program, $id_calon, $fileName, $status_penyaluran)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Bukti penyerahan berhasil diunggah!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menyimpan bukti!'];
            }
            header('Location: ' . BASEURL . '/blt/detail/' . $id_program);
            exit;
        }
    }

    public function kriteria() {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas')) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Kriteria Bantuan';
        $bltModel = $this->model('BltModel');
        $data['kriteria'] = $bltModel->getKriteria();
        $this->view('blt/kriteria', $data);
    }

    public function tambah_kriteria() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bltModel = $this->model('BltModel');
            if ($bltModel->addKriteria($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Kriteria berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan kriteria.'];
            }
            header('Location: ' . BASEURL . '/blt/kriteria');
            exit;
        }
    }

    public function hapus_kriteria($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->deleteKriteria($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Kriteria berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus kriteria.'];
        }
        header('Location: ' . BASEURL . '/blt/kriteria');
        exit;
    }
    
    public function tambah_sub_kriteria($id_kriteria) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bltModel = $this->model('BltModel');
            if ($bltModel->addSubKriteria($id_kriteria, $_POST['label'], $_POST['nilai'])) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Sub-kriteria berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan sub-kriteria.'];
            }
            header('Location: ' . BASEURL . '/blt/kriteria');
            exit;
        }
    }
    
    public function hapus_sub_kriteria($id_sub_kriteria) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->deleteSubKriteria($id_sub_kriteria)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Sub-kriteria berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus sub-kriteria.'];
        }
        header('Location: ' . BASEURL . '/blt/kriteria');
        exit;
    }

    public function tambah_program() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bltModel = $this->model('BltModel');
            if ($bltModel->addProgram($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Program bantuan berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan program bantuan.'];
            }
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }
    }

    public function edit_program() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bltModel = $this->model('BltModel');
            if ($bltModel->editProgram($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Program bantuan berhasil diupdate!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal mengupdate program bantuan.'];
            }
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }
    }

    public function hapus_program($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->deleteProgram($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Program bantuan berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus program bantuan.'];
        }
        header('Location: ' . BASEURL . '/blt/admin');
        exit;
    }

    public function calon($id_program = null)
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas')) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        
        if (!$id_program) {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $wargaModel = $this->model('WargaModel');
        $data['judul'] = 'Data Calon Penerima';
        $data['id_program'] = $id_program;
        $data['kriteria'] = $bltModel->getKriteria();
        $data['calon'] = $bltModel->getCalonPenerima($id_program);
        $data['all_warga'] = $wargaModel->getAllWarga();
        $this->view('blt/calon', $data);
    }

    public function hapus_calon($id_program, $id_calon) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->deleteCalonPenerima($id_calon)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Calon penerima berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus calon penerima.'];
        }
        header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
        exit;
    }

    public function tambah_calon()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_program = $_POST['id_program'];
            $id_warga_list = isset($_POST['id_warga']) ? $_POST['id_warga'] : [];

            if (empty($id_warga_list)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pilih minimal satu warga.'];
                header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
                exit;
            }

            $bltModel = $this->model('BltModel');
            $wargaModel = $this->model('WargaModel');
            
            $success_count = 0;
            $duplicate_count = 0;
            
            foreach ($id_warga_list as $id_warga) {
                $warga = $wargaModel->getWargaById($id_warga);
                if (!$warga) continue;
                
                // Cek apakah NIK sudah ada di program yang sama
                $isDuplicate = $bltModel->isNikExistInProgram($id_program, $id_warga);
                if ($isDuplicate) {
                    $duplicate_count++;
                    continue;
                }

<<<<<<< HEAD
                $id_calon = $bltModel->addCalonPenerima($id_program, $id_warga);
                if ($id_calon) {
=======
                if ($bltModel->addCalonPenerima($id_program, $id_warga)) {
                    // Get the new calon id
                    $this->db->query('SELECT id_calon FROM calon_penerima WHERE id_warga = :id_warga AND id_program = :id_program ORDER BY id_calon DESC LIMIT 1');
                    $this->db->bind('id_warga', $id_warga);
                    $this->db->bind('id_program', $id_program);
                    $calon = $this->db->single();
                    $id_calon = $calon['id_calon'];
                    
>>>>>>> 67058ad4b903e268d3f48fd0febf82d06fceac95
                    // Auto-fill nilai kriteria
                    $kriteria = $bltModel->getKriteria();
                    foreach ($kriteria as $k) {
                        $nilai = $bltModel->getNilaiFromWargaData($k['id_kriteria'], $warga);
                        if ($nilai !== null) {
                            $bltModel->saveNilaiKriteria($id_calon, $k['id_kriteria'], $nilai);
                        }
                    }
                    
                    $success_count++;
                }
            }
            
            $message = '';
            if ($success_count > 0) {
                $message .= "$success_count warga berhasil ditambahkan. ";
            }
            if ($duplicate_count > 0) {
                $message .= "$duplicate_count warga sudah terdaftar. ";
            }
            
            $_SESSION['flash'] = ['type' => ($success_count > 0 ? 'success' : 'error'), 'message' => $message];
            header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
            exit;
        }
    }

    public function simpan_nilai() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_program = $_POST['id_program'];
            $id_calon = $_POST['id_calon'];
            $bltModel = $this->model('BltModel');

            foreach ($_POST as $key => $val) {
                if (strpos($key, 'kriteria_') === 0) {
                    $id_kriteria = (int)str_replace('kriteria_', '', $key);
                    $bltModel->saveNilaiKriteria($id_calon, $id_kriteria, $val);
                }
            }

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Nilai kriteria berhasil disimpan!'];
            header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
            exit;
        }
    }
    
    public function auto_fill_nilai($id_program, $id_calon) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        
        // Get calon and warga data
<<<<<<< HEAD
        $calon = $bltModel->getCalonById($id_calon);
=======
        $this->db->query('SELECT c.*, w.* FROM calon_penerima c JOIN warga w ON c.id_warga = w.id_warga WHERE c.id_calon = :id_calon');
        $this->db->bind('id_calon', $id_calon);
        $calon = $this->db->single();
>>>>>>> 67058ad4b903e268d3f48fd0febf82d06fceac95
        
        if (!$calon) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Calon tidak ditemukan!'];
            header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
            exit;
        }
        
        $kriteria = $bltModel->getKriteria();
        foreach ($kriteria as $k) {
            $nilai = $bltModel->getNilaiFromWargaData($k['id_kriteria'], $calon);
            if ($nilai !== null) {
                $bltModel->saveNilaiKriteria($id_calon, $k['id_kriteria'], $nilai);
            }
        }
        
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Nilai kriteria berhasil diisi otomatis!'];
        header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
        exit;
    }

    public function ajukan_kades($id_program, $id_calon) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->updateStatusCalon($id_calon, 'diproses')) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Calon penerima diajukan untuk persetujuan Kepala Desa.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal mengajukan calon penerima.'];
        }
        header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
        exit;
    }

    public function admin() {
        if ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Manajemen Seleksi BLT';
        $bltModel = $this->model('BltModel');
        $data['programs'] = $bltModel->getPrograms();
        $data['program_aktif'] = count(array_filter($data['programs'], function($p) { return $p['status'] == 'aktif'; }));
        $data['program_selesai'] = count(array_filter($data['programs'], function($p) { return $p['status'] == 'selesai'; }));
        $data['program_direncanakan'] = count(array_filter($data['programs'], function($p) { return $p['status'] == 'direncanakan'; }));
        $this->view('blt/admin', $data);
    }

    public function hitung($id_program) {
        if ($_SESSION['user']['level'] != 'kades') {
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->calculateSAW($id_program)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Perhitungan SAW selesai!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghitung. Pastikan data calon dan nilai kriteria sudah lengkap.'];
        }
        header('Location: ' . BASEURL . '/blt/admin');
        exit;
    }

    public function laporan($id_program) {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Laporan Transparansi Perhitungan BLT';
        $data['id_program'] = $id_program;
        $data['program'] = $bltModel->getProgramById($id_program);
        $data['kriteria'] = $bltModel->getKriteria();
        $data['detailed_saw'] = $bltModel->getDetailedSAW($id_program);
        $data['hasil_saw'] = $bltModel->getHasilSAW($id_program);
        $this->view('blt/laporan', $data);
    }
}
