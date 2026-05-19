<?php

class WargaModel {
    private $table = 'warga';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllWarga() {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getWargaByNik($nik) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nik=:nik');
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    public function getWargaById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_warga=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function addWarga($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, rt_rw, pekerjaan, penghasilan, jumlah_tanggungan, kondisi_rumah, status_kawin, created_at) 
                  VALUES (:nik, :nama_lengkap, :tempat_lahir, :tanggal_lahir, :jenis_kelamin, :alamat, :rt_rw, :pekerjaan, :penghasilan, :jumlah_tanggungan, :kondisi_rumah, :status_kawin, NOW())";
        
        $this->db->query($query);
        foreach ($data as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->execute();
    }
}
