<?php

class Blt extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Bantuan Langsung Tunai (BLT)';
        $bltModel = $this->model('BltModel');
        $data['programs'] = $bltModel->getPrograms();
        
        // If user is warga, auto-check their result
        if ($_SESSION['user']['level'] == 'masyarakat') {
            $data['hasil_saya'] = $bltModel->getHasilByNik($_SESSION['user']['nik']);
        }
        
        $this->view('blt/index', $data);
    }

    public function cek_hasil() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nik = $_POST['nik'];
            $bltModel = $this->model('BltModel');
            $data['judul'] = 'Hasil Seleksi BLT';
            $data['hasil'] = $bltModel->getHasilByNik($nik);
            $data['nik_dicari'] = $nik;
            $this->view('blt/hasil_cek', $data);
        }
    }

    public function detail($id_program) {
        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Detail Seleksi BLT';
        $data['program'] = null; // Get from DB
        $data['hasil'] = $bltModel->getHasilSAW($id_program);
        $this->view('blt/detail', $data);
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

    public function calon($id_program) {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas')) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Data Calon Penerima';
        $data['id_program'] = $id_program;
        $data['kriteria'] = $bltModel->getKriteria();
        $data['calon'] = $bltModel->getCalonPenerima($id_program);
        $this->view('blt/calon', $data);
    }

    public function tambah_calon() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_program = $_POST['id_program'];
            $nik = $_POST['nik'];

            $warga = $this->model('WargaModel')->getWargaByNik($nik);
            if (!$warga) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK tidak ditemukan di data warga.'];
                header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
                exit;
            }

            $bltModel = $this->model('BltModel');
            if ($bltModel->addCalonPenerima($id_program, $warga['id_warga'])) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Calon penerima berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan calon penerima.'];
            }
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
}
