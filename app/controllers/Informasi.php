<?php

class Informasi extends Controller {
    public function index() {
        $data['judul'] = 'Informasi Publik';
        $data['public_page'] = true;
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
        $data['public_page'] = true;
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
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $gambar = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "assets/img/informasi/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
                $gambar = time() . '.' . $file_extension;
                $target_file = $target_dir . $gambar;
                move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
            }

            $data = [
                'judul' => $_POST['judul'],
                'konten' => $_POST['konten'],
                'gambar' => $gambar,
                'created_by' => $_SESSION['user']['id_user']
            ];

            if ($this->model('InformasiModel')->addInformasi($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Informasi berhasil dipublikasikan!'];
                header('Location: ' . BASEURL . '/informasi/admin');
                exit;
            }
        }
    }

    public function edit() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $gambar = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $target_dir = "assets/img/informasi/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
                $gambar = time() . '.' . $file_extension;
                $target_file = $target_dir . $gambar;
                move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
            }

            $data = [
                'id_informasi' => $_POST['id_informasi'],
                'judul' => $_POST['judul'],
                'konten' => $_POST['konten'],
                'gambar' => $gambar
            ];

            if ($this->model('InformasiModel')->updateInformasi($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Informasi berhasil diperbarui!'];
                header('Location: ' . BASEURL . '/informasi/admin');
                exit;
            }
        }
    }

    public function hapus($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['level'] != 'petugas') {
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
