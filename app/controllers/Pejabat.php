<?php

class Pejabat extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        if ($_SESSION['user']['level'] == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function admin() {
        $data['judul'] = 'Data Pejabat';
        $data['pejabat'] = $this->model('PetugasModel')->getAll();
        $this->view('pejabat/admin', $data);
    }

    public function tambah() {
        if ($_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $petugasModel = $this->model('PetugasModel');
            if ($petugasModel->add($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data pejabat berhasil ditambahkan!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menambahkan data pejabat.'];
            }
            header('Location: ' . BASEURL . '/pejabat/admin');
            exit;
        }
    }

    public function edit() {
        if ($_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $petugasModel = $this->model('PetugasModel');
            if ($petugasModel->update($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data pejabat berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui data pejabat.'];
            }
            header('Location: ' . BASEURL . '/pejabat/admin');
            exit;
        }
    }

    public function hapus($id) {
        if ($_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $petugasModel = $this->model('PetugasModel');
        if ($petugasModel->delete($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data pejabat berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus data pejabat.'];
        }
        header('Location: ' . BASEURL . '/pejabat/admin');
        exit;
    }

    public function upload_ttd() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_petugas'];
            if ((int)$id !== (int)$_SESSION['user']['id_user'] && $_SESSION['user']['level'] != 'petugas') {
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            }

            $filename = $this->uploadFile('ttd');
            if ($filename) {
                $this->model('PetugasModel')->updateTtd($id, $filename);
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Tanda tangan berhasil diupload!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal upload tanda tangan.'];
            }
            header('Location: ' . BASEURL . '/pejabat/admin');
            exit;
        }
    }

    private function uploadFile($name) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0) {
            $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $destination = 'assets/uploads/' . $filename;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $destination)) {
                return $filename;
            }
        }
        return null;
    }
}

