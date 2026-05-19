<?php

class SuratModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getJenisSurat() {
        $this->db->query('SELECT * FROM jenis_surat');
        return $this->db->resultSet();
    }

    public function getPengajuanByWarga($id_warga) {
        $this->db->query('SELECT p.*, j.nama_surat FROM pengajuan_surat p JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat WHERE p.id_warga = :id_warga ORDER BY p.created_at DESC');
        $this->db->bind('id_warga', $id_warga);
        return $this->db->resultSet();
    }

    public function getAllPengajuan() {
        $this->db->query('SELECT p.*, j.nama_surat, w.nama_lengkap FROM pengajuan_surat p JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat JOIN warga w ON p.id_warga = w.id_warga ORDER BY p.prioritas DESC, p.tanggal_pengajuan ASC');
        return $this->db->resultSet();
    }

    public function ajukanSurat($data) {
        $query = "INSERT INTO pengajuan_surat (id_warga, id_jenis_surat, keperluan, file_berkas, nilai_prioritas, prioritas, status, tanggal_pengajuan) 
                  VALUES (:id_warga, :id_jenis_surat, :keperluan, :file_berkas, :nilai_prioritas, :prioritas, 'menunggu', NOW())";
        
        $this->db->query($query);
        $this->db->bind('id_warga', $data['id_warga']);
        $this->db->bind('id_jenis_surat', $data['id_jenis_surat']);
        $this->db->bind('keperluan', $data['keperluan']);
        $this->db->bind('file_berkas', $data['file_berkas']);
        $this->db->bind('nilai_prioritas', $data['nilai_prioritas']);
        $this->db->bind('prioritas', $data['prioritas']); // Priority logic here

        if ($this->db->execute()) {
            $id_pengajuan = $this->db->single()['id_pengajuan'] ?? null; // Need to get last insert ID
            // Logic to add to antrian_layanan
            return true;
        }
        return false;
    }

    public function updateStatus($id, $status, $catatan = null, $petugas_id = null) {
        $query = "UPDATE pengajuan_surat SET status = :status, catatan_penolakan = :catatan, id_petugas_verif = :petugas_id, tanggal_verif = NOW() WHERE id_pengajuan = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('catatan', $catatan);
        $this->db->bind('petugas_id', $petugas_id);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
