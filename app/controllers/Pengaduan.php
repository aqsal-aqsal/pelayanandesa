<?php

class Pengaduan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/pengaduan/admin');
            exit;
        }

        $data['judul'] = 'Pengaduan';
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $pengaduanModel = $this->model('PengaduanModel');
        $data['pengaduan'] = $pengaduanModel->getPengaduanByWarga($data['warga']['id_warga']);

        $this->view('pengaduan/index', $data);
    }

    public function buat() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/pengaduan/admin');
            exit;
        }

        $data['judul'] = 'Buat Pengaduan';
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $this->view('pengaduan/form', $data);
    }

    public function edit($id) {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/pengaduan/admin');
            exit;
        }

        $wargaModel = $this->model('WargaModel');
        $warga = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $pengaduanModel = $this->model('PengaduanModel');
        $aduan = $pengaduanModel->getPengaduanById($id);

        if (!$aduan || !$warga || (int)$aduan['id_warga'] !== (int)$warga['id_warga'] || $aduan['status'] != 'menunggu') {
            header('Location: ' . BASEURL . '/pengaduan');
            exit;
        }

        $data['judul'] = 'Edit Pengaduan';
        $data['warga'] = $warga;
        $data['aduan_edit'] = $aduan;
        $this->view('pengaduan/form', $data);
    }

    public function kirim() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_SESSION['user']['level'] != 'masyarakat') {
                header('Location: ' . BASEURL . '/pengaduan/admin');
                exit;
            }

            $pengaduanModel = $this->model('PengaduanModel');
            
            // Priority logic for complaints (can be more complex based on category)
            $kategori = $_POST['kategori_aduan'];
            $prioritas_map = [
                'keamanan' => 3,
                'infrastruktur' => 2,
                'pelayanan' => 1,
                'sosial' => 1,
                'lingkungan' => 1
            ];
            $prioritas = $prioritas_map[$kategori] ?? 1;

            $data = [
                'id_warga' => $_POST['id_warga'],
                'judul_aduan' => $_POST['judul_aduan'],
                'isi_aduan' => $_POST['isi_aduan'],
                'kategori_aduan' => $kategori,
                'nilai_prioritas' => $prioritas,
                'prioritas' => $prioritas,
                'file_bukti' => $this->uploadFile('file_bukti')
            ];

            if ($pengaduanModel->kirimPengaduan($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengaduan Anda telah terkirim!'];
                header('Location: ' . BASEURL . '/pengaduan');
                exit;
            }
        }
    }

    public function update() {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $wargaModel = $this->model('WargaModel');
            $warga = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

            $pengaduanModel = $this->model('PengaduanModel');
            $aduan = $pengaduanModel->getPengaduanById($_POST['id_pengaduan']);

            if (!$aduan || !$warga || (int)$aduan['id_warga'] !== (int)$warga['id_warga'] || $aduan['status'] != 'menunggu') {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pengaduan tidak dapat diedit.'];
                header('Location: ' . BASEURL . '/pengaduan');
                exit;
            }

            $kategori = $_POST['kategori_aduan'];
            $prioritas_map = [
                'keamanan' => 3,
                'infrastruktur' => 2,
                'pelayanan' => 1,
                'sosial' => 1,
                'lingkungan' => 1
            ];
            $prioritas = $prioritas_map[$kategori] ?? 1;

            $file = $this->uploadFile('file_bukti');
            $payload = [
                'id_pengaduan' => $_POST['id_pengaduan'],
                'id_warga' => $warga['id_warga'],
                'judul_aduan' => $_POST['judul_aduan'],
                'isi_aduan' => $_POST['isi_aduan'],
                'kategori_aduan' => $kategori,
                'nilai_prioritas' => $prioritas,
                'prioritas' => $prioritas,
                'file_bukti' => $file
            ];

            if ($pengaduanModel->updatePengaduan($payload)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengaduan berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui pengaduan.'];
            }

            header('Location: ' . BASEURL . '/pengaduan');
            exit;
        }
    }

    public function hapus($id) {
        if ($_SESSION['user']['level'] != 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        $wargaModel = $this->model('WargaModel');
        $warga = $wargaModel->getWargaByNik($_SESSION['user']['nik']);

        $pengaduanModel = $this->model('PengaduanModel');
        if ($pengaduanModel->deletePengaduan($id, $warga['id_warga'])) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengaduan berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus pengaduan. Hanya status menunggu yang bisa dihapus.'];
        }
        header('Location: ' . BASEURL . '/pengaduan');
        exit;
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
        $data['judul'] = 'Manajemen Pengaduan';
        $pengaduanModel = $this->model('PengaduanModel');
        $data['pengaduan'] = $pengaduanModel->getAllPengaduan();
        $this->view('pengaduan/admin', $data);
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pengaduanModel = $this->model('PengaduanModel');
            $id = $_POST['id_pengaduan'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? null;
            $petugas_id = $_SESSION['user']['id_user'];

            if ($pengaduanModel->updateStatus($id, $status, $catatan, $petugas_id)) {
                header('Location: ' . BASEURL . '/pengaduan/admin');
                exit;
            }
        }
    }
}
