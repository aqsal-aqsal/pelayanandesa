<?php

class PetugasModel {
    private $table = 'petugas';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_petugas = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function add($data) {
        $this->db->query('INSERT INTO petugas (id_petugas, nama_petugas, jabatan, ttd, status_aktif, created_at) VALUES (:id, :nama, :jabatan, :ttd, :status, NOW())');
        $this->db->bind('id', $data['id_petugas']);
        $this->db->bind('nama', $data['nama_petugas']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('ttd', $data['ttd'] ?? null);
        $this->db->bind('status', $data['status_aktif'] ?? 1);
        return $this->db->execute();
    }

    public function update($data) {
        $this->db->query('UPDATE petugas SET nama_petugas = :nama, jabatan = :jabatan, status_aktif = :status, updated_at = NOW() WHERE id_petugas = :id');
        $this->db->bind('nama', $data['nama_petugas']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('status', $data['status_aktif'] ?? 1);
        $this->db->bind('id', $data['id_petugas']);
        return $this->db->execute();
    }

    public function updateTtd($id, $filename) {
        $this->db->query('UPDATE petugas SET ttd = :ttd, updated_at = NOW() WHERE id_petugas = :id');
        $this->db->bind('ttd', $filename);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query('DELETE FROM petugas WHERE id_petugas = :id');
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
