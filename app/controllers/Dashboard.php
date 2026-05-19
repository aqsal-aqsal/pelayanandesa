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
        header('Location: ' . BASEURL . '/dashboard/' . $level);
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
        
        $this->view('dashboard/warga', $data);
    }
}
