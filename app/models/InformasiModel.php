<?php

class InformasiModel {
    private $table = 'informasi_publik';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllInformasi() {
        $this->db->query('SELECT i.*, COALESCE(p.nama_petugas, \'-\') AS nama_petugas FROM ' . $this->table . ' i LEFT JOIN petugas p ON i.created_by = p.id_petugas ORDER BY i.tgl_publikasi DESC');
        return $this->db->resultSet();
    }

    public function getInformasiById($id) {
        $this->db->query('SELECT i.*, COALESCE(p.nama_petugas, \'-\') AS nama_petugas FROM ' . $this->table . ' i LEFT JOIN petugas p ON i.created_by = p.id_petugas WHERE i.id_informasi = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function addInformasi($data) {
        $query = "INSERT INTO " . $this->table . " (judul, konten, tgl_publikasi, created_by, created_at) VALUES (:judul, :konten, CURDATE(), :created_by, NOW())";
        $this->db->query($query);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('konten', $data['konten']);
        $this->db->bind('created_by', $data['created_by']);
        return $this->db->execute();
    }

    public function deleteInformasi($id) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id_informasi = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
