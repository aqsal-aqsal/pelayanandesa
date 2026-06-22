<?php

class SuratModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getJenisSurat() {
        $this->db->query('SELECT * FROM jenis_surat ORDER BY nama_surat ASC');
        return $this->db->resultSet();
    }

    public function addJenisSurat($data) {
        $this->db->query("INSERT INTO jenis_surat (nama_surat, prioritas) VALUES (:nama, :prioritas)");
        $this->db->bind('nama', $data['nama_surat']);
        $this->db->bind('prioritas', $data['prioritas']);
        return $this->db->execute();
    }

    public function updateJenisSurat($data) {
        $this->db->query("UPDATE jenis_surat SET nama_surat = :nama, prioritas = :prioritas WHERE id_jenis_surat = :id");
        $this->db->bind('nama', $data['nama_surat']);
        $this->db->bind('prioritas', $data['prioritas']);
        $this->db->bind('id', $data['id_jenis_surat']);
        return $this->db->execute();
    }

    public function deleteJenisSurat($id) {
        $this->db->query("DELETE FROM jenis_surat WHERE id_jenis_surat = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function getPengajuanByWarga($id_warga) {
        $this->db->query('SELECT p.*, j.nama_surat FROM pengajuan_surat p JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat WHERE p.id_warga = :id_warga ORDER BY p.created_at DESC');
        $this->db->bind('id_warga', $id_warga);
        return $this->db->resultSet();
    }

    public function getAllPengajuan($sort_by = 'prioritas', $sort_order = 'DESC') {
        $allowed_columns = ['prioritas', 'nama_lengkap', 'nama_surat', 'tanggal_pengajuan', 'status'];
        if (!in_array($sort_by, $allowed_columns)) {
            $sort_by = 'prioritas';
        }
        $sort_order = strtoupper($sort_order) === 'ASC' ? 'ASC' : 'DESC';
        
        $order_sql = '';
        if ($sort_by == 'nama_lengkap') {
            $order_sql = "ORDER BY w.nama_lengkap $sort_order";
        } else if ($sort_by == 'nama_surat') {
            $order_sql = "ORDER BY j.nama_surat $sort_order";
        } else {
            $order_sql = "ORDER BY p.$sort_by $sort_order";
        }
        
        $this->db->query("SELECT p.*, j.nama_surat, w.nama_lengkap, w.nik FROM pengajuan_surat p JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat JOIN warga w ON p.id_warga = w.id_warga $order_sql");
        return $this->db->resultSet();
    }

    public function getFilteredPengajuan($status = 'semua', $id_jenis = 'semua', $tgl_mulai = null, $tgl_selesai = null) {
        $query = 'SELECT p.*, j.nama_surat, w.nama_lengkap, w.nik FROM pengajuan_surat p JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat JOIN warga w ON p.id_warga = w.id_warga WHERE 1=1';
        
        if ($status != 'semua') {
            $query .= ' AND p.status = :status';
        }
        if ($id_jenis != 'semua') {
            $query .= ' AND p.id_jenis_surat = :id_jenis';
        }
        if ($tgl_mulai) {
            $query .= ' AND p.tanggal_pengajuan >= :tgl_mulai';
        }
        if ($tgl_selesai) {
            $query .= ' AND p.tanggal_pengajuan <= :tgl_selesai';
        }
        
        $query .= ' ORDER BY p.tanggal_pengajuan DESC';
        
        $this->db->query($query);
        if ($status != 'semua') $this->db->bind('status', $status);
        if ($id_jenis != 'semua') $this->db->bind('id_jenis', $id_jenis);
        if ($tgl_mulai) $this->db->bind('tgl_mulai', $tgl_mulai . ' 00:00:00');
        if ($tgl_selesai) $this->db->bind('tgl_selesai', $tgl_selesai . ' 23:59:59');
        
        return $this->db->resultSet();
    }

    public function getPengajuanById($id_pengajuan) {
        $this->db->query('SELECT p.*, j.nama_surat, j.kode_surat, w.nama_lengkap, w.nik, w.tempat_lahir, w.tanggal_lahir, w.jenis_kelamin, w.alamat, w.rt_rw, pt.nama_petugas AS nama_kades, pt.ttd AS ttd_kades
                          FROM pengajuan_surat p 
                          JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat 
                          JOIN warga w ON p.id_warga = w.id_warga 
                          LEFT JOIN petugas pt ON p.id_kades_ttd = pt.id_petugas
                          WHERE p.id_pengajuan = :id');
        $this->db->bind('id', $id_pengajuan);
        return $this->db->single();
    }

    public function setNoSurat($id_pengajuan, $no_surat) {
        $this->db->query('UPDATE pengajuan_surat SET no_surat = :no_surat WHERE id_pengajuan = :id');
        $this->db->bind('no_surat', $no_surat);
        $this->db->bind('id', $id_pengajuan);
        return $this->db->execute();
    }

    public function updatePengajuan($data) {
        if (!empty($data['file_berkas'])) {
            $query = 'UPDATE pengajuan_surat 
                      SET id_jenis_surat = :id_jenis_surat, keperluan = :keperluan, file_berkas = :file_berkas, nilai_prioritas = :nilai_prioritas, prioritas = :prioritas, updated_at = NOW()
                      WHERE id_pengajuan = :id_pengajuan AND id_warga = :id_warga AND status = \'menunggu\'';
        } else {
            $query = 'UPDATE pengajuan_surat 
                      SET id_jenis_surat = :id_jenis_surat, keperluan = :keperluan, nilai_prioritas = :nilai_prioritas, prioritas = :prioritas, updated_at = NOW()
                      WHERE id_pengajuan = :id_pengajuan AND id_warga = :id_warga AND status = \'menunggu\'';
        }

        $this->db->query($query);
        $this->db->bind('id_jenis_surat', $data['id_jenis_surat']);
        $this->db->bind('keperluan', $data['keperluan']);
        if (!empty($data['file_berkas'])) {
            $this->db->bind('file_berkas', $data['file_berkas']);
        }
        $this->db->bind('nilai_prioritas', $data['nilai_prioritas']);
        $this->db->bind('prioritas', $data['prioritas']);
        $this->db->bind('id_pengajuan', $data['id_pengajuan']);
        $this->db->bind('id_warga', $data['id_warga']);
        return $this->db->execute();
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
            return $this->db->lastInsertId();
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

    public function kadesTandaTangan($id, $kades_id) {
        $query = "UPDATE pengajuan_surat 
                  SET status = 'selesai', id_kades_ttd = :kades_id, tanggal_selesai = NOW(), is_verified = 1 
                  WHERE id_pengajuan = :id";
        $this->db->query($query);
        $this->db->bind('kades_id', $kades_id);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function deletePengajuan($id) {
        $this->db->query("DELETE FROM pengajuan_surat WHERE id_pengajuan = :id AND status = 'menunggu'");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function getMonthlySuratTrend() {
        $this->db->query("SELECT 
            DATE_FORMAT(tanggal_pengajuan, '%Y-%m') as bulan,
            COUNT(*) as jumlah
            FROM pengajuan_surat
            GROUP BY DATE_FORMAT(tanggal_pengajuan, '%Y-%m')
            ORDER BY bulan ASC
            LIMIT 12");
        return $this->db->resultSet();
    }

    public function getSuratTypeDistribution() {
        $this->db->query("SELECT 
            j.nama_surat,
            COUNT(p.id_pengajuan) as jumlah
            FROM pengajuan_surat p
            JOIN jenis_surat j ON p.id_jenis_surat = j.id_jenis_surat
            GROUP BY p.id_jenis_surat, j.nama_surat
            ORDER BY jumlah DESC
            LIMIT 5");
        return $this->db->resultSet();
    }

    public function getSuratStatsByPriority() {
        $this->db->query("SELECT 
            p.prioritas,
            COUNT(*) as total,
            COUNT(CASE WHEN p.status = 'selesai' THEN 1 END) as selesai,
            AVG(CASE WHEN p.status = 'selesai' THEN 
                TIMESTAMPDIFF(HOUR, p.tanggal_pengajuan, p.tanggal_selesai) 
            END) as avg_wait_hours_selesai,
            AVG(CASE WHEN p.status IN ('menunggu','diproses') THEN 
                TIMESTAMPDIFF(HOUR, p.tanggal_pengajuan, NOW()) 
            END) as avg_wait_hours_pending
            FROM pengajuan_surat p
            GROUP BY p.prioritas
            ORDER BY p.prioritas DESC");
        return $this->db->resultSet();
    }
}
