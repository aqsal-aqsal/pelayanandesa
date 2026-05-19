<?php

class Verify extends Controller {
    public function index($token = null) {
        $data['judul'] = 'Verifikasi Dokumen';
        if ($token) {
            $this->db = new Database;
            $this->db->query('SELECT p.*, j.nama_surat, w.nama_lengkap, pt.nama_petugas as kades 
                             FROM pengajuan_surat p 
                             JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat 
                             JOIN warga w ON p.id_warga = w.id_warga 
                             LEFT JOIN petugas pt ON p.id_kades_ttd = pt.id_petugas
                             WHERE p.qr_token = :token');
            $this->db->bind('token', $token);
            $data['surat'] = $this->db->single();
        } else {
            $data['surat'] = null;
        }
        
        $this->view('verify/index', $data);
    }
}
