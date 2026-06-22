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

    public function getPengaduanById($id) {
        $this->db->query('SELECT * FROM pengaduan WHERE id_pengaduan = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getAllPengaduan($sort_by = 'prioritas', $sort_order = 'DESC') {
        $allowed_columns = ['prioritas', 'nama_lengkap', 'tanggal_aduan', 'status'];
        if (!in_array($sort_by, $allowed_columns)) {
            $sort_by = 'prioritas';
        }
        $sort_order = strtoupper($sort_order) === 'ASC' ? 'ASC' : 'DESC';
        
        $order_sql = '';
        if ($sort_by == 'nama_lengkap') {
            $order_sql = "ORDER BY w.nama_lengkap $sort_order";
        } else {
            $order_sql = "ORDER BY p.$sort_by $sort_order";
        }
        
        $this->db->query("SELECT p.*, w.nama_lengkap FROM pengaduan p JOIN warga w ON p.id_warga = w.id_warga $order_sql");
        return $this->db->resultSet();
    }

    public function getFilteredPengaduan($tgl_mulai = null, $tgl_selesai = null) {
        $query = 'SELECT p.*, w.nama_lengkap FROM pengaduan p JOIN warga w ON p.id_warga = w.id_warga WHERE 1=1';
        
        if ($tgl_mulai) {
            $query .= ' AND p.tanggal_aduan >= :tgl_mulai';
        }
        if ($tgl_selesai) {
            $query .= ' AND p.tanggal_aduan <= :tgl_selesai';
        }
        
        $query .= ' ORDER BY p.tanggal_aduan DESC';
        
        $this->db->query($query);
        if ($tgl_mulai) $this->db->bind('tgl_mulai', $tgl_mulai . ' 00:00:00');
        if ($tgl_selesai) $this->db->bind('tgl_selesai', $tgl_selesai . ' 23:59:59');
        
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

    public function updatePengaduan($data) {
        if (!empty($data['file_bukti'])) {
            $query = "UPDATE pengaduan 
                      SET judul_aduan = :judul_aduan, isi_aduan = :isi_aduan, kategori_aduan = :kategori_aduan, file_bukti = :file_bukti, nilai_prioritas = :nilai_prioritas, prioritas = :prioritas, updated_at = NOW()
                      WHERE id_pengaduan = :id_pengaduan AND id_warga = :id_warga AND status = 'menunggu'";
        } else {
            $query = "UPDATE pengaduan 
                      SET judul_aduan = :judul_aduan, isi_aduan = :isi_aduan, kategori_aduan = :kategori_aduan, nilai_prioritas = :nilai_prioritas, prioritas = :prioritas, updated_at = NOW()
                      WHERE id_pengaduan = :id_pengaduan AND id_warga = :id_warga AND status = 'menunggu'";
        }

        $this->db->query($query);
        $this->db->bind('judul_aduan', $data['judul_aduan']);
        $this->db->bind('isi_aduan', $data['isi_aduan']);
        $this->db->bind('kategori_aduan', $data['kategori_aduan']);
        if (!empty($data['file_bukti'])) {
            $this->db->bind('file_bukti', $data['file_bukti']);
        }
        $this->db->bind('nilai_prioritas', $data['nilai_prioritas']);
        $this->db->bind('prioritas', $data['prioritas']);
        $this->db->bind('id_pengaduan', $data['id_pengaduan']);
        $this->db->bind('id_warga', $data['id_warga']);
        return $this->db->execute();
    }

    public function deletePengaduan($id_pengaduan, $id_warga) {
        $this->db->query("DELETE FROM pengaduan WHERE id_pengaduan = :id AND id_warga = :id_warga AND status = 'menunggu'");
        $this->db->bind('id', $id_pengaduan);
        $this->db->bind('id_warga', $id_warga);
        return $this->db->execute();
    }

    public function updateStatus($id, $status, $catatan = null, $petugas_id = null) {
        if ($status == 'selesai') {
            $query = "UPDATE pengaduan SET status = :status, catatan_penolakan = :catatan, id_petugas_verif = :petugas_id, waktu_proses = NOW(), tanggal_selesai = NOW() WHERE id_pengaduan = :id";
        } else {
            $query = "UPDATE pengaduan SET status = :status, catatan_penolakan = :catatan, id_petugas_verif = :petugas_id, waktu_proses = NOW() WHERE id_pengaduan = :id";
        }
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('catatan', $catatan);
        $this->db->bind('petugas_id', $petugas_id);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
