<?php

class Informasi extends Controller {
    public function index() {
        $data['judul'] = 'Informasi Publik';
        $data['informasi'] = $this->model('InformasiModel')->getAllInformasi();
        $this->view('informasi/index', $data);
    }

    public function detail($id) {
        $data['informasi'] = $this->model('InformasiModel')->getInformasiById($id);
        if (!$data['informasi']) {
            header('Location: ' . BASEURL . '/informasi');
            exit;
        }
        $data['judul'] = $data['informasi']['judul'];
        $this->view('informasi/detail', $data);
    }

    public function admin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Kelola Informasi';
        $data['informasi'] = $this->model('InformasiModel')->getAllInformasi();
        $this->view('informasi/admin', $data);
    }

    public function tambah() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'judul' => $_POST['judul'],
                'konten' => $_POST['konten'],
                'created_by' => $_SESSION['user']['id_user']
            ];

            if ($this->model('InformasiModel')->addInformasi($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Informasi berhasil dipublikasikan!'];
                header('Location: ' . BASEURL . '/informasi/admin');
                exit;
            }
        }
    }

    public function hapus($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($this->model('InformasiModel')->deleteInformasi($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Informasi berhasil dihapus!'];
            header('Location: ' . BASEURL . '/informasi/admin');
            exit;
        }
    }
}
