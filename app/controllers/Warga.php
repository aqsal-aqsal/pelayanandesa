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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('WargaModel')->addWarga($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan data warga.'];
            }
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('WargaModel')->updateWarga($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui data warga.'];
            }
            header('Location: ' . BASEURL . '/warga/admin');
            exit;
        }
    }

    public function hapus($id) {
        if ($this->model('WargaModel')->deleteWarga($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data warga berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus data warga.'];
        }
        header('Location: ' . BASEURL . '/warga/admin');
        exit;
    }
}
