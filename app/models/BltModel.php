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

    public function addProgram($data) {
        $this->db->query('INSERT INTO program_bantuan (nama_program, sumber_dana, periode, total_anggaran, kuota_penerima, status, created_at) VALUES (:nama, :sumber, :periode, :anggaran, :kuota, :status, NOW())');
        $this->db->bind('nama', $data['nama_program']);
        $this->db->bind('sumber', $data['sumber_dana']);
        $this->db->bind('periode', $data['periode']);
        $this->db->bind('anggaran', $data['total_anggaran'] ?? 0);
        $this->db->bind('kuota', $data['kuota_penerima'] ?? 0);
        $this->db->bind('status', $data['status'] ?? 'direncanakan');
        return $this->db->execute();
    }

    public function deleteProgram($id_program) {
        $this->db->query('DELETE FROM program_bantuan WHERE id_program = :id');
        $this->db->bind('id', $id_program);
        return $this->db->execute();
    }

    public function getKriteria() {
        $this->db->query('SELECT * FROM kriteria_bantuan');
        return $this->db->resultSet();
    }

    public function addKriteria($data) {
        $this->db->query('INSERT INTO kriteria_bantuan (nama_kriteria, bobot, tipe_kriteria, created_at) VALUES (:nama, :bobot, :tipe, NOW())');
        $this->db->bind('nama', $data['nama_kriteria']);
        $this->db->bind('bobot', $data['bobot']);
        $this->db->bind('tipe', $data['tipe_kriteria']);
        return $this->db->execute();
    }

    public function deleteKriteria($id_kriteria) {
        $this->db->query('DELETE FROM kriteria_bantuan WHERE id_kriteria = :id');
        $this->db->bind('id', $id_kriteria);
        return $this->db->execute();
    }

    public function getCalonPenerima($id_program) {
        $this->db->query('SELECT c.*, w.nama_lengkap, w.nik FROM calon_penerima c JOIN warga w ON c.id_warga = w.id_warga WHERE c.id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        return $this->db->resultSet();
    }

    public function addCalonPenerima($id_program, $id_warga) {
        $this->db->query('INSERT INTO calon_penerima (id_warga, id_program, tanggal_usulan, status, created_at) VALUES (:id_warga, :id_program, CURDATE(), \'diusulkan\', NOW())');
        $this->db->bind('id_warga', $id_warga);
        $this->db->bind('id_program', $id_program);
        return $this->db->execute();
    }

    public function updateStatusCalon($id_calon, $status) {
        $this->db->query('UPDATE calon_penerima SET status = :status, updated_at = NOW() WHERE id_calon = :id_calon');
        $this->db->bind('status', $status);
        $this->db->bind('id_calon', $id_calon);
        return $this->db->execute();
    }

    public function saveNilaiKriteria($id_calon, $id_kriteria, $nilai_asli) {
        $this->db->query('SELECT id_nilai FROM nilai_kriteria_calon WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $exists = $this->db->single();

        if ($exists) {
            $this->db->query('UPDATE nilai_kriteria_calon SET nilai_asli = :nilai, updated_at = NOW() WHERE id_calon = :id_calon AND id_kriteria = :id_kriteria');
        } else {
            $this->db->query('INSERT INTO nilai_kriteria_calon (id_calon, id_kriteria, nilai_asli, created_at) VALUES (:id_calon, :id_kriteria, :nilai, NOW())');
        }

        $this->db->bind('id_calon', $id_calon);
        $this->db->bind('id_kriteria', $id_kriteria);
        $this->db->bind('nilai', $nilai_asli);
        return $this->db->execute();
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

        $this->finalizeCalonStatus($id_program);

        return $results;
    }

    private function finalizeCalonStatus($id_program) {
        $this->db->query('SELECT kuota_penerima FROM program_bantuan WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $program = $this->db->single();
        $kuota = (int)($program['kuota_penerima'] ?? 0);

        $this->db->query('UPDATE calon_penerima SET status = \'tidak_terpilih\', updated_at = NOW() WHERE id_program = :id_program');
        $this->db->bind('id_program', $id_program);
        $this->db->execute();

        if ($kuota <= 0) return;

        $this->db->query('SELECT id_calon FROM hasil_saw_blt WHERE id_program = :id_program ORDER BY ranking ASC LIMIT ' . $kuota);
        $this->db->bind('id_program', $id_program);
        $top = $this->db->resultSet();

        foreach ($top as $row) {
            $this->db->query('UPDATE calon_penerima SET status = \'terpilih\', updated_at = NOW() WHERE id_program = :id_program AND id_calon = :id_calon');
            $this->db->bind('id_program', $id_program);
            $this->db->bind('id_calon', $row['id_calon']);
            $this->db->execute();
        }
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

    public function getHasilByNik($nik) {
        $this->db->query('SELECT h.*, p.nama_program, p.periode, w.nama_lengkap 
                          FROM hasil_saw_blt h 
                          JOIN calon_penerima c ON h.id_calon = c.id_calon 
                          JOIN program_bantuan p ON h.id_program = p.id_program 
                          JOIN warga w ON c.id_warga = w.id_warga 
                          WHERE w.nik = :nik 
                          ORDER BY h.created_at DESC');
        $this->db->bind('nik', $nik);
        return $this->db->resultSet();
    }
}
