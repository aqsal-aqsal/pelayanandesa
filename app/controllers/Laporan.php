<?php

class Laporan extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas')) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Laporan & Statistik';
        
        $suratModel = $this->model('SuratModel');
        $pengaduanModel = $this->model('PengaduanModel');
        $bltModel = $this->model('BltModel');
        
        $data['total_surat'] = count($suratModel->getAllPengajuan());
        $data['total_pengaduan'] = count($pengaduanModel->getAllPengaduan());
        $data['total_program'] = count($bltModel->getPrograms());
        
        // Mock stats for display (could be more complex queries)
        $data['stats_surat'] = [
            'selesai' => count(array_filter($suratModel->getAllPengajuan(), fn($s) => $s['status'] == 'selesai')),
            'proses' => count(array_filter($suratModel->getAllPengajuan(), fn($s) => $s['status'] == 'diproses' || $s['status'] == 'menunggu')),
            'ditolak' => count(array_filter($suratModel->getAllPengajuan(), fn($s) => $s['status'] == 'ditolak')),
        ];

        // New reports added
        $data['stats_surat_priority'] = $suratModel->getSuratStatsByPriority();
        $data['stats_blt_manajerial'] = $bltModel->getAverageSAWPerProgram();
        $data['stats_blt_periode'] = $bltModel->getManajerialStatsPerPeriode();

        $this->view('laporan/index', $data);
    }

    public function cetak_surat() {
        $suratModel = $this->model('SuratModel');
        $data['pengajuan'] = $suratModel->getAllPengajuan();
        $data['judul'] = 'Laporan Pengajuan Surat';
        
        $this->generatePDF('laporan/pdf_surat', $data, 'Laporan_Surat_' . date('Y-m-d') . '.pdf');
    }

    public function cetak_blt($id_program) {
        $bltModel = $this->model('BltModel');
        $data['hasil'] = $bltModel->getDetailedSAW($id_program); // Use detailed instead of simple
        $data['kriteria'] = $bltModel->getKriteria();
        $data['program'] = $bltModel->getProgramById($id_program);
        $data['judul'] = 'Laporan Hasil Seleksi SAW BLT';
        
        $this->generatePDF('laporan/pdf_blt', $data, 'Laporan_BLT_' . $id_program . '.pdf');
    }

    public function preview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jenis = $_POST['jenis_laporan'];
            $tgl_mulai = $_POST['tgl_mulai'] ?? null;
            $tgl_selesai = $_POST['tgl_selesai'] ?? null;
            
            $data = [
                'judul' => 'Preview Laporan ' . ucfirst($jenis),
                'jenis' => $jenis,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'status_surat' => $_POST['status_surat'] ?? 'semua',
                'id_jenis_surat' => $_POST['id_jenis_surat'] ?? 'semua'
            ];

            switch ($jenis) {
                case 'surat':
                    $data['list'] = $this->model('SuratModel')->getFilteredPengajuan($data['status_surat'], $data['id_jenis_surat'], $tgl_mulai, $tgl_selesai);
                    break;
                case 'aduan':
                    $data['list'] = $this->model('PengaduanModel')->getFilteredPengaduan($tgl_mulai, $tgl_selesai);
                    break;
                case 'informasi':
                    $data['list'] = $this->model('InformasiModel')->getAllInformasi();
                    break;
                case 'program':
                    $data['list'] = $this->model('BltModel')->getPrograms();
                    break;
                case 'penerima':
                    $data['list'] = $this->model('BltModel')->getAllPenerima();
                    break;
                case 'warga':
                    $data['list'] = $this->model('WargaModel')->getAllWarga();
                    break;
            }

            $this->view('laporan/preview', $data);
        }
    }

    public function cetak() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jenis = $_POST['jenis_laporan'];
            $tgl_mulai = $_POST['tgl_mulai'] ?? null;
            $tgl_selesai = $_POST['tgl_selesai'] ?? null;
            
            $data = [];
            $view = '';
            $filename = 'Laporan_' . ucfirst($jenis) . '_' . date('Ymd') . '.pdf';

            switch ($jenis) {
                case 'surat':
                    $status = $_POST['status_surat'] ?? 'semua';
                    $id_jenis = $_POST['id_jenis_surat'] ?? 'semua';
                    $data['pengajuan'] = $this->model('SuratModel')->getFilteredPengajuan($status, $id_jenis, $tgl_mulai, $tgl_selesai);
                    $data['judul'] = 'Laporan Pengajuan Surat';
                    $view = 'laporan/pdf_surat';
                    break;
                case 'aduan':
                    $data['pengaduan'] = $this->model('PengaduanModel')->getFilteredPengaduan($tgl_mulai, $tgl_selesai);
                    $data['judul'] = 'Laporan Pengaduan Warga';
                    $view = 'laporan/pdf_aduan';
                    break;
                case 'informasi':
                    $data['informasi'] = $this->model('InformasiModel')->getAllInformasi();
                    $data['judul'] = 'Laporan Informasi Publik';
                    $view = 'laporan/pdf_informasi';
                    break;
                case 'program':
                    $data['programs'] = $this->model('BltModel')->getPrograms();
                    $data['judul'] = 'Laporan Program Bantuan';
                    $view = 'laporan/pdf_program';
                    break;
                case 'penerima':
                    $data['penerima'] = $this->model('BltModel')->getAllPenerima();
                    $data['judul'] = 'Daftar Penerima Bantuan';
                    $view = 'laporan/pdf_penerima';
                    break;
                case 'warga':
                    $data['warga'] = $this->model('WargaModel')->getAllWarga();
                    $data['judul'] = 'Daftar Warga Desa Astambul Kota';
                    $view = 'laporan/pdf_warga';
                    break;
            }

            $this->generatePDF($view, $data, $filename);
        }
    }

    private function generatePDF($view, $data, $filename) {
        if (class_exists('\\Dompdf\\Dompdf')) {
            ob_start();
            $this->view($view, $data);
            $html = ob_get_clean();

            $dompdf = new \Dompdf\Dompdf();
            $options = $dompdf->getOptions();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'sans-serif');
            $dompdf->setOptions($options);
            
            $dompdf->loadHtml($html);
            // Set paper size to F4 (Folio/Legal Indonesian size: 215mm x 330mm)
            $dompdf->setPaper([0, 0, 609.45, 935.43], 'portrait');
            $dompdf->render();
            
            // Open in browser (inline) instead of forcing download
            if (ob_get_length()) ob_end_clean();
            
            $dompdf->stream($filename, ["Attachment" => false]);
            exit;
        }

        $this->view($view, $data);
    }
}
