<?php

class PengaduanModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPengaduanByWarga($id_warga) {
        $this->db->query('SELECT * FROM pengaduan WHERE id_warga = :id_warga ORDER BY created_at DESC');
        $this->db->bind('id_warga', $id_warga);
        return $this->db->resultSet();
    }

    public function getAllPengaduan() {
        $this->db->query('SELECT p.*, w.nama_lengkap FROM pengaduan p JOIN warga w ON p.id_warga = w.id_warga ORDER BY p.prioritas DESC, p.tanggal_aduan ASC');
        return $this->db->resultSet();
    }

    public function kirimPengaduan($data) {
        $query = "INSERT INTO pengaduan (id_warga, judul_aduan, isi_aduan, kategori_aduan, file_bukti, nilai_prioritas, prioritas, status, tanggal_aduan) 
                  VALUES (:id_warga, :judul_aduan, :isi_aduan, :kategori_aduan, :file_bukti, :nilai_prioritas, :prioritas, 'menunggu', NOW())";
        
        $this->db->query($query);
        $this->db->bind('id_warga', $data['id_warga']);
        $this->db->bind('judul_aduan', $data['judul_aduan']);
        $this->db->bind('isi_aduan', $data['isi_aduan']);
        $this->db->bind('kategori_aduan', $data['kategori_aduan']);
        $this->db->bind('file_bukti', $data['file_bukti']);
        $this->db->bind('nilai_prioritas', $data['nilai_prioritas']);
        $this->db->bind('prioritas', $data['prioritas']);

        return $this->db->execute();
    }

    public function updateStatus($id, $status, $catatan = null, $petugas_id = null) {
        $query = "UPDATE pengaduan SET status = :status, catatan_penolakan = :catatan, id_petugas_verif = :petugas_id, waktu_proses = NOW() WHERE id_pengaduan = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('catatan', $catatan);
        $this->db->bind('petugas_id', $petugas_id);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
