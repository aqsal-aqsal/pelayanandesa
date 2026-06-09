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
        $bltModel = $this->model('BltModel');
        $data['programs'] = $bltModel->getPrograms();
        
        $data['hasil_saya'] = $bltModel->getHasilByNik($_SESSION['user']['nik']);
        
        $this->view('blt/index', $data);
    }

    public function cek_hasil() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

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
        if ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

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

    public function calon($id_program = null) {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas')) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        
        if (!$id_program) {
            header('Location: ' . BASEURL . '/blt/admin');
            exit;
        }

        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Data Calon Penerima';
        $data['id_program'] = $id_program;
        $data['kriteria'] = $bltModel->getKriteria();
        $data['calon'] = $bltModel->getCalonPenerima($id_program);
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
            
            // Cek apakah NIK sudah ada di program yang sama
            $isDuplicate = $bltModel->isNikExistInProgram($id_program, $warga['id_warga']);
            if ($isDuplicate) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Warga dengan NIK tersebut sudah terdaftar sebagai calon penerima di program ini.'];
                header('Location: ' . BASEURL . '/blt/calon/' . $id_program);
                exit;
            }

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
}
