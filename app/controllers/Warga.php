<?php

class Warga extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function admin() {
        if ($_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Data Kependudukan';
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getAllWarga();
        $this->view('warga/admin', $data);
    }

    public function tambah() {
        if ($_SESSION['user']['level'] == 'kades') {
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $wargaModel = $this->model('WargaModel');
            $userModel = $this->model('UserModel');
            
            // Cek apakah NIK sudah ada di tabel warga
            $existingWarga = $wargaModel->getWargaByNik($_POST['nik']);
            if ($existingWarga) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK ' . $_POST['nik'] . ' sudah terdaftar di data warga!'];
                header('Location: ' . BASEURL . '/warga/admin');
                exit;
            }
            
            // Cek apakah NIK sudah ada di tabel user
            $existingUser = $userModel->getUserByNik($_POST['nik']);
            if ($existingUser) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK ' . $_POST['nik'] . ' sudah terdaftar di sistem user!'];
                header('Location: ' . BASEURL . '/warga/admin');
                exit;
            }
            
            if ($wargaModel->addWarga($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan data warga.'];
            }
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
    }

    public function edit() {
        if ($_SESSION['user']['level'] == 'kades') {
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $wargaModel = $this->model('WargaModel');
            $userModel = $this->model('UserModel');
            
            // Cek apakah NIK diubah dan apakah NIK baru sudah ada di warga lain
            if (isset($_POST['nik'])) {
                $current = $wargaModel->getWargaById($_POST['id_warga']);
                if ($current['nik'] != $_POST['nik']) {
                    $existingWarga = $wargaModel->getWargaByNik($_POST['nik']);
                    if ($existingWarga) {
                        $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK ' . $_POST['nik'] . ' sudah terdaftar di warga lain!'];
                        header('Location: ' . BASEURL . '/warga/admin');
                        exit;
                    }
                    
                    // Cek apakah NIK sudah ada di tabel user
                    $existingUser = $userModel->getUserByNik($_POST['nik']);
                    if ($existingUser) {
                        $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK ' . $_POST['nik'] . ' sudah terdaftar di sistem user!'];
                        header('Location: ' . BASEURL . '/warga/admin');
                        exit;
                    }
                }
            }
            
            if ($wargaModel->updateWarga($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui data warga.'];
            }
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
    }

    public function hapus($id) {
        if ($_SESSION['user']['level'] == 'kades') {
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
        if ($this->model('WargaModel')->deleteWarga($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus data warga.'];
        }
        header('Location: ' . BASEURL . '/warga/admin');
        exit;
    }
}
