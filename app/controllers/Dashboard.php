<?php

class Dashboard extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $level = $_SESSION['user']['level'];
        if ($level == 'masyarakat') {
            header('Location: ' . BASEURL . '/dashboard/warga');
        } else {
            header('Location: ' . BASEURL . '/dashboard/' . $level);
        }
        exit;
    }

    public function kades() {
        $data['judul'] = 'Dashboard Kepala Desa';
        $data['user'] = $_SESSION['user'];
        
        // Load Models for Analytics
        $suratModel = $this->model('SuratModel');
        $pengaduanModel = $this->model('PengaduanModel');
        $bltModel = $this->model('BltModel');

        // Analytics Data
        $data['total_surat'] = count($suratModel->getAllPengajuan());
        $data['total_pengaduan'] = count($pengaduanModel->getAllPengaduan());
        
        // Mock data for charts (in real app, query from DB)
        $data['chart_surat'] = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [12, 19, 3, 5, 2, 3]
        ];
        
        $this->view('dashboard/kades', $data);
    }

    public function petugas() {
        $data['judul'] = 'Dashboard Petugas';
        $data['user'] = $_SESSION['user'];
        $this->view('dashboard/petugas', $data);
    }

    public function warga() {
        $data['judul'] = 'Dashboard Warga';
        $data['user'] = $_SESSION['user'];
        
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($data['user']['nik']);
        
        $suratModel = $this->model('SuratModel');
        $data['pengajuan'] = $suratModel->getPengajuanByWarga($data['warga']['id_warga']);

        $pengaduanModel = $this->model('PengaduanModel');
        $data['pengaduan'] = $pengaduanModel->getPengaduanByWarga($data['warga']['id_warga']);
        
        $this->view('dashboard/warga', $data);
    }

    public function update_profil() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $wargaModel = $this->model('WargaModel');
            if ($wargaModel->updateWarga($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Profil Anda berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui profil.'];
            }
            header('Location: ' . BASEURL . '/dashboard/warga');
            exit;
        }
    }
}
