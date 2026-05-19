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
        $data['hasil'] = $bltModel->getHasilSAW($id_program);
        $data['judul'] = 'Laporan Hasil Seleksi SAW BLT';
        
        $this->generatePDF('laporan/pdf_blt', $data, 'Laporan_BLT_' . $id_program . '.pdf');
    }

    private function generatePDF($view, $data, $filename) {
        if (class_exists('\\Dompdf\\Dompdf')) {
            ob_start();
            $this->view($view, $data);
            $html = ob_get_clean();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream($filename, ["Attachment" => false]);
            return;
        }

        $this->view($view, $data);
    }
}
