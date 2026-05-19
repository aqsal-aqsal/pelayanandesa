<?php

class BltModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPrograms() {
        $this->db->query('SELECT * FROM program_bantuan ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getKriteria() {
        $this->db->query('SELECT * FROM kriteria_bantuan');
        return $this->db->resultSet();
    }

    public function getCalonPenerima($id_program) {
        $this->db->query('SELECT c.*, w.nama_lengkap, w.nik FROM calon_penerima c JOIN warga w ON c.id_warga = w.id_warga WHERE c.id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        return $this->db->resultSet();
    }

    public function getNilaiKriteria($id_calon) {
        $this->db->query('SELECT n.*, k.nama_kriteria, k.bobot, k.tipe_kriteria FROM nilai_kriteria_calon n JOIN kriteria_bantuan k ON n.id_kriteria = k.id_kriteria WHERE n.id_calon = :id_calon');
        $this->db->bind('id_calon', $id_calon);
        return $this->db->resultSet();
    }

    /**
     * SAW Calculation Logic
     */
    public function calculateSAW($id_program) {
        $calon = $this->getCalonPenerima($id_program);
        $kriteria = $this->getKriteria();
        
        if (empty($calon) || empty($kriteria)) return false;

        // 1. Get all values for normalization
        $matrix = [];
        $max_min = [];

        foreach ($kriteria as $k) {
            $vals = [];
            foreach ($calon as $c) {
                $this->db->query('SELECT nilai_asli FROM nilai_kriteria_calon WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
                $this->db->bind('id_calon', $c['id_calon']);
                $this->db->bind('id_kriteria', $k['id_kriteria']);
                $val = $this->db->single()['nilai_asli'] ?? 0;
                $matrix[$c['id_calon']][$k['id_kriteria']] = $val;
                $vals[] = $val;
            }
            if ($k['tipe_kriteria'] == 'benefit') {
                $max_min[$k['id_kriteria']] = max($vals);
            } else {
                $max_min[$k['id_kriteria']] = min($vals);
            }
        }

        // 2. Normalize and calculate final score
        $results = [];
        foreach ($calon as $c) {
            $total_score = 0;
            foreach ($kriteria as $k) {
                $val = $matrix[$c['id_calon']][$k['id_kriteria']];
                $norm = 0;
                if ($k['tipe_kriteria'] == 'benefit') {
                    $norm = ($max_min[$k['id_kriteria']] != 0) ? $val / $max_min[$k['id_kriteria']] : 0;
                } else {
                    $norm = ($val != 0) ? $max_min[$k['id_kriteria']] / $val : 0;
                }
                
                // Save normalization back to DB if needed
                $this->updateNormalization($c['id_calon'], $k['id_kriteria'], $norm);
                
                $total_score += ($norm * ($k['bobot'] / 100));
            }
            $results[] = [
                'id_calon' => $c['id_calon'],
                'id_program' => $id_program,
                'nilai_total' => $total_score
            ];
        }

        // 3. Sort by score descending
        usort($results, function($a, $b) {
            return $b['nilai_total'] <=> $a['nilai_total'];
        });

        // 4. Save results to hasil_saw_blt
        $this->saveSawResults($id_program, $results);

        return $results;
    }

    private function updateNormalization($id_calon, $id_kriteria, $nilai_norm) {
        $this->db->query('UPDATE nilai_kriteria_calon SET nilai_normalisasi = :norm WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        $this->db->bind('norm', $nilai_norm);
        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $this->db->execute();
    }

    private function saveSawResults($id_program, $results) {
        // Clear old results for this program
        $this->db->query('DELETE FROM hasil_saw_blt WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $this->db->execute();

        foreach ($results as $index => $res) {
            $this->db->query('INSERT INTO hasil_saw_blt (id_program, id_calon, nilai_total, ranking) VALUES (:id_program, :id_calon, :nilai, :rank)');
            $this->db->bind('id_program', $id_program);
            $this->db->bind('id_calon', $res['id_calon']);
            $this->db->bind('nilai', $res['nilai_total']);
            $this->db->bind('rank', $index + 1);
            $this->db->execute();
        }
    }

    public function getHasilSAW($id_program) {
        $this->db->query('SELECT h.*, w.nama_lengkap, w.nik FROM hasil_saw_blt h JOIN calon_penerima c ON h.id_calon = c.id_calon JOIN warga w ON c.id_warga = w.id_warga WHERE h.id_program = :id_program ORDER BY h.ranking ASC');
        $this->db->bind('id_program', $id_program);
        return $this->db->resultSet();
    }
}
