<?php

class Layanan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Layanan Surat Online';
        $suratModel = $this->model('SuratModel');
        $data['jenis_surat'] = $suratModel->getJenisSurat();
        
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($_SESSION['user']['nik']);
        
        $this->view('layanan/index', $data);
    }

    public function ajukan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $suratModel = $this->model('SuratModel');
            
            // Priority Calculation Logic
            $id_jenis = $_POST['id_jenis_surat'];
            $urgensi = (int)$_POST['urgensi']; // 1: Normal, 2: Mendesak, 3: Sangat Mendesak
            
            // Get base priority from jenis_surat
            $this->db = new Database;
            $this->db->query('SELECT prioritas FROM jenis_surat WHERE id_jenis_surat = :id');
            $this->db->bind('id', $id_jenis);
            $base_priority = $this->db->single()['prioritas'] ?? 1;

            $total_priority = $base_priority * $urgensi;

            $data = [
                'id_warga' => $_POST['id_warga'],
                'id_jenis_surat' => $id_jenis,
                'keperluan' => $_POST['keperluan'],
                'nilai_prioritas' => $urgensi,
                'prioritas' => $total_priority,
                'file_berkas' => $this->uploadFile('file_berkas')
            ];

            if ($suratModel->ajukanSurat($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Permohonan berhasil dikirim!'];
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
        $data['judul'] = 'Manajemen Layanan';
        $suratModel = $this->model('SuratModel');
        $data['pengajuan'] = $suratModel->getAllPengajuan();
        $this->view('layanan/admin', $data);
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $suratModel = $this->model('SuratModel');
            $id = $_POST['id_pengajuan'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? null;
            $petugas_id = $_SESSION['user']['id_user'];

            if ($suratModel->updateStatus($id, $status, $catatan, $petugas_id)) {
                // Trigger Notification (Mock)
                // $this->notify($id, $status);
                
                header('Location: ' . BASEURL . '/layanan/admin');
                exit;
            }
        }
    }
}
