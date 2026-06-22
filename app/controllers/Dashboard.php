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
        
        // Load Models
        $suratModel = $this->model('SuratModel');
        $bltModel = $this->model('BltModel');
        $wargaModel = $this->model('WargaModel');
        $pengaduanModel = $this->model('PengaduanModel');

        // Analytics Data
        $all_surat = $suratModel->getAllPengajuan();
        $data['surat_perlu_ttd'] = count(array_filter($all_surat, function($s) { 
            return $s['status'] == 'diproses' && empty($s['id_kades_ttd']); 
        }));
        
        $programs = $bltModel->getPrograms();
        $data['total_program'] = count($programs);
        $data['program_aktif'] = count(array_filter($programs, function($p) { return $p['status'] == 'aktif'; }));
        $data['program_selesai'] = count(array_filter($programs, function($p) { return $p['status'] == 'selesai'; }));
        $data['program_direncanakan'] = count(array_filter($programs, function($p) { return $p['status'] == 'direncanakan'; }));
        
        $data['total_warga'] = count($wargaModel->getAllWarga());
        $data['total_pengaduan'] = count($pengaduanModel->getAllPengaduan());
        
        // Chart Data
        $data['surat_monthly_trend'] = $suratModel->getMonthlySuratTrend();
        $data['surat_type_dist'] = $suratModel->getSuratTypeDistribution();
        $data['blt_avg_saw'] = $bltModel->getAverageSAWPerProgram();
        
        $this->view('dashboard/kades', $data);
    }

    public function petugas() {
        $data['judul'] = 'Dashboard Petugas';
        $data['user'] = $_SESSION['user'];

        // Load Models
        $suratModel = $this->model('SuratModel');
        $pengaduanModel = $this->model('PengaduanModel');
        $wargaModel = $this->model('WargaModel');
        $bltModel = $this->model('BltModel');

        // Get Counts
        $data['total_surat_masuk'] = count(array_filter($suratModel->getAllPengajuan(), function($s) { return $s['status'] == 'menunggu'; }));
        $data['total_aduan_masuk'] = count(array_filter($pengaduanModel->getAllPengaduan(), function($p) { return $p['status'] == 'menunggu'; }));
        $data['total_warga'] = count($wargaModel->getAllWarga());
        
        $programs = $bltModel->getPrograms();
        $data['total_program'] = count($programs);
        $data['program_aktif'] = count(array_filter($programs, function($p) { return $p['status'] == 'aktif'; }));
        $data['program_selesai'] = count(array_filter($programs, function($p) { return $p['status'] == 'selesai'; }));
        $data['program_direncanakan'] = count(array_filter($programs, function($p) { return $p['status'] == 'direncanakan'; }));

        $this->view('dashboard/petugas', $data);
    }

    public function warga() {
        $data['judul'] = 'Dashboard Warga';
        $data['user'] = $_SESSION['user'];
        
        $wargaModel = $this->model('WargaModel');
        $data['warga'] = $wargaModel->getWargaByNik($data['user']['nik']);
        
        $suratModel = $this->model('SuratModel');
        $data['pengajuan'] = $suratModel->getPengajuanByWarga($data['warga']['id_warga']);
        $data['surat_menunggu'] = count(array_filter($data['pengajuan'], function($s) { return $s['status'] == 'menunggu'; }));
        $data['surat_selesai'] = count(array_filter($data['pengajuan'], function($s) { return $s['status'] == 'selesai'; }));

        $pengaduanModel = $this->model('PengaduanModel');
        $data['pengaduan'] = $pengaduanModel->getPengaduanByWarga($data['warga']['id_warga']);
        $data['aduan_total'] = count($data['pengaduan']);

        $bltModel = $this->model('BltModel');
        $hasil_blt = $bltModel->getHasilByNik($data['user']['nik']);
        $data['hasil_blt'] = !empty($hasil_blt) ? $hasil_blt[0] : null;
        
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
