<?php

class Pengaduan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Pengaduan';
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);
        
        $this->view('pengaduan/index', $data);
    }

    public function kirim() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                header('Location: ' . BASEURL . '/dashboard/warga');
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
