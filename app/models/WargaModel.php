<?php

class WargaModel {
    private $table = 'warga';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllWarga() {
        $this->db->query('SELECT w.* FROM ' . $this->table . ' w 
                          LEFT JOIN user u ON w.nik = u.nik 
                          WHERE u.level = "masyarakat" OR u.level IS NULL');
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
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('nama_lengkap', $data['nama_lengkap'] ?? null);
        $this->db->bind('tempat_lahir', $data['tempat_lahir'] ?? null);
        $this->db->bind('tanggal_lahir', $data['tanggal_lahir'] ?? null);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin'] ?? null);
        $this->db->bind('alamat', $data['alamat'] ?? null);
        $this->db->bind('rt_rw', $data['rt_rw'] ?? null);
        $this->db->bind('pekerjaan', $data['pekerjaan'] ?? null);
        $this->db->bind('penghasilan', $data['penghasilan'] ?? null);
        $this->db->bind('jumlah_tanggungan', $data['jumlah_tanggungan'] ?? null);
        $this->db->bind('kondisi_rumah', $data['kondisi_rumah'] ?? null);
        $this->db->bind('status_kawin', $data['status_kawin'] ?? null);

        return $this->db->execute();
    }

    public function updateWarga($data) {
        $current = $this->getWargaById($data['id_warga']);

        $query = "UPDATE " . $this->table . " SET 
                  nama_lengkap = :nama_lengkap, 
                  tempat_lahir = :tempat_lahir, 
                  tanggal_lahir = :tanggal_lahir, 
                  jenis_kelamin = :jenis_kelamin, 
                  alamat = :alamat, 
                  rt_rw = :rt_rw, 
                  pekerjaan = :pekerjaan, 
                  penghasilan = :penghasilan, 
                  jumlah_tanggungan = :jumlah_tanggungan, 
                  kondisi_rumah = :kondisi_rumah, 
                  status_kawin = :status_kawin 
                  WHERE id_warga = :id_warga";
        
        $this->db->query($query);
        
        $this->db->bind('nama_lengkap', $data['nama_lengkap'] ?? $current['nama_lengkap']);
        $this->db->bind('tempat_lahir', $data['tempat_lahir'] ?? $current['tempat_lahir']);
        $this->db->bind('tanggal_lahir', $data['tanggal_lahir'] ?? $current['tanggal_lahir']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin'] ?? $current['jenis_kelamin']);
        $this->db->bind('alamat', $data['alamat'] ?? $current['alamat']);
        $this->db->bind('rt_rw', $data['rt_rw'] ?? $current['rt_rw']);
        $this->db->bind('pekerjaan', $data['pekerjaan'] ?? $current['pekerjaan']);
        $this->db->bind('penghasilan', $data['penghasilan'] ?? $current['penghasilan']);
        $this->db->bind('jumlah_tanggungan', $data['jumlah_tanggungan'] ?? $current['jumlah_tanggungan']);
        $this->db->bind('kondisi_rumah', $data['kondisi_rumah'] ?? $current['kondisi_rumah']);
        $this->db->bind('status_kawin', $data['status_kawin'] ?? $current['status_kawin']);
        $this->db->bind('id_warga', $data['id_warga']);

        return $this->db->execute();
    }

    public function deleteWarga($id) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id_warga = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
